<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'banner',
        'title',
        'entry',
        'img',
        'active',
    ];

    // Relación con los productos
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Relación con las categorías
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    // Relación con categorías activas
    public function categories_active(): HasMany
    {
        return $this->hasMany(Category::class)->where('active', true);
    }

    // Scope para obtener departamentos activos
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
