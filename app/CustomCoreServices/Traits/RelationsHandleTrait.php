<?php

namespace App\CustomCoreServices\Traits;

use App\CustomCoreServices\DBClasses\InsertIntoTable;

trait RelationsHandleTrait
{
    protected function handleRelations():void{

        foreach ($this->relationsArray as  $key => $value){
            if ($key == 'hasMany'){
                foreach ($value as $relation){
                    $this->handleHasMany($relation);
                }
            }elseif($key == 'BelongsToMany'){
                foreach ($value as $relation){
                    $this->belongsToMany($relation);
                }
            }
        }

    }

    protected function belongsToMany($relation){
        $model = app($this->modelClass());
        $data = [];
            if (method_exists($model, $relation)) {
                $relationInsideModel = $model->{$relation}();
                $data = $this->data[$relation] ?? null;
                $foreignKey = $relationInsideModel->getForeignPivotKeyName();
                foreach ($data as &$subArray) {
                    $subArray[$foreignKey] = $this->object;
                }
                $relationInsideModel->sync($data);
            } else {
                throw new \Exception("Relation method {$relation} does not exist on the model.");
            }
    }
    protected function handleHasMany($relation)
    {
        $model = app($this->modelClass());
        if (method_exists($model, $relation)) {
            $relatedModel = $model->{$relation}()->getRelated();
            $table = $relatedModel->getTable();
            $foreignKey = $model->{$relation}()->getForeignKeyName();
            $data = $this->data[$relation] ?? null;
            foreach ($data as &$subArray) {
                $subArray[$foreignKey] = $this->object;
            }
            InsertIntoTable::create($table,$data);
        } else {
            throw new \Exception("Relation method {$relation} does not exist on the model.");
        }
    }
}
