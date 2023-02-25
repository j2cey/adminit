<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("lowest", 0, false, "Lowest priority");
        $this->createNew("low", 1, false, "Low priority");
        $this->createNew("normal", 2, true, "Normal / Medium / Standard / Average / Intermediate");
        $this->createNew("high", 3, false, "High priority");
        $this->createNew("highest", 4, false, "Highest priority");
    }

    private function createNew($title, $level, $is_default, $description = null) {
        $data = ['title'  => $title, 'level' => $level, 'is_default' => $is_default];
        if (! is_null($description)) { $data['description'] = $description; }
        return Priority::create($data);
    }
}
