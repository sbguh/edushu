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
use App\Nova\Fields\NovelUserFields;
use App\Nova\Fields\NovelUserHistoryFields;
use App\Rules\NovelUserRule;

class UserCard extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $trafficCop = false;
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

     public function title()
     {
       $user_name = $this->user->real_name?$this->user->real_name:$this->user->name;
         return $this->card_number."(".$user_name.")";
     }


     public static $searchRelations = [
           'user' => ['name', 'real_name','phone_number'],
       ];


     public function fields(Request $request)
 {
     return [
         ID::make()->sortable(),
         Text::make('卡号','card_number')
         ->creationRules('unique:cards,card_number')
         ->updateRules('unique:cards,card_number,{{resourceId}}'),
         BelongsTo::make('User')->searchable()
         ->creationRules('required',new UserCardRule()),
         Boolean::make("激活",'active')->hideWhenCreating(),
         Boolean::make("账号可用",'enable')->withMeta(['value'=>$this->enable ? $this->enable : 0]),
         Select::make('等级','type_id')->options([
             '1' => '白银会员',
             '2' => '白金会员',
             '3' => '钻石会员',
         ])->displayUsingLabels(),
         Text::make('最多可借','rent_limit')->withMeta(['value'=>$this->rent_limit ? $this->rent_limit : 2]),
         Number::make('期限(天数)','duration'),
         Date::make('开始日期','start_date')->nullable(),
         Date::make('结束日期','end_date')->nullable(),
         HasMany::make('借阅','rents','App\Nova\Rent')
         ->creationRules('required',new NovelUserRule($request->route('resourceId'))),

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
