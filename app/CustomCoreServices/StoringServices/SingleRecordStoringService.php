<?php

namespace App\CustomCoreServices\StoringServices;


 use Illuminate\Support\Facades\DB;

 abstract class SingleRecordStoringService extends StoringServices
{


    protected function getTable():string{
        return resolve($this->modelClass())->getTable();
    }

    public function handle(array $data): void{
        DB::table($this->getTable())->create($data);
    }
 }
