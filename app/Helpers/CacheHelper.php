<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    public static function getParamsFromFilter($filterParams, $result)
    {
        foreach ($filterParams as $name => $val){
            $result .= $val ? '_' . $name . '_' . $val : '';
        }
        return $result;
    }

    public static function checkAndPut($name, \Closure $callback): Collection
    {
        if(Cache::has($name)){
            $data = Cache::get($name);
        } else{
            $data = $callback();
            if($data->isNotEmpty()){
                Cache::put($name, $data);
            }
        }
        return $data;
    }
}
