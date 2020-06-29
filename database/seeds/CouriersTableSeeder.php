<?php

use Illuminate\Database\Seeder;

use App\Courier;

class CouriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Courier::truncate();

        $data = [
            [
                'code' => 'jne',
                'name' => 'JNE',
            ],
            [
                'code' => 'pos',
                'name' => 'POS',
            ],
            [
                'code' => 'tiki',
                'name' => 'TIKI',
            ],
        ];

        Courier::insert($data);
    }
}
