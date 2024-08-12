<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [
            ['name' => 'Mobile Apps'],
            ['name' => 'QA'],
            ['name' => 'Full Stack'],
            ['name' => 'Backend'],
            ['name' => 'Frontend'],
            ['name' => 'UI/UX Designer'],
        ];

        foreach($divisions as $d)
        {
            Division::create($d);
        }
    }
}
