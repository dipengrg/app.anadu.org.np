<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ClanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the exact Gurung Bargas dataset
        $clans = [
            'ल्हों',
            'टु-क्ल्हेप्रि',
            'तिंगे',
            'प्हच्यु',
            'पर्जु',
            'थिम्चे',
            'भुज्जा'
        ];

        // Format data with timestamps for database insertion
        $dataToInsert = array_map(function ($title) {
            return [
                'title' => $title,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $clans);

        DB::table('clans')->insert($dataToInsert);
    }
}
