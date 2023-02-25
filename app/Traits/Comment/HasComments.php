<?php

namespace App\Traits\Comment;

use App\Models\Status;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

trait HasComments
{

    public function comments() {
        $elem_type = get_called_class();
        return $this->belongsToMany(Comment::class, 'model_has_comments', 'model_id', 'comment_id')
            ->wherePivot('model_type', $elem_type)
            ->withPivot('model_type','model_id','posi')
            ->withTimestamps()
            ->orderBy('posi','asc');
    }

    public function addNewComment($comment_text, $description = "")
    {
        if (empty($comment_text)) {
            return false;
        }

        $elem_type = get_called_class();
        // Retrieve the currently authenticated user's ID...
        $id = Auth::id();

        $comment = Comment::create([
            'comment_text' => $comment_text,
            'description' => $description,
            'status_id' => Status::active()->first()->id,
            'user_id' => $id,
        ]);

        $comments_count = $this->comments()->count();

        $this->comments()->attach($comment->id, [
            'model_type' => $elem_type,
            'model_id' => $this->id,
            'posi' => $comments_count,
        ]);
        return $comment;
    }

    public function removeComment($comment) {
        $this->comments()->detach($comment->id);
        $comment->delete();
    }
}
