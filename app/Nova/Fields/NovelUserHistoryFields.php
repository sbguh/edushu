<?php

namespace App\Nova\Fields;

use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;

class NovelUserHistoryFields
{
    /**
     * Get the pivot fields for the relationship.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
          Text::make('状态','type'),
           DateTime::make('created_at')->onlyOnIndex(),
           DateTime::make('updated_at')->onlyOnIndex(),
        ];
    }
}
