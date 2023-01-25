<?php

namespace App\Helpers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Province;
use App\Models\City;
use App\Models\Agent;
use App\Models\GuaranteeBank;
use App\Models\Insurance;
use App\Models\InsuranceType;
use App\Models\Obligee;
use App\Models\Principal;
use App\Models\Template;

class Select2
{

    private static function fetch($data): array{
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->name ?? $item->title,
            ];
        })->all());
    }
    private static function fetch_client($data): array{
        return array_values($data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'text' => $item->regional->name.' - '.$item->name ?? $item->title,
            ];
        })->all());
    }
    public static function regional(?string $keyword = null){
        return self::fetch(Branch::where('is_regional',true)->when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function branch(?string $keyword = null){
        return self::fetch(Branch::where('is_regional',false)->when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function branch_client(?string $keyword = null){
        return self::fetch_client(Branch::where('is_regional',false)->when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function bank(?string $keyword = null){
        return self::fetch(Bank::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function province(?string $keyword = null){
        return self::fetch(Province::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function city(?string $keyword = null,?string $province_id = null){
        return self::fetch(City::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->when($province_id != '', function ($query) use ($province_id){
            return $query->where('province_id', $province_id);
        })->get());
    }

    public static function agent(?string $keyword = null,?string $branch = null){
        return self::fetch(Agent::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->when($branch,function($query) use ($branch){
            return $query->where('branch_id',$branch);
        })->get());
    }

    public static function insurance(?string $keyword = null){
        return self::fetch(Insurance::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function insuranceType(?string $keyword = null){
        return self::fetch(InsuranceType::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function obligee(?string $keyword = null){
        return self::fetch(Obligee::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function principal(?string $keyword = null){
        return self::fetch(Principal::when($keyword != '', function ($query) use ($keyword){
            return $query->where('name', 'like', "%$keyword%");
        })->get());
    }

    public static function suretyTemplate(?string $keyword = null){
        return self::fetch(Template::where('bank_id',null)->when($keyword != '', function ($query) use ($keyword){
            return $query->where('title', 'like', "%$keyword%");
        })->get());
    }

    public static function bankTemplate(?string $keyword = null, $id){
        return self::fetch(Template::where('bank_id',null)->orWhere('bank_id',$id)->when($keyword != '', function ($query) use ($keyword){
            return $query->where('title', 'like', "%$keyword%");
        })->get());
    }
}
