<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NoteServices;
use Illuminate\Support\Facades\Log;

class NotesController extends Controller
{

    private $notes;

    public function __construct(NoteServices $notes)
    {
        $this->notes = $notes;
    }

    public function index()
    {
        try {
            $notes = $this->notes->getAllNotes();
            return view('pages.dashboard.pages.notes.index', compact('notes'));
        } catch (\Exception $e) {

            Log::error('Error al obtener las notas ' . $e->getMessage());

            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function createPage()
    {
        try {
            $categories = $this->notes->getAllCategories();
            return view('pages.dashboard.pages.notes.create', compact('categories'));
        } catch (\Exception $e) {

            Log::error('Error al obtener las categorías ' . $e->getMessage());

            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function editPage($id)
    {
        try {
            $note = $this->notes->getNoteById($id);
            $categories = $this->notes->getAllCategories();
            return view('pages.dashboard.pages.notes.edit', compact('note', 'categories'));
        } catch (\Exception $e) {

            Log::error('Error al obtener la nota ' . $e->getMessage());

            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }


    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        try {
            $this->notes->createNote($validatedData);
            return redirect()->route('notes.index')->with('success', 'Nota creada correctamente');
        } catch (\Exception $e) {

            Log::error('Error al crear la nota ' . $e->getMessage());

            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function deleteNote($id)
    {
        try {
            $this->notes->deleteNote($id);
            return redirect()->route('notes.index')->with('success', 'Nota eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar la nota ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:active,inactive',
        ]);
        try {
            $this->notes->updateNote($id, $validatedData);
            return redirect()->route('notes.index')->with('success', 'Nota actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar la nota ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }
}
