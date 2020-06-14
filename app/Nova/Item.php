<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Trix;

class Item extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
  //  public static $model = \App\Item::class;
  public static $group = '超市价格查询';
  public static $model = 'App\Models\Item';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','barcode','name'
    ];

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
            Text::make('条形码','barcode')
            ->rules('required', 'max:255'),
            Text::make('名称','name')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                'extraAttributes' => [
                    'placeholder' => '输入商品名称',
                ]]),

            Text::make('单位','unit')->nullable(),
            Currency::make('销售价格','sale_price')->nullable(),
            Currency::make('实际进货成本价格','cost_price')->nullable(),
            Trix::make('详细描述','description')->nullable()->hideFromIndex()->withFiles('edushu'), //带附件

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
