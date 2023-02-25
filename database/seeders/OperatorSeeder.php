<?php

namespace Database\Seeders;

use App\Models\Operator;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNew("plus", "plus", "+", "Plus operator");
        $this->createNew("minus", "minus", "-", "Minus operation");
        $this->createNew("multiply", "multiply", "*", "Multiplication operation");
        $this->createNew("divide", "divide", "/", "Division operation");
    }

    private function createNew($title, $code, $symbol, $description = null) {
        $data = ['title'  => $title, 'code' => $code, 'symbol' => $symbol];
        if (! is_null($description)) { $data['description'] = $description; }
        return Operator::create($data);
    }
}
