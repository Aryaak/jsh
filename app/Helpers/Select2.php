<?php

namespace App\Helpers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Province;
use App\Models\City;
use App\Models\Agent;
use App\Models\Insurance;
use App\Models\InsuranceType;

class Select2
{
    public static function regional(?string $keyword = null){
        $data = Branch::where('is_regional',true)->when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get();
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }

    public static function branch(?string $keyword = null){
        $data = Branch::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get();
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }

    public static function bank(?string $keyword = null){
        $data = Bank::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get();
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }

    public static function province(?string $keyword = null){
        $data = Province::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get();
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }

    public static function city(?string $keyword = null,?string $province_id = null){
        $data = City::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->when($province_id != '', function ($query) use ($province_id){
            return $query->where('province_id', $province_id);
        })->get();
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }

    public static function agent(?string $keyword = null){
        $data = Agent::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get();
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }

    public static function insurance(?string $keyword = null){
        $data = Insurance::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get();
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }

    public static function insuranceType(?string $keyword = null){
        $data = InsuranceType::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get();
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }
}
