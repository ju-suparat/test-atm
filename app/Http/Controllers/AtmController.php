<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repos\NoteRepository;
use Illuminate\Support\Facades\Validator;

class AtmController extends Controller
{
    protected $noteRepo;

    /**
     * AtmController constructor.
     *
     * @param NoteRepository $noteRepo
     */
    function __construct(NoteRepository $noteRepo)
    {
        $this->noteRepo = $noteRepo;
    }

    /**
     * @return mixed
     */
    function index()
    {
        $notes = $this->noteRepo->listAllNotes();

        return view('atm', ['notes' => $notes]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    function withdraw(Request $request)
    {
        /**
         * Validate request
         */
        $validator = Validator::make($request->all(), [
            'withdrawAmount' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator);
        }

        /**
         * Get post withdraw amount
         */
        $withdrawAmount = $request->input('withdrawAmount');

        $result = $this->noteRepo->withdraw($withdrawAmount);

        if ($result === false) {
            return redirect('/')
                ->withErrors(["Insufficient Notes For $withdrawAmount THB"]);
        }

        return redirect('/')->with('notesList', $result);
    }
}
