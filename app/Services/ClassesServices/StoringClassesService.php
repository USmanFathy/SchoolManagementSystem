<?php

namespace App\Services\ClassesServices;

use App\CustomCoreServices\DBClasses\ManyToManyCreatingServices;
use App\CustomCoreServices\StoringServices\SingleRecordStoringService;
use App\Http\Requests\ClassesRequests\ClassesStoringRequest;
use App\Models\Classes;

class StoringClassesService extends SingleRecordStoringService
{
    protected function messageSuccessAction(): string
    {
        return "Class Created Successfully";
    }

    protected function messageFailedAction(): string
    {
        return "Class Failed Creating";
    }

    protected function modelClass(): string
    {
        return Classes::class;
    }

    protected function requestFile(): string
    {
        return ClassesStoringRequest::class;
    }

    protected function relations(): array
    {
        return [
            'BelongsToMany' => [
                'subjects'
            ]
        ];
    }
}
