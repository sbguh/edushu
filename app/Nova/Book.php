<?php

namespace App\Nova;

use Illuminate\Http\Request;

use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Gravatar;
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
use Laravel\Nova\Fields\MorphToMany;

class Book extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
     public static $group = '电子书';
    public static $model = 'App\Models\Book';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name','author'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

     public static function label()
     {
         return "电子书";
     }

    public function fields(Request $request)
    {
        return [
          ID::make()->sortable(),

        //  Gravatar::make('Avatar', 'name')->maxWidth(50),

          Text::make('name')
              ->sortable()
              ->rules('required', 'max:255'),
          Text::make('author'),

          Text::make('副标题','sub_title')->hideFromIndex()
          ->rules('required', 'max:255'),

          Currency::make('price')->nullable()->hideFromIndex(),
          /*
          Image::make('image')->disk('edushu')->nullable()->thumbnail(function ($value, $disk) {
              return $value? Storage::disk($disk)->url($value): null;
          }),
          */
          Image::make('image')->disk('edushu')->nullable(),
          File::make('audio')->disk('edushu')->nullable(),
          Boolean::make('state'),
          Boolean::make('on_sale'),
          Markdown::make('description')->nullable()->hideFromIndex(),

          HasMany::make('chapters'),
          MorphToMany::make('Tags'),

          BelongsToMany::make('categories'), //禁止删除的选项

      //  BelongsToMany::make('categories','categories', 'App\Nova\Category'),

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
