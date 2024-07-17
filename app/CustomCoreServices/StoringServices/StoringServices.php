<?php

namespace App\CustomCoreServices\StoringServices;

use App\CustomCoreServices\Interfaces\HandleStoringServicesInterface;
use App\CustomCoreServices\Traits\FilesHandleTrait;
use App\CustomCoreServices\Traits\RelationsHandleTrait;
use Illuminate\Support\Facades\DB;

abstract class StoringServices implements HandleStoringServicesInterface
{
    use RelationsHandleTrait , FilesHandleTrait;

    abstract protected function messageSuccessAction():string;
    abstract protected function messageFailedAction():string;
    abstract protected function modelClass(): string;
    abstract protected function requestFile(): string;

    public function create(): string
    {
        try {
            DB::beginTransaction();
            $this->handle();
            $this->handleRelations();
            $this->handleFiles();
            DB::commit();
            return $this->messageSuccessAction();
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->messageFailedAction();
        }
    }
}
