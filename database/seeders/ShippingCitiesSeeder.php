<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingCity;

class ShippingCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // SUMATERA UTARA
            ['city_name' => 'Medan', 'shipping_cost' => 12000],
            ['city_name' => 'Binjai', 'shipping_cost' => 13000],
            ['city_name' => 'Pematangsiantar', 'shipping_cost' => 14000],
            ['city_name' => 'Tebing Tinggi', 'shipping_cost' => 13500],
            ['city_name' => 'Sibolga', 'shipping_cost' => 15000],

            // SUMATERA BARAT
            ['city_name' => 'Padang', 'shipping_cost' => 15000],
            ['city_name' => 'Bukittinggi', 'shipping_cost' => 16000],
            ['city_name' => 'Payakumbuh', 'shipping_cost' => 15500],
            ['city_name' => 'Pariaman', 'shipping_cost' => 15000],

            // RIAU
            ['city_name' => 'Pekanbaru', 'shipping_cost' => 14000],
            ['city_name' => 'Dumai', 'shipping_cost' => 15000],

            // JAMBI
            ['city_name' => 'Jambi', 'shipping_cost' => 16000],
            ['city_name' => 'Sungai Penuh', 'shipping_cost' => 17000],

            // SUMATERA SELATAN
            ['city_name' => 'Palembang', 'shipping_cost' => 13000],
            ['city_name' => 'Lubuklinggau', 'shipping_cost' => 14000],
            ['city_name' => 'Prabumulih', 'shipping_cost' => 13500],

            // BENGKULU
            ['city_name' => 'Bengkulu', 'shipping_cost' => 17000],

            // LAMPUNG
            ['city_name' => 'Bandar Lampung', 'shipping_cost' => 12000],
            ['city_name' => 'Metro', 'shipping_cost' => 12500],

            // KEPULAUAN BANGKA BELITUNG
            ['city_name' => 'Pangkal Pinang', 'shipping_cost' => 18000],

            // KEPULAUAN RIAU
            ['city_name' => 'Tanjung Pinang', 'shipping_cost' => 20000],
            ['city_name' => 'Batam', 'shipping_cost' => 19000],

            // DKI JAKARTA
            ['city_name' => 'Jakarta', 'shipping_cost' => 10000],

            // JAWA BARAT
            ['city_name' => 'Bandung', 'shipping_cost' => 22000],
            ['city_name' => 'Bogor', 'shipping_cost' => 18000],
            ['city_name' => 'Depok', 'shipping_cost' => 17000],
            ['city_name' => 'Bekasi', 'shipping_cost' => 17000],
            ['city_name' => 'Cirebon', 'shipping_cost' => 25000],
            ['city_name' => 'Sukabumi', 'shipping_cost' => 23000],
            ['city_name' => 'Tasikmalaya', 'shipping_cost' => 24000],
            ['city_name' => 'Garut', 'shipping_cost' => 24000],
            ['city_name' => 'Ciamis', 'shipping_cost' => 25000],
            ['city_name' => 'Banjar', 'shipping_cost' => 24000],

            // JAWA TENGAH
            ['city_name' => 'Semarang', 'shipping_cost' => 0],
            ['city_name' => 'Surakarta', 'shipping_cost' => 21000],
            ['city_name' => 'Pekalongan', 'shipping_cost' => 21000],
            ['city_name' => 'Tegal', 'shipping_cost' => 22000],
            ['city_name' => 'Salatiga', 'shipping_cost' => 21000],
            ['city_name' => 'Magelang', 'shipping_cost' => 21000],
            ['city_name' => 'Purwokerto', 'shipping_cost' => 22000],
            ['city_name' => 'Kudus', 'shipping_cost' => 20500],
            ['city_name' => 'Demak', 'shipping_cost' => 20000],
            ['city_name' => 'Rembang', 'shipping_cost' => 21000],

            // DI YOGYAKARTA
            ['city_name' => 'Yogyakarta', 'shipping_cost' => 20000],
            ['city_name' => 'Sleman Jogjakarta', 'shipping_cost' => 20000],

            // JAWA TIMUR
            ['city_name' => 'Surabaya', 'shipping_cost' => 27000],
            ['city_name' => 'Malang', 'shipping_cost' => 28000],
            ['city_name' => 'Medan (Jawa Timur)', 'shipping_cost' => 29000],
            ['city_name' => 'Blitar', 'shipping_cost' => 28000],
            ['city_name' => 'Kediri', 'shipping_cost' => 27500],
            ['city_name' => 'Nganjuk', 'shipping_cost' => 28000],
            ['city_name' => 'Madiun', 'shipping_cost' => 27500],
            ['city_name' => 'Magetan', 'shipping_cost' => 28000],
            ['city_name' => 'Gresik', 'shipping_cost' => 26500],
            ['city_name' => 'Mojokerto', 'shipping_cost' => 26500],
            ['city_name' => 'Pasuruan', 'shipping_cost' => 27000],
            ['city_name' => 'Probolinggo', 'shipping_cost' => 28000],
            ['city_name' => 'Bondowoso', 'shipping_cost' => 29000],
            ['city_name' => 'Banyuwangi', 'shipping_cost' => 30000],
            ['city_name' => 'Jember', 'shipping_cost' => 29000],
            ['city_name' => 'Lumajang', 'shipping_cost' => 29000],
            ['city_name' => 'Tuban', 'shipping_cost' => 26000],
            ['city_name' => 'Lamongan', 'shipping_cost' => 26000],
            ['city_name' => 'Ponorogo', 'shipping_cost' => 27500],
            ['city_name' => 'Pacitan', 'shipping_cost' => 28500],

            // BALI
            ['city_name' => 'Denpasar', 'shipping_cost' => 35000],
            ['city_name' => 'Ubud', 'shipping_cost' => 36000],
            ['city_name' => 'Kuta', 'shipping_cost' => 35000],
            ['city_name' => 'Sanur', 'shipping_cost' => 35000],

            // NUSA TENGGARA BARAT
            ['city_name' => 'Mataram', 'shipping_cost' => 38000],
            ['city_name' => 'Bima', 'shipping_cost' => 40000],

            // NUSA TENGGARA TIMUR
            ['city_name' => 'Kupang', 'shipping_cost' => 45000],

            // KALIMANTAN BARAT
            ['city_name' => 'Pontianak', 'shipping_cost' => 32000],
            ['city_name' => 'Singkawang', 'shipping_cost' => 33000],

            // KALIMANTAN TENGAH
            ['city_name' => 'Palangka Raya', 'shipping_cost' => 35000],

            // KALIMANTAN SELATAN
            ['city_name' => 'Banjarmasin', 'shipping_cost' => 30000],
            ['city_name' => 'Banjarbaru', 'shipping_cost' => 30000],

            // KALIMANTAN TIMUR
            ['city_name' => 'Samarinda', 'shipping_cost' => 31000],
            ['city_name' => 'Balikpapan', 'shipping_cost' => 32000],
            ['city_name' => 'Tarakan', 'shipping_cost' => 33000],

            // KALIMANTAN UTARA
            ['city_name' => 'Tanjung Selor', 'shipping_cost' => 34000],

            // SULAWESI UTARA
            ['city_name' => 'Manado', 'shipping_cost' => 38000],
            ['city_name' => 'Tomohon', 'shipping_cost' => 39000],
            ['city_name' => 'Bitung', 'shipping_cost' => 39000],

            // SULAWESI TENGGARA
            ['city_name' => 'Kendari', 'shipping_cost' => 40000],
            ['city_name' => 'Bau-Bau', 'shipping_cost' => 41000],

            // SULAWESI TENGAH
            ['city_name' => 'Palu', 'shipping_cost' => 40000],

            // SULAWESI BARAT
            ['city_name' => 'Mamuju', 'shipping_cost' => 40000],

            // SULAWESI SELATAN
            ['city_name' => 'Makassar', 'shipping_cost' => 38000],
            ['city_name' => 'Parepare', 'shipping_cost' => 39000],
            ['city_name' => 'Palopo', 'shipping_cost' => 40000],

            // MALUKU
            ['city_name' => 'Ambon', 'shipping_cost' => 50000],
            ['city_name' => 'Tual', 'shipping_cost' => 52000],

            // MALUKU UTARA
            ['city_name' => 'Ternate', 'shipping_cost' => 48000],
            ['city_name' => 'Tidore', 'shipping_cost' => 49000],

            // PAPUA BARAT
            ['city_name' => 'Manokwari', 'shipping_cost' => 55000],
            ['city_name' => 'Sorong', 'shipping_cost' => 56000],

            // PAPUA
            ['city_name' => 'Jayapura', 'shipping_cost' => 60000],
            ['city_name' => 'Wamena', 'shipping_cost' => 65000],

            // PAPUA SELATAN
            ['city_name' => 'Merauke', 'shipping_cost' => 62000],

            // PAPUA TENGAH
            ['city_name' => 'Tiom', 'shipping_cost' => 64000],

            // PAPUA PEGUNUNGAN
            ['city_name' => 'Nabire', 'shipping_cost' => 58000],
        ];

        // Hapus data 'Semarang (Free Delivery)' yang duplicate
        ShippingCity::where('city_name', 'Semarang (Free Delivery)')->delete();

        foreach ($cities as $city) {
            ShippingCity::updateOrCreate(
                ['city_name' => $city['city_name']],
                ['shipping_cost' => $city['shipping_cost']]
            );
        }
    }
}
