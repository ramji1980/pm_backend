<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Services\CommentService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ApiResponse;

    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of comments (optional: by task).
     */
    public function index(Request $request)
    {
        $taskId = $request->query('task_id');

        $comments = $taskId
            ? $this->commentService->getByTaskId($taskId)
            : $this->commentService->getAll();

        return $this->successResponse($comments, 'Comments retrieved successfully');
    }

    /**
     * Store a newly created comment.
     */
    public function store(Request $request,$taskId)
    {
        $validated = $request->validate([
            'body'    => 'required|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        $task = Task::findOrFail($taskId);
        $validated['task_id'] =  $task->id;

         

        // check if user is assigned to the task
        /*if ($task->assigned_to !== Auth::id()) {
            return $this->errorResponse('Unauthorized. You can only comment on tasks assigned to you.', 403);
        }*/

        $comment = $this->commentService->create($validated);
        return $this->successResponse($comment, 'Comment added successfully', 201);
    }

    /**
     * Display the specified comment.
     */
    public function show(Comment $comment)
    {
        // $this->authorize('view', $comment);
        return $this->successResponse($comment, 'Comment retrieved successfully');
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $updatedComment = $this->commentService->update($comment, $validated);
        return $this->successResponse($updatedComment, 'Comment updated successfully');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $this->commentService->delete($comment);
        return $this->successResponse(null, 'Comment deleted successfully');
    }
}
