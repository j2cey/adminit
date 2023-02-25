<?php

namespace Database\Seeders;

use App\Models\Appreciation;
use Illuminate\Database\Seeder;

class AppreciationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("very poor", 0, false, "very poor");
        $this->createNew("poor", 1, false, "poor");
        $this->createNew("neutral", 2, true, "neutral");
        $this->createNew("goog", 3, false, "goog");
        $this->createNew("very goog", 4, false, "very goog");
    }

    private function createNew($title, $level, $is_default = false, $description = null) {
        $data = ['title'  => $title, 'level' => $level, 'is_default' => $is_default];
        if (! is_null($description)) { $data['description'] = $description; }
        return Appreciation::create($data);
    }
}
