<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Department;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function department($department)
    {
        // Asegura que el departamento esté activo
        $department = Department::active()->where('slug', $department)->firstOrFail();

        // Obtiene productos en oferta
        $offers_product = $department->products()->selectForCard()->activeInStock()
            ->inOffer()->limit(15)->get();

        // Obtiene productos más vendidos
        $best_sellers_product = $department->products()
            ->selectForCard()
            ->activeInStock()
            ->bestSeller()
            ->limit(10)
            ->get();

        // Obtiene las categorías activas con productos
        $categories = Category::active()
            ->withWhereHas('products', function ($query) use ($department) {
                $query->activeInStock()->where('department_id', $department->id);
            })
            ->get()
            ->map(function ($item) {
                $item->setRelation('products', $item->products->take(10));
                return $item;
            })
            ->filter(fn (Category $category) => $category->products->isNotEmpty());

        return Inertia::render('Department/Department', [
            'department' => $department,
            'offertProduct' => ProductResource::collection($offers_product),
            'bestSellersProduct' => $best_sellers_product,
            'categories' => $categories,
        ]);
    }
}
