<?php

use Illuminate\Database\Seeder;

use App\Province;
use App\City;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::truncate();
        City::truncate();

        $provinces = RajaOngkir::provinsi()->all();
        foreach ($provinces as $province) {
            $provinsi = [
                'province_id' => $province['province_id'],
                'province' => $province['province']
            ];
            Province::create($provinsi);
            
            $cities = RajaOngkir::kota()->dariProvinsi($province['province_id'])->get();
            foreach ($cities as $city) {
                $kota = [
                    'city_id' => $city['city_id'],
                    'province_id' => $province['province_id'],
                    'province' => $province['province'],
                    'type' => $city['type'],
                    'city_name' => $city['city_name'],
                    'postal_code' => $city['postal_code']
                ];
                City::create($kota);
            }
        }
    }
}
