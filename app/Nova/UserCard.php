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
use App\Rules\UserCardRule;
use Illuminate\Database\Eloquent\SoftDeletes;
use Titasgailius\SearchRelations\SearchesRelations;

class UserCard extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    use SearchesRelations;
    use  SoftDeletes;
    public static $group = 'user';
    public static $model = 'App\Models\Card';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'card_number';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','card_number'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
     public static function label()
     {
         return "借阅卡";
     }

     public static $searchRelations = [
           'user' => ['name', 'real_name','phone_number'],
       ];


     public function fields(Request $request)
 {
     return [
         ID::make()->sortable(),
         Text::make('卡号','card_number')->readonly(),
         BelongsTo::make('User')->searchable()
         ->creationRules('required',new UserCardRule()),
         Boolean::make("激活",'active')->hideWhenCreating(),
         Boolean::make("账号可用",'enable'),
         Select::make('等级','type_id')->options([
             '1' => '白银会员',
             '2' => '白金会员',
             '3' => '钻石会员',
         ])->displayUsingLabels(),
         Number::make('期限(天数)','duration'),
         Date::make('开始日期','start_date')->nullable(),
         Date::make('结束日期','end_date')->nullable(),

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
