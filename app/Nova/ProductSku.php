<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;

class ProductSku extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $group = 'product';
    public static $model = 'App\Models\ProductSku';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title'
    ];

    public static function label()
    {
        return "产品SKU";
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('名称','title')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('库存数','stock')
                ->rules('required', 'max:255'),
            Boolean::make('on_sale'),
            Image::make('图片','image')->disk('edushu')->nullable(),
            Currency::make('价格','price')->nullable()->hideFromIndex(),
            Text::make('限购','limit_buy')->nullable(),
            Markdown::make('description')->nullable()->hideFromIndex(),

            BelongsTo::make('product')->searchable(), //禁止删除的选项


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
        return [

          (new Actions\ProductSkuAction)
            ->confirmText('是否确定要更新？?')
            ->confirmButtonText('更新')
            ->cancelButtonText("撤销操作")
            ->onlyOnTableRow(),

        ];
    }
}
