<?php

namespace App\Repos;

use App\Note;

class NoteRepository
{
    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    public function find(int $id): Note
    {
        return $this->model->find($id);
    }

    public function findAmount(Note $note): int
    {
        return $note->amount;
    }

    public function listAllNotes(string $orderBy = 'value', $order = 'desc')
    {
        return $this->model->orderBy($orderBy, $order)->get();
    }

    public function withdraw(int $withdrawAmount): array
    {
        $notes  = $this->listAllNotes();
        $result = [];

        foreach ($notes as $note) {
            if ($note->amount === 0) {
                continue;
            }

            if ($note->value > $withdrawAmount) {
                continue;
            }

            $consume        = floor($withdrawAmount / $note->value);
            $actualUse      = $note->amount < $consume ? $note->amount : $consume;
            $withdrawAmount -= $note->value * $actualUse;

            $result[] = ['id' => $note->id, 'note' => $note->value, 'deduct' => $actualUse];
        }

        return  $result;
    }
}
