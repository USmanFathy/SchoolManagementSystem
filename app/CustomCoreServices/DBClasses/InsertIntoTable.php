<?php

namespace App\CustomCoreServices\DBClasses;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertIntoTable
{
    public static function create($table , $data):int
    {
        $columns = Schema::getColumnListing($table);

        $filteredData = array_intersect_key($data, array_flip($columns));

        return DB::table($table)->insertGetId($filteredData);
    }
}
