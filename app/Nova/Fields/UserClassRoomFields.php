<?php

namespace App\Nova\Fields;

use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;

class UserClassRoomFields
{
    /**
     * Get the pivot fields for the relationship.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
          Number::make('剩余课时','hours'),
          Textarea::make('备注','remark'),
        ];
    }
}
