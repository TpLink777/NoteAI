<?php

namespace App\Services;

use App\Models\Categories;
use Illuminate\Support\Str;

class CategoriesServices
{

    public function getAllCategories()
    {
        return Categories::where('user_id', auth()->id())->paginate(10);
    }

    public function getCategoryById($id)
    {
        return Categories::where('user_id', auth()->id())->findOrFail($id);
    }


    public function createCategory(array $data)
    {
        return Categories::create([
            'name' => Str::lower($data['name']),
            'user_id' => auth()->id(), //! obtenemos el ID del usuario logueado
        ]);
    }

    public function editCategory(int $id, array $data)
    {
        $category = Categories::where('user_id', auth()->id())->findOrFail($id);

        return $category->update([
            'name' => Str::lower($data['name']),
            'status' => $data['status']
        ]);
    }


    public function deleteCategory($id)
    {
        return Categories::findOrFail($id)->delete();
    }


    public function getAllCategoriesActives()
    {
        return Categories::where([
            'user_id' => auth()->id(),
            'status' => 'active'
        ])->get();
    }
}
