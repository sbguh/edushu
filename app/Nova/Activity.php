<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Gravatar;
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
use Laravel\Nova\Fields\Trix;
class Activity extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Activity';

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
        'id','name'
    ];


    public static function label()
    {
        return "活动";
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
            Text::make('name')
                ->sortable()
                ->rules('required', 'max:255')->help(
                '活动名称'
            ),
                    Text::make('slug')
                        ->sortable()
                        ->rules('required', 'max:255')->help(
                '必须是英文或者数字组合，不能为空，不能重复'
            ),
                    Text::make('image')->nullable()->hideFromIndex()->help(
            '如果为空，会自动生成'
            ),

            Text::make('活动日期','date_time')->nullable()
            ->rules('required', 'max:255')
            ->hideFromIndex()->help(
            '活动日期'
            ),
            Text::make('活动地点','address')->nullable()
            ->rules('required', 'max:255')
            ->hideFromIndex()->help(
            '活动地点'
            ),
            Text::make('欢迎语','welcome_txt')->nullable()
            ->hideFromIndex()->help(
            '欢迎语'
            ),

            Text::make('群发信息','group_message')->nullable()
            ->hideFromIndex()->help(
            '不为空会群发'
            ),
                        Text::make('media_id')->nullable()->hideFromIndex()->help(
                'image_group 上传后，微信公众号生成的永久素材ID'
            ),
                        Image::make('image_group')->disk('edushu')->nullable()->hideFromIndex()->help(
                '可以上传微信群二维码图片到微信公众号永久素材'
            ),
             Markdown::make('详细描述','description')->alwaysShow()->nullable()->hideFromIndex(), //带附件

            BelongsToMany::make('users'),
            HasMany::make('comments'),

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



        ];
    }
}
