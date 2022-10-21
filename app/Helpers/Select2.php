<?php

namespace App\Helpers;

use App\Models\Bank;
use App\Models\Branch;

class Select2
{
    public static function regional(string $keyword = ''){
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

    public static function branch(string $keyword = ''){
        $data = Branch::all()->when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        });
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }

    public static function bank(string $keyword = ''){
        $data = Bank::all()->when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        });
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name,
            ];
        })->all());
    }
}
