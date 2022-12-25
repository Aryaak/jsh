<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use Exception;

class Jamsyar
{
    public static function login($username = 'jsh',$password = 'Semangat1'){
        $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Auth/login_icpr' : 'http://192.168.190.168:8002/Auth/login_icpr';
        $response = Http::acceptJson()->post($url, [
            'username' => $username,
            'password' => $password,
        ]);
        if($response->successful()){
            return $response->json()['token'];
        }else{
            throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }
    public static function cities($params = [],$username = 'jsh',$password = 'Semangat1'){
        $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Api/get_kota' : 'http://192.168.190.168:8002/Api/get_kota';
        if(empty($params)) $params = ["kode_kota" => "","nama_kota" => $name,"kode_propinsi" => "","limit" => 20,"offset" => 0];

        $response = Http::asJson()->acceptJson()->withToken(self::login($username,$password))->post($url, $params);
        if($response->successful()){
            return $response->json();
        }else{
            throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }
    public static function provinces($username = 'jsh',$password = 'Semangat1',$name = null){
        $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Api/get_propinsi' : 'http://192.168.190.168:8002/Api/get_propinsi';
        $response = Http::asJson()->acceptJson()->withToken(self::login($username,$password))
        ->post($url, [
            'kode_propinsi' => null,
            'nama_propinsi' => $name
        ]);
        if($response->successful()){
            return $response->json()['data'];
        }else{
            throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }
    public static function principals($params = [],$username = 'jsh',$password = 'Semangat1'){
        $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Api/get_principal' : 'http://192.168.190.168:8002/Api/get_principal';
        if(empty($params)) $params = ['nama_principal' => '','kode_unik_principal' => '','limit' => 20,'offset' => 0];

        $response = Http::asJson()->acceptJson()->withToken(self::login($username,$password))->post($url, $params);
        if($response->successful()){
            return $response->json();
        }else{
            throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }
    public static function obligees($params = [],$username = 'jsh',$password = 'Semangat1'){
        $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Api/get_obligee' : 'http://192.168.190.168:8002/Api/get_obligee';
        if(empty($params)) $params = ['nama_obligee' => '','kode_unik_obligee' => '','limit' => 20,'offset' => 0];

        $response = Http::asJson()->acceptJson()->withToken(self::login($username,$password))->post($url, $params);
        if($response->successful()){
            return $response->json();
        }else{
            throw new Exception($response->json()['keterangan'], $response->json()['status']);
        }
    }
}
