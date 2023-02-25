<?php

namespace Database\Seeders;

use App\Models\GoalType;
use Illuminate\Database\Seeder;

class GoalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("duration", "duration", "Duration Goal Type");
        $this->createNew("grade", "grade", "Grade Goal Type");
    }

    private function createNew($title, $code, $description = null) {
        $data = ['title'  => $title, 'code' => $code];
        if (! is_null($description)) { $data['description'] = $description; }
        return GoalType::create($data);
    }
}
