<?php

namespace App\Http\Controllers;

use App\Services\CategoriesServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(CategoriesServices $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        try {
            $categories = $this->category->getAllCategories();
            return view('pages.dashboard.pages.category.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error al obtener las categorías ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function createPage()
    {
        try {
            return view('pages.dashboard.pages.category.create');
        } catch (\Exception $e) {
            Log::error('Error al obtener las categorías ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function create(Request $request)
    {

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $this->category->createCategory($validated);

            return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al crear la categoría ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }


    public function editPage($id)
    {
        try {
            $category = $this->category->getCategoryById($id);
            return view('pages.dashboard.pages.category.edit', compact('category'));
        } catch (\Exception $e) {
            Log::error('Error al obtener la categoría ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }


    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            $this->category->editCategory($id, $validated);
            return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al editar la categoría ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function deleteCategory($id)
    {
        try {
            $this->category->deleteCategory($id);
            return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar la categoría ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }


    public function getCtegoriesActives()
    {
        try {
            $categories = $this->category->getAllCategoriesActives();
            return view('pages.dashboard.start', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error al obtener las categorías ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }
}
