<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpia las tablas
        Category::truncate();
        Department::truncate();

        // Obtén los productos del archivo JSON
        $products = collect(Storage::json('data/products_with_images.json'));

        // Inserta departamentos asegurándote de incluir 'active'
        $departments = $products->pluck('department')->unique()->map(function ($item) {
            $slug = Str::slug($item);
            return [
                'name' => $item,
                'slug' => $slug,
                'img' => "/img/departments/$slug.png",
                'created_at' => now(),
                'updated_at' => now(),
                'active' => 1, // Asegúrate de asignar 'active'
            ];
        });

        Department::insert($departments->toArray());

        // Obtén los departamentos insertados
        $departments = Department::select('id', 'name')->get()->pluck('id', 'name');

        // Inserta categorías con 'department_id' y otros campos
        $categories = $products->unique('category')->map(function ($item) use ($departments) {
            $slug = Str::slug($item['category']);
            return [
                'name' => $item['category'],
                'slug' => $slug,
                'img' => "img/categories/$slug.png",
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => $departments[$item['department']] ?? null, // Verifica la relación
                'active' => 1, // Asigna 'active' si es necesario
            ];
        });

        Category::insert($categories->toArray());

        // Inserta 5 categorías de tipo 'blog'
        Category::factory()->count(5)->create([
            'type' => 'blog',
            'active' => 1, // Asegura que 'active' esté presente si es necesario
        ]);
    }
}
