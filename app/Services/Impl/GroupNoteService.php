<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the Group service.
 */
class GroupNoteService extends BaseService implements IGroupNoteService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\GroupNote::class;
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
            'group_id' => $note->group_id,
            'contents' => $addition,
            'is_draft' => 0,
            'note_id' => $note->id,
        ]);
    }
}
