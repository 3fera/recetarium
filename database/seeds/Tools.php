<?php

use Illuminate\Database\Seeder;
use App\Models\Tool;

class Tools extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            'Horno',
            'Thermomix',
        ] as $name) {
            Tool::create(['name' => $name]);
        }
    }
}
