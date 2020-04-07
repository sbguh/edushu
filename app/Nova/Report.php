<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Date;
use App\Rules\UserNovelRule;
use Laravel\Nova\Fields\BelongsTo;


class Report extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */

    public static $group = '学员管理';
    public static $model = 'App\Models\Report';

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
        'id',
    ];

    public static function label()
    {
        return "学员报告";
    }

    public static function singularLabel()
    {
        return "学员报告";
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



            Text::make('学员报告','report_number')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                'extraAttributes' => [
                    'placeholder' => '报告标题',
                ],
            ])->readonly(),

            BelongsTo::make('学员','userclassroom','App\Nova\UserClassRoom')->hideWhenUpdating()->searchable(),

            Text::make('标题','title')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                'extraAttributes' => [
                    'placeholder' => '报告标题',
                ],
            ]),



            Text::make('上课时间','date_time')->rules('required', 'max:255'),
            Text::make('上课老师','teacher')->rules('required', 'max:255'),
            Text::make('简要描述','detail')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                'extraAttributes' => [
                    'placeholder' => '简要描述 微信',
                ],
            ])->hideFromIndex(),

            Trix::make('详细报告内容','description')->alwaysShow()->nullable()->hideFromIndex()->withFiles('edushu'), //这里的 withFiles('edushu') 附件内容
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
