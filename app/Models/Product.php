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
                $builder->when(
                    $key === 'name',
                    fn($query) => $query->where('name', 'like', "%{$value}%")
                );

                $builder->when(
                    $key === 'description',
                    fn($query) => $query->where('description', 'like', "%{$value}%")
                );
            }
        }
    }

}
