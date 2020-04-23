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
use Laravel\Nova\Fields\Select;

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

     public static function indexQuery(NovaRequest $request, $query)
     {
         return $query->whereNotNull('paid_at');
     }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('user')->readonly(),
            Text::make('order_number')->help(
                '可以为空，会自动创建新订单'
            )->readonly(),
            Text::make('address')->hideFromIndex(),
            Currency::make('total_amount')->rules('required')->help(
                '数量必须要填'
            ),
            Textarea::make('address')->hideFromIndex(),
            Textarea::make('remark')->hideFromIndex(),
            Date::make('paid_at')->hideFromIndex(),
          //  Text::make('payment_method')->readonly(),
            Text::make('payment_no')->readonly(),
            Text::make('refund_status')->hideFromIndex(),
            Text::make('refund_no')->hideFromIndex(),
            Boolean::make('closed')->hideFromIndex(),
            Boolean::make('reviewed')->hideFromIndex(),
            Text::make('ship_status'),
            //Text::make('status'),
            Select::make('status')->options([
                'unpaid' => '未付款',
                'paid' => '已付款',
                'pending' => '订单未处理',
                'complete' => '订单已完成',
                'cancel' => '订单已取消',
                'refund' => '订单已退款',
            ])->displayUsingLabels(),
            Date::make('ship_data')->hideFromIndex(),
            HasMany::make('products','products','App\Nova\OrderProduct'),


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
