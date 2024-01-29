<?php

namespace Database\Seeders;
use App\Models\State;
use App\Models\County;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->truncate();
        DB::table('counties')->truncate();
       $json = File::get(database_path('seeders/counties.json'));
        $data = json_decode($json);

        foreach ($data as $item) {
            $state = State::firstOrCreate(
                ['state_id' => $item->state_id],
                ['state_name' => $item->state_name]
            );

            County::create([
                'county' => $item->county,
                'county_ascii' => $item->county_ascii,
                'county_full' => $item->county_full,
                'county_fips' => $item->county_fips,
                'state_id' => $state->state_id, 
                'state_name' => $state->state_name,
                'lat' => $item->lat,
                'lng' => $item->lng,
                'population' => $item->population,
            ]);
        }
    }
}
