<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlantDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Data Tanaman (Species) Dulu
        // Kita butuh ID 1, 2, dan 3 agar cocok dengan dummy issues
        $species = [
            [
                'id' => 1,
                'name' => 'Tomat Cherry',
                'scientific_name' => 'Solanum lycopersicum var. cerasiforme',
                'description' => 'Tomat berukuran kecil dengan rasa manis segar, cocok untuk pemula.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/Tomato_je.jpg/1200px-Tomato_je.jpg',
                'soil_recommendation' => 'Tanah gembur, pH 6.0-6.8',
                'planting_distance' => '50 cm',
                'sunlight_needs' => 'Full Sun (6-8 jam)',
                'optimal_temp_min' => 20,
                'optimal_temp_max' => 28,
                'harvest_duration_days' => 70,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Jagung Manis',
                'scientific_name' => 'Zea mays saccharata',
                'description' => 'Tanaman pangan penghasil karbohidrat dengan rasa manis.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Corn_Cob_01.jpg/800px-Corn_Cob_01.jpg',
                'soil_recommendation' => 'Tanah lempung berpasir, kaya humus',
                'planting_distance' => '70 x 20 cm',
                'sunlight_needs' => 'Full Sun',
                'optimal_temp_min' => 21,
                'optimal_temp_max' => 30,
                'harvest_duration_days' => 65,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Cabai Rawit',
                'scientific_name' => 'Capsicum frutescens',
                'description' => 'Cabai kecil dengan tingkat kepedasan tinggi.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/01/Capsicum_frutescens_fruits.jpg/800px-Capsicum_frutescens_fruits.jpg',
                'soil_recommendation' => 'Tanah gembur, drainase baik',
                'planting_distance' => '50 x 50 cm',
                'sunlight_needs' => 'Full Sun',
                'optimal_temp_min' => 24,
                'optimal_temp_max' => 30,
                'harvest_duration_days' => 90,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('plant_species')->insertOrIgnore($species);

        // 2. Buat Data Penyakit (Issues) - Copy dari JSON Dummy kamu
        $issues = [
            [
                'species_id' => 1,
                'name' => 'Layu Fusarium',
                'scientific_name' => 'Fusarium oxysporum',
                'symptoms' => 'Daun menguning mulai dari bagian bawah, tanaman layu di siang hari tetapi segar kembali di pagi hari, lama-kelamaan mati.',
                'cause' => 'Jamur patogen dalam tanah yang menyerang jaringan pengangkut air.',
                'solution' => 'Cabut dan musnahkan tanaman yang sakit. Kocor tanah dengan fungisida hayati (Trichoderma).',
                'prevention' => 'Lakukan rotasi tanaman, gunakan bibit tahan penyakit.',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => 1,
                'name' => 'Bercak Daun Alternaria',
                'scientific_name' => 'Alternaria solani',
                'symptoms' => 'Muncul bercak coklat melingkar pada daun tua dengan pola seperti papan target.',
                'cause' => 'Jamur yang berkembang pesat pada kondisi lembab.',
                'solution' => 'Pangkas daun terinfeksi. Semprotkan fungisida mankozeb.',
                'prevention' => 'Hindari penyiraman dari atas (sprinkle).',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => null, // Penyakit Umum
                'name' => 'Kutu Putih (Mealybugs)',
                'scientific_name' => 'Pseudococcidae',
                'symptoms' => 'Serangga putih seperti kapas menempel pada batang atau balik daun.',
                'cause' => 'Hama penghisap cairan tanaman.',
                'solution' => 'Semprot air sabun cuci piring + minyak goreng.',
                'prevention' => 'Rutin cek balik daun.',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => 2, // Jagung
                'name' => 'Ulat Grayak',
                'scientific_name' => 'Spodoptera litura',
                'symptoms' => 'Daun berlubang tidak beraturan, tersisa tulang daun.',
                'cause' => 'Larva ngengat memakan daun.',
                'solution' => 'Ambil manual atau pakai insektisida BT.',
                'prevention' => 'Pasang perangkap lampu.',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => null,
                'name' => 'Busuk Akar',
                'scientific_name' => 'Phytophthora spp.',
                'symptoms' => 'Tanaman layu mendadak, batang bawah busuk hitam.',
                'cause' => 'Tanah terlalu basah (waterlogging).',
                'solution' => 'Kurangi siram, bongkar media tanam.',
                'prevention' => 'Gunakan media porous.',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => 3, // Cabai
                'name' => 'Virus Kuning (Gemini)',
                'scientific_name' => 'Gemini Virus',
                'symptoms' => 'Daun muda kuning cerah, mengkerut, kerdil.',
                'cause' => 'Virus dari kutu kebul.',
                'solution' => 'Cabut dan bakar tanaman. Tidak ada obat.',
                'prevention' => 'Pakai mulsa perak, basmi kutu kebul.',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => null,
                'name' => 'Tungau Laba-laba',
                'scientific_name' => 'Tetranychus urticae',
                'symptoms' => 'Bintik kuning halus, ada jaring halus.',
                'cause' => 'Hama mikroskopis saat panas kering.',
                'solution' => 'Semprot air bertekanan atau akarisida.',
                'prevention' => 'Jaga kelembaban (misting).',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => 1,
                'name' => 'Busuk Buah Antraknosa',
                'scientific_name' => 'Colletotrichum spp.',
                'symptoms' => 'Cekungan melingkar hitam pada buah.',
                'cause' => 'Jamur saat hujan.',
                'solution' => 'Buang buah busuk. Fungisida tembaga.',
                'prevention' => 'Pakai naungan plastik UV.',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => null,
                'name' => 'Lalat Buah',
                'scientific_name' => 'Bactrocera spp.',
                'symptoms' => 'Buah busuk di dalam ada belatung.',
                'cause' => 'Lalat suntik telur ke buah.',
                'solution' => 'Perangkap Petrogenol.',
                'prevention' => 'Bungkus buah (brongsong).',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ],
            [
                'species_id' => null,
                'name' => 'Embun Tepung',
                'scientific_name' => 'Erysiphales',
                'symptoms' => 'Lapisan serbuk putih di daun.',
                'cause' => 'Jamur kondisi lembab.',
                'solution' => 'Semprot larutan susu atau sulfur.',
                'prevention' => 'Pangkas daun rimbun.',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ]
        ];

        DB::table('plant_issues')->insertOrIgnore($issues);
    }
}