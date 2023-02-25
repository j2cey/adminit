<?php

namespace Database\Seeders;

use App\Models\Difficulty;
use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\Types\String_;

class DifficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("easier", 0, false, "Easier Than Easy");
        $this->createNew("easy", 1, false, "Easy / Beginner / Novice");
        $this->createNew("normal", 2, true, "Normal / Medium / Standard / Average / Intermediate");
        $this->createNew("hard", 3, false, "Hard / Expert / Difficult");
        $this->createNew("harder", 4, false, "Harder Than Hard (it may be Unlockable Content that is only revealed after completing the previous difficulty)");
    }

    private function createNew($title, $level, $is_default, $description = null) {
        $data = ['title'  => $title, 'level' => $level, 'is_default' => $is_default];
        if (! is_null($description)) { $data['description'] = $description; }
        return Difficulty::create($data);
    }
}
