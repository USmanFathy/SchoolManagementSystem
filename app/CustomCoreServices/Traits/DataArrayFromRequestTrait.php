<?php

namespace App\CustomCoreServices\Traits;

use App\Exceptions\CustomValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait DataArrayFromRequestTrait
{
    protected function valdiate(Request $request){

        $validator = Validator::make($request->all(), resolve($this->requestFile())->rules());
        if ($validator->fails()) {
            throw new CustomValidationException($validator);
        }

        return $request->all();
    }
}
