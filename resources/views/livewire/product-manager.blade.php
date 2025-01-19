<div>
    <input type="text" wire:model.live="search" placeholder="Search for a product..." class="form-control mb-3">

    <button wire:click="resetInputs" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#productModal">
        Add New Product
    </button>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <button wire:click="editProduct({{ $product->id }})" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#productModal">Edit</button>
                        <button wire:click="deleteProduct({{ $product->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div wire:ignore.self class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">
                        {{ $editMode ? 'Edit Product' : 'Add New Product' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name">Name:</label>
                            <input type="text" wire:model="name" class="form-control">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description">Description:</label>
                            <textarea wire:model="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price">Price:</label>
                            <input type="number" wire:model="price" class="form-control">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @if ($editMode)
                        <button wire:click="updateProduct" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
                    @else
                        <button wire:click="addProduct" class="btn btn-primary" data-bs-dismiss="modal">Add</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
