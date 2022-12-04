<?php

namespace Database\Seeders;

use App\Models\City;
Use App\Helpers\Jamsyar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run()
    {
        /*
            $cities = [
                // Start Aceh
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Barat",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Barat Daya",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Besar",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Jaya",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Selatan",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Singkil",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Tamiang",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Tengah",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Tenggara",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Timur",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Aceh Utara",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Bener Meriah",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Bireuen",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Gayu Lues",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Nagan Raya",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Pidie",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Pidie Jaya",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kabupaten Simeulue",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kota Banda Aceh",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kota Langsa",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kota Lhokseumawe",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kota Sabang",
                    ],
                    [
                        'province_id' => 1,
                        'name' => "Kota Subulussalam",
                    ],
                // End Aceh
                // Start Bali
                    [
                        'province_id' => 2,
                        'name' => "Kabupaten Badung",
                    ],
                    [
                        'province_id' => 2,
                        'name' => "Kabupaten Bangli",
                    ],
                    [
                        'province_id' => 2,
                        'name' => "Kabupaten Buleleng",
                    ],
                    [
                        'province_id' => 2,
                        'name' => "Kabupaten Gianyar",
                    ],
                    [
                        'province_id' => 2,
                        'name' => "Kabupaten Jembrana",
                    ],
                    [
                        'province_id' => 2,
                        'name' => "Kabupaten Karangasem",
                    ],
                    [
                        'province_id' => 2,
                        'name' => "Kabupaten Klungkung",
                    ],
                    [
                        'province_id' => 2,
                        'name' => "Kabupaten Tabanan",
                    ],
                    [
                        'province_id' => 2,
                        'name' => "Kota Denpasar",
                    ],
                // End Bali
                // Start Banten
                    [
                        'province_id' => 3,
                        'name' => "Kabupaten Lebak",
                    ],
                    [
                        'province_id' => 3,
                        'name' => "Kabupaten Pandeglang",
                    ],
                    [
                        'province_id' => 3,
                        'name' => "Kabupaten Serang",
                    ],
                    [
                        'province_id' => 3,
                        'name' => "Kabupaten Tangerang",
                    ],
                    [
                        'province_id' => 3,
                        'name' => "Kota Cilegon",
                    ],
                    [
                        'province_id' => 3,
                        'name' => "Kota Serang",
                    ],
                    [
                        'province_id' => 3,
                        'name' => "Kota Tangerang",
                    ],
                    [
                        'province_id' => 3,
                        'name' => "Kota Tangerang Selatan",
                    ],
                // End Banten
                // Start Bengkulu
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Bengkulu Selatan",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Bengkulu Tengah",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Bengkulu Utara",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Kaur",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Kepahiang",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Lebong",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Mukomuko",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Rejang Lebong",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kabupaten Seluma",
                    ],
                    [
                        'province_id' => 4,
                        'name' => "Kota Bengkulu",
                    ],
                // End Bengkulu
                // Start Daerah Istimewa Yogyakarta
                    [
                        'province_id' => 5,
                        'name' => "Kabupaten Bantul",
                    ],
                    [
                        'province_id' => 5,
                        'name' => "Kabupaten Gunungkidul",
                    ],
                    [
                        'province_id' => 5,
                        'name' => "Kabupaten Kulon Progo",
                    ],
                    [
                        'province_id' => 5,
                        'name' => "Kabupaten Sleman",
                    ],
                    [
                        'province_id' => 5,
                        'name' => "Kota Yogyakarta",
                    ],
                // End Daerah Istimewa Yogyakarta
                // Start Daerah Khusus Ibukota Jakarta
                    [
                        'province_id' => 6,
                        'name' => "Kabupaten Kepulauan Seribu",
                    ],
                    [
                        'province_id' => 6,
                        'name' => "Kota Administrasi Jakarta Barat",
                    ],
                    [
                        'province_id' => 6,
                        'name' => "Kota Administrasi Jakarta Pusat",
                    ],
                    [
                        'province_id' => 6,
                        'name' => "Kota Administrasi Jakarta Selatan",
                    ],
                    [
                        'province_id' => 6,
                        'name' => "Kota Administrasi Jakarta Timur",
                    ],
                    [
                        'province_id' => 6,
                        'name' => "Kota Administrasi Jakarta Utara",
                    ],
                // End Daerah Khusus Ibukota Jakarta
                // Start Gorontalo
                    [
                        'province_id' => 7,
                        'name' => "Kabupaten Boalemo",
                    ],
                    [
                        'province_id' => 7,
                        'name' => "Kabupaten Bone Bolango",
                    ],
                    [
                        'province_id' => 7,
                        'name' => "Kabupaten Gorontalo",
                    ],
                    [
                        'province_id' => 7,
                        'name' => "Kabupaten Gorontalo Utara",
                    ],
                    [
                        'province_id' => 7,
                        'name' => "Kabupaten Pohuwato",
                    ],
                    [
                        'province_id' => 7,
                        'name' => "Kota Gorontalo",
                    ],
                // End Gorontalo
                // Start Jambi
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Batanghari",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Bungo",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Kerinci",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Merangin",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Muaro Jambi",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Sarolangun",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Tanjung Jabung Barat",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Tanjung Jabung Timur",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kabupaten Tebo",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kota Jambi",
                    ],
                    [
                        'province_id' => 8,
                        'name' => "Kota Sungai Penuh",
                    ],
                // End Jambi
                // Start Jawa Barat
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Bandung",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Bandung Barat",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Bekasi",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Bogor",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Ciamis",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Cianjur",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Cirebon",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Garut",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Indramayu",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Karawang",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Kuningan",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Majalengka",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Pangandaran",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Purwakarta",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Subang",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Sukabumi",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Sumedang",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kabupaten Tasikmalaya",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Bandung",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Banjar",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Bekasi",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Bogor",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Cimahi",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Cirebon",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Depok",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Sukabumi",
                    ],
                    [
                        'province_id' => 9,
                        'name' => "Kota Tasikmalaya",
                    ],
                // End Jawa Barat
                // Start Jawa Tengah
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Banjarnegara",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Banyumas",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Batang",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Blora",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Boyolali",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Brebes",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Cilacap",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Demak",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Grobogan",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Jepara",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Karanganyar",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Kebumen",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Kendal",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Klaten",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Kudus",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Magelang",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Pati",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Pekalongan",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Pemalang",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Purbalingga",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Purworejo",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Rembang",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Semarang",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Sragen",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Sukoharjo",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Tegal",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Temanggung",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Wonogiri",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kabupaten Wonosobo",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kota Magelang",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kota Pekalongan",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kota Salatiga",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kota Semarang",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kota Surakarta",
                    ],
                    [
                        'province_id' => 10,
                        'name' => "Kota Tegal",
                    ],
                // End Jawa Tengah
                // Start Jawa Timur
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Bangkalan",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Banyuwangi",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Blitar",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Bojonegoro",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Bondowoso",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Gresik",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Jember",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Jombang",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Kediri",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Lamongan",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Lumajang",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Madiun",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Magetan",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Malang",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Mojokerto",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Nganjuk",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Ngawi",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Pacitan",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Pamekasan",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Pasuruan",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Ponorogo",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Probolinggo",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Sampang",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Sidoarjo",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Situbondo",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Sumenep",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Trenggalek",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Tuban",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kabupaten Tulungagung",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Batu",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Blitar",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Kediri",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Madiun",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Malang",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Mojokerto",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Pasuruan",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Probolinggo",
                    ],
                    [
                        'province_id' => 11,
                        'name' => "Kota Surabaya",
                    ],
                // End Jawa Timur
                // Start Kalimantan Barat
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Bengkayang",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Kapuas Hulu",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Kayong Utara",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Ketapang",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Kubu Raya",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Landak",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Melawi",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Mempawah",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Sambas",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Sanggau",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Sekadau",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kabupaten Sintang",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kota Pontianak",
                    ],
                    [
                        'province_id' => 12,
                        'name' => "Kota Singkawang",
                    ],
                // End Kalimantan Barat
                // Start Kalimantan Selatan
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Balangan",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Banjar",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Barito Kuala",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Hulu Sungai Selatan",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Hulu Sungai Tengah",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Hulu Sungai Utara",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Kotabaru",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Tabalong",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Tanah Bumbu",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Tanah Laut",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kabupaten Tapin",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kota Banjarbaru",
                    ],
                    [
                        'province_id' => 13,
                        'name' => "Kota Banjarmasin",
                    ],
                // End Kalimantan Selatan
                // Start Kalimantan Tengah
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Barito Selatan",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Barito Timur",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Barito Utara",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Gunung Mas",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Kapuas",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Katingan",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Kotawaringin Barat",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Kotawaringin Timur",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Lamandau",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Murung Raya",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Pulang Pisau",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Sukamara",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kabupaten Seruyan",
                    ],
                    [
                        'province_id' => 14,
                        'name' => "Kota Palangka Raya",
                    ],
                // End Kalimantan Tengah
                // Start Kalimantan Timur
                    [
                        'province_id' => 15,
                        'name' => "Kabupaten Berau",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kabupaten Kutai Barat",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kabupaten Kutai Kartanegara",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kabupaten Kutai Timur",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kabupaten Mahakam Ulu",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kabupaten Paser",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kabupaten Penajam Paser Utara",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kota Balikpapan",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kota Bontang",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kota Nusantara",
                    ],
                    [
                        'province_id' => 15,
                        'name' => "Kota Samarinda",
                    ],
                // End Kalimantan Timur
                // Start Kalimantan Utara
                    [
                        'province_id' => 16,
                        'name' => "Kabupaten Bulungan",
                    ],
                    [
                        'province_id' => 16,
                        'name' => "Kabupaten Malinau",
                    ],
                    [
                        'province_id' => 16,
                        'name' => "Kabupaten Nunukan",
                    ],
                    [
                        'province_id' => 16,
                        'name' => "Kabupaten Tana Tidung",
                    ],
                    [
                        'province_id' => 16,
                        'name' => "Kota Tarakan",
                    ],
                // End Kalimantan Utara
                // Start Kepulauan Bangka Belitung
                    [
                        'province_id' => 17,
                        'name' => "Kabupaten Bangka",
                    ],
                    [
                        'province_id' => 17,
                        'name' => "Kabupaten Bangka Barat",
                    ],
                    [
                        'province_id' => 17,
                        'name' => "Kabupaten Bangka Selatan",
                    ],
                    [
                        'province_id' => 17,
                        'name' => "Kabupaten Bangka Tengah",
                    ],
                    [
                        'province_id' => 17,
                        'name' => "Kabupaten Belitung",
                    ],
                    [
                        'province_id' => 17,
                        'name' => "Kabupaten Belitung Timur",
                    ],
                    [
                        'province_id' => 17,
                        'name' => "Kota Pangkal Pinang",
                    ],
                // End Kepulauan Bangka Belitung
                // Start Kepulauan Riau
                    [
                        'province_id' => 18,
                        'name' => "Kabupaten Bintan",
                    ],
                    [
                        'province_id' => 18,
                        'name' => "Kabupaten Karimun",
                    ],
                    [
                        'province_id' => 18,
                        'name' => "Kabupaten Kepulauan Anambas",
                    ],
                    [
                        'province_id' => 18,
                        'name' => "Kabupaten Lingga",
                    ],
                    [
                        'province_id' => 18,
                        'name' => "Kabupaten Natuna",
                    ],
                    [
                        'province_id' => 18,
                        'name' => "Kota Batam",
                    ],
                    [
                        'province_id' => 18,
                        'name' => "Kota Tanjungpinang",
                    ],
                // End Kepulauan Riau
                // Start Lampung
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Lampung Barat",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Lampung Selatan",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Lampung Tengah",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Lampung Timur",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Lampung Utara",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Mesuji",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Pesawaran",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Pesisir Barat",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Pringsewu",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Tanggamus",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Tulang Bawang",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Tulang Bawang Barat",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kabupaten Way Kanan",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kota Bandar Lampung",
                    ],
                    [
                        'province_id' => 19,
                        'name' => "Kota Metro",
                    ],
                // End Lampung
                // Start Maluku
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Buru",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Buru Selatan",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Kepulauan Aru",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Kepulauan Tanimbar",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Maluku Barat Daya",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Maluku Tengah",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Maluku Tenggara",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Seram Bagian Barat",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kabupaten Seram Bagian Timur",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kota Ambon",
                    ],
                    [
                        'province_id' => 20,
                        'name' => "Kota Tual",
                    ],
                // End Maluku
                // Start Maluku Utara
                    [
                        'province_id' => 21,
                        'name' => "Kabupaten Halmahera Barat",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kabupaten Halmahera Selatan",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kabupaten Halmahera Tengah",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kabupaten Halmahera Timur",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kabupaten Halmahera Utara",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kabupaten Kepulauan Sula",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kabupaten Pulau Morotai",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kabupaten Pulau Taliabu",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kota Ternate",
                    ],
                    [
                        'province_id' => 21,
                        'name' => "Kota Tidore Kepulauan",
                    ],
                // End Maluku Utara
                // Start Nusa Tenggara Barat
                    [
                        'province_id' => 22,
                        'name' => "Kabupaten Bima",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kabupaten Dompu",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kabupaten Lombok Barat",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kabupaten Lombok Tengah",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kabupaten Lombok Timur",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kabupaten Lombok Utara",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kabupaten Sumbawa",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kabupaten Sumbawa Barat",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kota Bima",
                    ],
                    [
                        'province_id' => 22,
                        'name' => "Kota Mataram",
                    ],
                // End Nusa Tenggara Barat
                // Start Nusa Tenggara Timur
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Alor",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Belu",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Ende",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Flores Timur",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Kupang",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Lembata",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Malaka",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Manggarai",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Manggarai Barat",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Manggarai Timur",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Nagekeo",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Ngada",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Rote Ndao",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Sabu Raijua",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Sikka",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Sumba Barat",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Sumba Barat Daya",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Sumba Tengah",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Sumba Timur",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Timor Tengah Selatan",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kabupaten Timor Tengah Utara",
                    ],
                    [
                        'province_id' => 23,
                        'name' => "Kota Kupang",
                    ],
                // End Nusa Tenggara Timur
                // Start Papua
                    [
                        'province_id' => 24,
                        'name' => "Kabupaten Biak Numfor",
                    ],
                    [
                        'province_id' => 24,
                        'name' => "Kabupaten Jayapura",
                    ],
                    [
                        'province_id' => 24,
                        'name' => "Kabupaten Keerom",
                    ],
                    [
                        'province_id' => 24,
                        'name' => "Kabupaten Kepulauan Yapen",
                    ],
                    [
                        'province_id' => 24,
                        'name' => "Kabupaten Mamberamo Raya",
                    ],
                    [
                        'province_id' => 24,
                        'name' => "Kabupaten Sarmi",
                    ],
                    [
                        'province_id' => 24,
                        'name' => "Kabupaten Supiori",
                    ],
                    [
                        'province_id' => 24,
                        'name' => "Kabupaten Waropen",
                    ],
                    [
                        'province_id' => 24,
                        'name' => "Kota Jayapura",
                    ],
                // End Papua
                // Start Papua Barat
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Fakfak",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Kaimana",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Manokwari",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Manokwari Selatan",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Maybrat",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Pegunungan Arfak",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Raja Ampat",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Sorong",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Sorong Selatan",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Tambrauw",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Teluk Bintuni",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kabupaten Teluk Wondama",
                    ],
                    [
                        'province_id' => 25,
                        'name' => "Kota Sorong",
                    ],
                // End Papua Barat
                // Start Papua Pegunungan
                    [
                        'province_id' => 26,
                        'name' => "Kabupaten Jayawijaya",
                    ],
                    [
                        'province_id' => 26,
                        'name' => "Kabupaten Lanny Jaya",
                    ],
                    [
                        'province_id' => 26,
                        'name' => "Kabupaten Mamberamo Tengah",
                    ],
                    [
                        'province_id' => 26,
                        'name' => "Kabupaten Nduga",
                    ],
                    [
                        'province_id' => 26,
                        'name' => "Kabupaten Pegunungan Bintang",
                    ],
                    [
                        'province_id' => 26,
                        'name' => "Kabupaten Tolikara",
                    ],
                    [
                        'province_id' => 26,
                        'name' => "Kabupaten Yahukimo",
                    ],
                    [
                        'province_id' => 26,
                        'name' => "Kabupaten Yalimo",
                    ],
                // End Papua Pegunungan
                // Start Papua Selatan
                    [
                        'province_id' => 27,
                        'name' => "Kabupaten Asmat",
                    ],
                    [
                        'province_id' => 27,
                        'name' => "Kabupaten Boven Digoel",
                    ],
                    [
                        'province_id' => 27,
                        'name' => "Kabupaten Mappi",
                    ],
                    [
                        'province_id' => 27,
                        'name' => "Kabupaten Merauke",
                    ],
                // End Papua Selatan
                // Start Papua Tengah
                    [
                        'province_id' => 28,
                        'name' => "Kabupaten Deiyai",
                    ],
                    [
                        'province_id' => 28,
                        'name' => "Kabupaten Dogiyai",
                    ],
                    [
                        'province_id' => 28,
                        'name' => "Kabupaten Intan Jaya",
                    ],
                    [
                        'province_id' => 28,
                        'name' => "Kabupaten Mimika",
                    ],
                    [
                        'province_id' => 28,
                        'name' => "Kabupaten Nabire",
                    ],
                    [
                        'province_id' => 28,
                        'name' => "Kabupaten Paniai",
                    ],
                    [
                        'province_id' => 28,
                        'name' => "Kabupaten Puncak",
                    ],
                    [
                        'province_id' => 28,
                        'name' => "Kabupaten Puncak Jaya",
                    ],
                // End Papua Tengah
                // Start Riau
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Bengkalis",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Indragiri Hilir",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Indragiri Hulu",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Kampar",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Kepulauan Meranti",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Kuantan Singingi",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Pelalawan",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Rokan Hilir",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Rokan Hulu",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kabupaten Siak",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kota Dumai",
                    ],
                    [
                        'province_id' => 29,
                        'name' => "Kota Pekanbaru",
                    ],
                // End Riau
                // Start Sulawesi Barat
                    [
                        'province_id' => 30,
                        'name' => "Kabupaten Majene",
                    ],
                    [
                        'province_id' => 30,
                        'name' => "Kabupaten Mamasa",
                    ],
                    [
                        'province_id' => 30,
                        'name' => "Kabupaten Mamuju",
                    ],
                    [
                        'province_id' => 30,
                        'name' => "Kabupaten Mamuju Tengah",
                    ],
                    [
                        'province_id' => 30,
                        'name' => "Kabupaten Pasangkayu",
                    ],
                    [
                        'province_id' => 30,
                        'name' => "Kabupaten Polewali Mandar",
                    ],
                // End Sulawesi Barat
                // Start Sulawesi Selatan
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Bantaeng",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Barru",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Bone",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Bulukumba",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Enrekang",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Gowa",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Jeneponto",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Kepulauan Selayar",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Luwu",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Luwu Timur",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Luwu Utara",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Maros",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Pangkajene dan Kepulauan",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Pinrang",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Sidenreng Rappang",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Sinjai",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Soppeng",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Takalar",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Tana Toraja",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Toraja Utara",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kabupaten Wajo",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kota Makassar",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kota Palopo",
                    ],
                    [
                        'province_id' => 31,
                        'name' => "Kota Parepare",
                    ],
                // End Sulawesi Selatan
                // Start Sulawesi Tengah
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Banggai",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Banggai Kepulauan",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Banggai Laut",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Buol",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Donggala",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Morowali",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Morowali Utara",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Parigi Moutong",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Poso",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Sigi",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Tojo Una-Una",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kabupaten Tolitoli",
                    ],
                    [
                        'province_id' => 32,
                        'name' => "Kota Palu",
                    ],
                // End Sulawesi Tengah
                // Start Sulawesi Tenggara
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Bombana",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Buton",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Buton Selatan",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Buton Tengah",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Buton Utara",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Kolaka",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Kolaka Timur",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Kolaka Utara",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Konawe",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Konawe Kepulauan",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Konawe Selatan",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Konawe Utara",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Muna",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Muna Barat",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kabupaten Wakatobi",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kota Baubau",
                    ],
                    [
                        'province_id' => 33,
                        'name' => "Kota Kendari",
                    ],
                // End Sulawesi Tenggara
                // Start Sulawesi Utara
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Bolaang Mongondow",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Bolaang Mongondow Selatan",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Bolaang Mongondow Timur",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Bolaang Mongondow Utara",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Kepulauan Sangihe",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Kepulauan Siau Tagulandang Biaro",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Kepulauan Talaud",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Minahasa",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Minahasa Selatan",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Minahasa Tenggara",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kabupaten Minahasa Utara",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kota Bitung",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kota Kotamobagu",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kota Manado",
                    ],
                    [
                        'province_id' => 34,
                        'name' => "Kota Tomohon",
                    ],
                // End Sulawesi Utara
                // Start Sumatra Barat
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Agam",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Dharmasraya",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Kepulauan Mentawai",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Lima Puluh Kota",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Padang Pariaman",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Pasaman",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Pasaman Barat",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Pesisir Selatan",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Sijunjung",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Solok",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Solok Selatan",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kabupaten Tanah Datar",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kota Bukittinggi",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kota Padang",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kota Padang Panjang",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kota Pariaman",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kota Payakumbuh",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kota Sawahlunto",
                    ],
                    [
                        'province_id' => 35,
                        'name' => "Kota Solok",
                    ],
                // End Sumatra Barat
                // Start Sumatra Selatan
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Banyuasin",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Empat Lawang",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Lahat",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Muara Enim",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Musi Banyuasin",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Musi Rawas",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Musi Rawas Utara",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Ogan Ilir",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Ogan Komering Ilir",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Ogan Komering Ulu",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Ogan Komering Ulu Selatan",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Ogan Komering Ulu Timur",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kabupaten Penukal Abab Lematang Ilir",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kota Lubuklinggau",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kota Pagar Alam",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kota Palembang",
                    ],
                    [
                        'province_id' => 36,
                        'name' => "Kota Prabumulih",
                    ],
                // End Sumatra Selatan
                // Start Sumatra Utara
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Asahan",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Batu Bara",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Dairi",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Deli Serdang",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Humbang Hasundutan",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Karo",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Labuhanbatu",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Labuhanbatu Selatan",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Labuhanbatu Utara",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Langkat",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Mandailing Natal",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Nias",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Nias Barat",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Nias Selatan",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Nias Utara",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Padang Lawas",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Padang Lawas Utara",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Pakpak Bharat",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Samosir",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Serdang Bedagai",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Simalungun",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Tapanuli Selatan",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Tapanuli Tengah",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Tapanuli Utara",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kabupaten Toba",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kota Binjai",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kota Gunungsitoli",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kota Medan",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kota Padang Sidempuan",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kota Pematangsiantar",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kota Sibolga",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kota Tanjungbalai",
                    ],
                    [
                        'province_id' => 37,
                        'name' => "Kota Tebing Tinggi",
                    ],
                // End Sumatra Utara
            ];
        */
        $nextOffset = true;
        $offset = 0;
        while($nextOffset) {
            $response = Jamsyar::cities([
                "kode_kota" => "",
                "nama_kota" => "",
                "kode_propinsi" => "",
                "limit" => 20,
                "offset" => $offset
            ]);
            City::upsert(array_map(function($city){
                return [
                    'id' => $city['kode_kota'],
                    'name' => $city['nama_kota'],
                    'province_id' => $city['kode_propinsi'],
                ];
            },$response['data']),['id'],['name','province_id']);
            DB::table('cities')->update(['created_at' => now(),'updated_at' => now()]);
            if($response['total_record'] < 20){
                $nextOffset = false;
            }else{
                $offset += 20;
            }
        }
    }
}
