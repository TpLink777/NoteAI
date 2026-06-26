<?php

namespace App\Services;

use App\Models\Note;
use App\Models\Categories;

class NoteServices
{
    public function getAllNotes()
    {
        // Paginamos de a 6 para evitar que se cree scroll vertical en resoluciones normales (2 filas de 3 tarjetas)
        return Note::with('category')
            ->where('user_id', auth()->id())
            ->latest() //! metodo para obtener las notas en orden descendente (mas reciente primero)
            ->paginate(6);
    }

    public function getAllCategories()
    {
        return Categories::where([
            'user_id' => auth()->id(),
            'status' => 'active'
        ])->get();
    }

    public function getNoteById(int $noteId)
    {
        return Note::with('category')
            ->where('user_id', auth()->id())
            ->findOrFail($noteId);
    }

    public function createNote(array $data)
    {
        return Note::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => auth()->id(),
            'category_id' => $data['category_id'] ?? null
        ]);
    }

    public function updateNote(int $noteId, array $data)
    {
        $note = $this->getNoteById($noteId);
        $note->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'category_id' => $data['category_id'] ?? null,
            'status' => $data['status']
        ]);
        return $note;
    }

    public function deleteNote(int $noteId)
    {
        return $this->getNoteById($noteId)->delete();
    }


    public function getAllNotesActives()
    {
        return Note::where([
            'user_id' => auth()->id()
        ])->get();
    }
}
