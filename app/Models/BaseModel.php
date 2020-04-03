<?php

namespace App\Models;

use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use PivotEventTrait;


    public static function boot()
      {
          parent::boot();

          static::pivotAttaching(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
              //
          });

          static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            echo 'pivotAttached';
            die();
            echo get_class($model);
            echo $relationName;
            print_r($pivotIds);
            print_r($pivotIdsAttributes);
          });

          static::pivotDetaching(function ($model, $relationName, $pivotIds) {
              //
          });

          static::pivotDetached(function ($model, $relationName, $pivotIds) {
              //
          });

          static::pivotUpdating(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
              //
              echo 'pivotAttached';
              die();
          });

          static::pivotUpdated(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
              //
              echo 'pivotAttached';
              die();
          });

          static::updating(function ($model) {
              //this is how we catch standard eloquent events
          });
      }
  }
