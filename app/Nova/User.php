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


class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */

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


    public function fields(Request $request)
    {

        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')->readonly(),
            Text::make('真实姓名','real_name'),
            Text::make('手机号码','phone_number'),
            Date::make('生日','birthday')->pickerFormat('Y.m.d')->hideFromIndex(),
            Select::make('性别','gender')->options([
                '0' => '女',
                '1' => '男',
            ])->hideFromIndex(),

            Textarea::make('编辑手机短信信息','description')->help(
                '可发短信信息'
            )->hideFromIndex(),
            Textarea::make('编辑微信信息','wechat_description')->help(
                '发微信公众号客服信息'
            )->hideFromIndex(),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            //HasMany::make('orders'),
            //HasMany::make('order_items'),
          //  HasMany::make('UserLog','logs'),

            BelongsToMany::make('novels')->searchable()
            ->fields(new NovelUserFields)
           ->actions(function () {
                return [
                    new Actions\NovelAction,
                ];
            }),

            BelongsToMany::make('history_novels','history_novels', 'App\Nova\NovelUserHistory')->searchable()
            ->fields(new NovelUserHistoryFields),



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
