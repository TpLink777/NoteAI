<?php

namespace App\Http\Controllers;

use App\Services\CategoriesServices;
use App\Services\NoteServices;
use Illuminate\Http\Request;

class StartController extends Controller
{

    private  $category;
    private  $note;

    public function __construct(CategoriesServices $category, NoteServices $note)
    {
        $this->category = $category;
        $this->note = $note;
    }


    public function Inicio()
    {
        $categoriesActives = $this->category->getAllCategoriesActives();
        $notes = $this->note->getAllNotesActives();
        return view("pages.dashboard.start", compact("categoriesActives", "notes"));
    }
}
