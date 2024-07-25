<?php

namespace App\CustomCoreServices\Traits;

trait HandleTableNameTrait
{
    protected function getTable():string{
        return app($this->modelClass())->getTable();
    }
}
