<?php

namespace Database\Seeders;

use App\Models\GradeUnit;
use Illuminate\Database\Seeder;

class GradeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("point (base)", "Point(s)", 1, "The default grade unit for simple point.");
    }

    private function createNew($title, $unit, $unitvalue, $description = null) {
        $relative_expression = "[]";
        $data = ['title'  => $title, 'unit' => $unit, 'unitvalue' => $unitvalue, 'relative_expression' => $relative_expression];
        if (! is_null($description)) { $data['description'] = $description; }
        return GradeUnit::create($data);
    }
}
