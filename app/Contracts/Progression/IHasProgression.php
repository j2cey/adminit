<?php

namespace App\Contracts\Progression;

use App\Models\Status;
use App\Models\Progression\Progression;

interface IHasProgression
{
    public function progression();
    public function setProgression(int $nb_todo = null, string $description = null, Status $status = null): ?Progression;
    public function setUpperProgression(Progression|null $progression);

    public function progressionAddTodo(int $amount, string $name);
    public function progressionAddStepDone(string $name, bool $passed, string|null $description);
}
