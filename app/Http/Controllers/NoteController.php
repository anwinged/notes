<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Note;

class NoteController extends Controller
{
    public function index()
    {
        return Note::all();
    }
}
