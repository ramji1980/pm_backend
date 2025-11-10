<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    /**
     * Get all comments.
     */
    public function getAll(): Collection
    {
        return Comment::latest()->get();
    }

    /**
     * Get comments by task ID.
     */
    public function getByTaskId(int $taskId): Collection
    {
        return Comment::where('task_id', $taskId)
                      ->latest()
                      ->get();
    }

    /**
     * Get a single comment by ID.
     */
    public function getById(int $id): ?Comment
    {
        return Comment::find($id);
    }

    /**
     * Create a new comment.
     */
    public function create(array $data): Comment
    {
        return DB::transaction(function () use ($data) {
            return Comment::create($data);
        });
    }

    /**
     * Update a comment.
     */
    public function update(Comment $comment, array $data): Comment
    {
        return DB::transaction(function () use ($comment, $data) {
            $comment->update($data);
            return $comment;
        });
    }

    /**
     * Delete a comment.
     */
    public function delete(Comment $comment): bool
    {
        return DB::transaction(function () use ($comment) {
            return $comment->delete();
        });
    }
}
