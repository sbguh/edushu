<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Titasgailius\SearchRelations\SearchesRelations;
use Laravel\Nova\Fields\HasMany;

class UserClassRoom extends Resource
{

  use SearchesRelations;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    use  SoftDeletes;
    public static $group = '学员管理';
    public static $model = 'App\Models\UserClassRoom';

    public static $searchRelations = [
          'user' => ['name', 'real_name','phone_number'],
      ];

    public static function label()
    {
        return "学员";
    }

    public static function singularLabel()
    {
        return "学员";
    }

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

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */


     public function title()
         {
             //return $this->classroom->name;
             return $this->classroom->name.'('.$this->User->name.")";
         }


    public function fields(Request $request)
    {
        return [
          ID::make()->sortable(),
          /*
          Text::make('name', function () {
          return $this->classroom->name.''.$this->User->name;
      }),
      */
          BelongsTo::make('User')->searchable(),
          BelongsTo::make('classroom')->searchable(),
          Number::make('剩余课时','hours')
              ->sortable()
              ->rules('required', 'max:255')
              ->withMeta([
              'extraAttributes' => [
                  'placeholder' => '剩余课时',
              ],
          ]),

          Text::make('备注','remark')
              ->sortable()
              ->rules('required', 'max:255')
              ->withMeta([
              'extraAttributes' => [
                  'placeholder' => '备注',
              ],
          ]),

          HasMany::make('学习报告','reports','App\Nova\Report'),


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
