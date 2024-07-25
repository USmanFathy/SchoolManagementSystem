<?php

namespace App\CustomCoreServices\StoringServices;

use App\CustomCoreServices\Traits\DataArrayFromRequestTrait;
use App\CustomCoreServices\Traits\FilesHandleTrait;
use App\CustomCoreServices\Traits\HandleTableNameTrait;
use App\CustomCoreServices\Traits\RelationsHandleTrait;
use Illuminate\Support\Facades\DB;

abstract class StoringServices
{
    use RelationsHandleTrait , FilesHandleTrait ,DataArrayFromRequestTrait ,HandleTableNameTrait ;

    protected array $data=[];
    protected int $object;
    protected array $relationsArray;

    public function __construct()
    {
        $this->relationsArray = $this->relations();
    }
    abstract protected function messageSuccessAction():string;
    abstract protected function messageFailedAction():string;
    abstract protected function modelClass(): string;
    abstract protected function handle(array $data): void;
    abstract protected function requestFile(): string;
    abstract protected function relations(): array;


    public function create()
    {
        try {
            DB::beginTransaction();
            $this->data = $this->valdiate(request());
            $this->handle($this->data);
            $this->handleRelations();
            $this->handleFiles();
            DB::commit();
            return [
                'status' => 'success',
                'messages' => $this->messageSuccessAction(),
                'code' => 200
            ];
        }catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
