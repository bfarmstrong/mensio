<?php

namespace App\Services\Impl;

use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Implementation of the note service.
 */
class NoteService extends BaseService implements INoteService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Note::class;
    }

    /**
     * Adds a new note as a child of an existing note.
     *
     * @param mixed  $note
     * @param string $addition
     *
     * @return Model
     */
    public function addAddition($note, string $addition)
    {
        $note = $this->find($note);

        return $this->create([
            'client_id' => $note->client_id,
            'contents' => $addition,
            'is_draft' => 0,
            'note_id' => $note->id,
            'therapist_id' => $note->therapist_id,
        ]);
    }
}
