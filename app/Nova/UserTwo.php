<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsToMany;
use App\Nova\Fields\NovelUserFields;
use App\Nova\Fields\NovelUserHistoryFields;
use App\Rules\NovelUserRule;
use Laravel\Nova\Fields\Boolean;
class UserTwo extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $displayInNavigation = false;
    public static $group = 'user';
    public static $model = 'App\User';
    public static $perPageOptions = [50, 100, 150];
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
        'id', 'name', 'email','phone_number','real_name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

     public static function label()
     {
         return "用户列表";
     }
    public function fields(Request $request)
    {

        return [
            ID::make()->sortable(),

            //Gravatar::make()->maxWidth(50),

            Text::make('微信名','name')
                ->sortable()
                ->rules('required', 'max:255')->readonly(),
            Text::make('真实姓名','real_name'),
            Text::make('备注','remark'),
            //Text::make('手机号码','phone_number')->rules('required','unique:users'),
            Text::make('手机号码','phone_number'),

            BelongsToMany::make('课程','classrooms', 'App\Nova\ClassRoom')->searchable()->fields(new Fields\UserClassRoomFields),



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
          (new Actions\PhoneAccountProfile)
                      ->confirmText('你确定需要发送这条短信吗?')
                      ->confirmButtonText('发送')
                      ->cancelButtonText("不发送"),

        ];
    }
}
