<?php

namespace App\Nova;

use Illuminate\Http\Request;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\BelongsTo;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $group = '订单';  
    public static $model = 'App\Models\Order';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'order_number';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
     public static function label()
     {
         return "订单";
     }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('user'),
            Text::make('order_number')->help(
                '可以为空，会自动创建新订单'
            ),
            Text::make('address')->hideFromIndex(),
            Number::make('total_amount')->rules('required')->help(
                '数量必须要填'
            ),
            Textarea::make('remark')->hideFromIndex(),
            Date::make('paid_at')->hideFromIndex(),
            Text::make('payment_method'),
            Text::make('payment_no')->hideFromIndex(),
            Text::make('refund_status'),
            Text::make('refund_no')->hideFromIndex(),
            Boolean::make('closed'),
            Boolean::make('reviewed')->hideFromIndex(),
            Text::make('ship_status'),
            Text::make('status'),
            Date::make('ship_data')->hideFromIndex(),
            HasMany::make('items','items','App\Nova\OrderItem'),


        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
