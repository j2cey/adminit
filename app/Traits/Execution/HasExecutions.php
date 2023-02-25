<?php


namespace App\Traits\Execution;

use App\Models\Execution;
use Illuminate\Support\Facades\Auth;

trait HasExecutions
{
    public function executions() {
        $elem_type = get_called_class();
        return $this->belongsToMany(Execution::class, 'model_has_executions', 'model_id', 'execution_id')
            ->wherePivot('model_type', $elem_type)
            ->withPivot('model_type','model_id','posi')
            ->withTimestamps()
            ->orderBy('posi','asc');
    }

    public function addExecution($execution)
    {
        if (empty($execution)) {
            return false;
        }

        $elem_type = get_called_class();
        // Retrieve the currently authenticated user's ID...
        $id = Auth::id();

        $executions_count = $this->executions()->count();

        $this->executions()->attach($execution->id, [
            'model_type' => $elem_type,
            'model_id' => $this->id,
            'posi' => $executions_count,
        ]);
        return $execution;
    }

    public function removeExecution($execution) {
        $this->executions()->detach($execution->id);
        $execution->delete();
    }
}
