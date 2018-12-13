<?php

namespace App\Repos;

use App\Note;

class NoteRepository
{
    /**
     * NoteRepository constructor.
     *
     * @param Note $note
     */
    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    /**
     * @param int $id
     * @return Note
     */
    public function find(int $id): Note
    {
        return $this->model->find($id);
    }

    /**
     * @param Note $note
     * @return int
     */
    public function findAmount(Note $note): int
    {
        return $note->amount;
    }

    /**
     * @param string $orderBy
     * @param string $order
     * @return mixed
     */
    public function listAllNotes(string $orderBy = 'value', $order = 'desc')
    {
        return $this->model->orderBy($orderBy, $order)->get();
    }

    /**
     * Return list of notes that can be deducted with given withdraw amount
     * empty array will be returned in case any notes cannot be deducted
     *
     * @param int $withdrawAmount
     *
     * @return array
     */
    public function getDeductNotes(int $withdrawAmount): array
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

            $result[] = ['id' => $note->id, 'note' => $note->value, 'deduct' => (int)$actualUse];
        }

        if ($withdrawAmount > 0) {
            return [];
        }

        return  $result;
    }

    /**
     * Decrement note amount by given notes list with amount to be decreased.
     *
     * @param int $withdrawAmount
     * @return array|bool
     */
    public function withdraw(int $withdrawAmount)
    {
        $list = $this->getDeductNotes($withdrawAmount);

        if (empty($list)) {
            return false;
        }

        foreach ($list as $note) {
            $this->model
                ->where('id', $note['id'])
                ->decrement('amount', $note['deduct']);
        }

        return $list;
    }
}
