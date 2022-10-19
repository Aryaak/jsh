<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response(string $message = 'OK',bool $success = true,array $data = []){
        return [
            'message' => $message,
            'success' => $success,
            'data' => $data,
        ];
    }
    public function storeResponse(string $message = 'Simpan data berhasil',bool $success = true,array $data = []){
        return $this->response($message,$success,$data);
    }
    public function updateResponse(string $message = 'Ubah data berhasil',bool $success = true,array $data = []){
        return $this->response($message,$success,$data);
    }
    public function showResponse(array $data = []){
        if(empty($data)){
            return $this->response('Data tidak ditemukan',false,$data);
        }else{
            return $this->response('OK',true,$data);
        }
    }
    public function destroyResponse(string $message = 'Hapus data berhasil',bool $success = true,array $data = []){
        return $this->response($message,$success,$data);
    }
    public function errorResponse(string $message){
        return $this->response($message,false);
    }
    public function httpErrorCode(string $code){
    return in_array($code,[401,403,422]) ? $code : 421;
    }

}
