<?php

namespace App\Nova\Fields;

use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
class NovelUserFields
{
    /**
     * Get the pivot fields for the relationship.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
          Textarea::make('note'),
           DateTime::make('created_at')->onlyOnIndex(),
           DateTime::make('updated_at')->onlyOnIndex(),
        ];
    }
}
