<?php


namespace App\Traits\ReflexiveRelationship;


trait HasReflexivePath
{
    use ReflexivePath;

    abstract public function getReflexiveChildrenRelationName(): string;

    public static function bootHasReflexivePath()
    {
        // before save the model
        static::saving(function ($model) {
            // We rebuild the whole path
            $model->rebuildFullPath();
            // We rebuild all children whole path
            if ( ! is_null($model->{$model->getReflexiveChildrenRelationName()}) ) {
                foreach ($model->{$model->getReflexiveChildrenRelationName()} as $child) {
                    $child->rebuildFullPath();
                }
            }
        });
    }
}
