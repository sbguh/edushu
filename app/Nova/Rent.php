<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Text;
use Titasgailius\SearchRelations\SearchesRelations;
use App\Rules\NovelUserRule;
use App\Rules\UserNovelRule;

class Rent extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    use SearchesRelations;
    public static $group = '借阅';

    public static $model = 'App\Models\Rent';

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
        'id',
    ];

    public static function label()
    {
        return "借阅记录";
    }

    public static function singularLabel()
    {
        return "借阅记录";
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

     public static $searchRelations = [
           'card.user' => ['name', 'real_name','phone_number','rent_number'],
           'novel' => ['title', 'author','press'],
       ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('借书编号','rent_number')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                'extraAttributes' => [
                    'placeholder' => '借书编号',
                ],
            ])->readonly(),
            //Text::make('用户','user')->exceptOnForms(),

            BelongsTo::make('会员卡','card','App\Nova\UserCard')->searchable()->hideWhenUpdating()
            ->creationRules('required',new UserNovelRule()),

            BelongsTo::make('书籍','novel','App\Nova\Novel')->searchable()->hideWhenUpdating()
              ->creationRules('required',new NovelUserRule()),

            Date::make(' 归还时间','return_time')
            ->withMeta(['value'=>$this->return_time ? $this->return_time : date('Y-m-d', strtotime('15 days'))]),
            Currency::make('费用','fee')->nullable()->withMeta(['value'=>$this->fee ? $this->fee : 0]),
            Text::make('状态','state')->onlyOnIndex(),
            Text::make('还书时间','return_at')->withMeta(['value'=>$this->return_at ? $this->return_at : "尚未归还"])->onlyOnIndex(),
            Text::make('备注','note')->withMeta(['value'=>$this->note ? $this->note :" "]),

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
