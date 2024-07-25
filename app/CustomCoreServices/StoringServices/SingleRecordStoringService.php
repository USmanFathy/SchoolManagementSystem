<?php

namespace App\CustomCoreServices\StoringServices;


 use App\CustomCoreServices\DBClasses\InsertIntoTable;
 use Illuminate\Support\Facades\DB;

 abstract class SingleRecordStoringService extends StoringServices
{
    protected function handle(array $data): void{
        $this->object = InsertIntoTable::create($this->getTable() , $data);
    }
 }
