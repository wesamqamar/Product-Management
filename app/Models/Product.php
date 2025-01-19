<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    public function scopeFilter(Builder $builder, array $filters)
    {
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $this->applyFilter($builder, $key, $value);
            }
        }
    }

    protected function applyFilter(Builder $builder, string $key, string $value)
    {
        $builder->when($key === 'name', fn ($query) => $query->where('name', 'like', "%{$value}%"))
                ->when($key === 'description', fn ($query) => $query->where('description', 'like', "%{$value}%"));
    }
}
