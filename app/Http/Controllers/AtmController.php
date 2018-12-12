<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repos\NoteRepository;

class AtmController extends Controller
{
    protected $noteRepo;

    function __construct(NoteRepository $noteRepo)
    {
        $this->noteRepo = $noteRepo;
    }

    function index()
    {
        $notes = $this->noteRepo->listAllNotes();

        return view('atm', ['notes' => $notes]);
    }
}
