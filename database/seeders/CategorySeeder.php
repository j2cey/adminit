<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("English Learning", "English Learning category");
        $this->createNew("JAVA Programming", "JAVA Programming category");
        $this->createNew("LINUX Learning", "LINUX Learning category");
    }

    private function createNew($title, $description = null) {
        $data = ['title'  => $title];
        if (! is_null($description)) { $data['description'] = $description; }
        return Category::create($data);
    }
}
