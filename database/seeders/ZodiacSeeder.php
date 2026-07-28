<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ZodiacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the exact Gurung Bargas dataset
        $bargas = [
            'च्यु ल्हो (मुसा बर्ग)',
            'ल्वों ल्हो (गाई बर्ग)',
            'तो ल्हो (बाघ बर्ग)',
            'हि ल्हो (बिरालो बर्ग)',
            'मुप्रि ल्हो (गिद्ध बर्ग)',
            'सप्रि ल्हो (सर्प बर्ग)',
            'त ल्हो (घोडा बर्ग)',
            'ल्हु ल्हो (भेडा बर्ग)',
            'प्र ल्हो (बादर बर्ग)',
            'च्य ल्हो (चरा बर्ग)',
            'खी ल्हो (कुकुर बर्ग)',
            'फो ल्हो (मृग बर्ग)',
        ];

        // Format data with timestamps for database insertion
        $dataToInsert = array_map(function ($title) {
            return [
                'title' => $title,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $bargas);

        DB::table('zodiacs')->insert($dataToInsert);
    }
}
