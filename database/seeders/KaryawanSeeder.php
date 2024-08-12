<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $karyawans = [
            ['name' => 'Ratih', 'phone'=>'083141729832','position'=>'pegawai honorer','division' => 'Mobile Apps'],
            ['name' => 'Rafli', 'phone'=>'089763572189','position'=>'pegawai tetap','division' => 'QA']
        ];

        foreach ($karyawans as $karyawan) {
            $division = Division::where('name', $karyawan['division'])->first();

            if ($division) {
                Karyawan::create([
                    'name' => $karyawan['name'],
                    'phone'=> $karyawan['phone'],
                    'position'=> $karyawan['position'],
                    'division_id' => $division->id,
                ]);
            }
        }
    }
}
