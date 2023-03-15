<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportFile\FileMimeType;

class FileMimeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("jpg", "jpg","Mimes des fichiers JPEG");
        $this->createNew("bmp", "bmp","Mimes des fichiers BMP");
        $this->createNew("png", "png","Mimes des fichiers PNG");
        $this->createNew("csv,txt", 'csv,txt',"Mimes des fichiers CSV");
    }

    private function createNew($name, $code, $description = null) {
        FileMimeType::createNew($name, $code, $description);
    }
}
