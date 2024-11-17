<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function destroy(Comment $comment)
                {
                    // Delete the comment
                    $comment->delete();

                    // Redirect back with a success message
                    return redirect()->route('dashboard')->with('success', 'Comment deleted successfully!');
                }
}
