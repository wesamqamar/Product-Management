<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductManager extends Component
{
    use WithPagination;

    public $name, $description, $price;
    public $search = '';
    public $editMode = false;
    public $productId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
    ];

    public function render()
    {
        $products = $this->getFilteredProducts();
        return view('livewire.product-manager', compact('products'));
    }

    protected function getFilteredProducts()
    {
        return Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function addProduct()
    {
        $this->validate($this->rules);
        Product::create($this->getProductData());
        $this->flashMessage('Product added successfully!');
        $this->resetInputs();
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->setProductData($product);
        $this->editMode = true;
    }

    public function updateProduct()
    {
        $this->validate($this->rules);
        $product = Product::findOrFail($this->productId);
        $product->update($this->getProductData());
        $this->flashMessage('Product updated successfully!');
        $this->resetInputs();
    }

    public function deleteProduct($id)
    {
        Product::destroy($id);
        $this->flashMessage('Product deleted successfully!');
    }

    protected function getProductData()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ];
    }

    protected function setProductData(Product $product)
    {
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
    }

    protected function flashMessage($message)
    {
        session()->flash('message', $message);
    }

    public function resetInputs()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->editMode = false;
        $this->productId = null;
    }
}
