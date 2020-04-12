<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

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
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use App\Nova\Fields\UserClassRoomFields;


class ClassRoom extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $group = '学员管理';
    public static $model = 'App\Models\ClassRoom';

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
        return "学员班级";
    }

    public static function singularLabel()
    {
        return "学员班级";
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
          Text::make('班级名称','name')
              ->sortable()
              ->rules('required', 'max:255')
              ->withMeta([
              'extraAttributes' => [
                  'placeholder' => '班级名称',
              ],
          ]),

          Text::make('老师','teacher')
              ->sortable()
              ->rules('required', 'max:255')
              ->withMeta([
              'extraAttributes' => [
                  'placeholder' => '老师必填',
              ],
          ]),

          Number::make('总课时','hours')
              ->sortable()
              ->rules('required', 'max:255')
              ->withMeta([
              'extraAttributes' => [
                  'placeholder' => '总课时',
              ],
          ]),

          Text::make('上课时间','begain_time')
              ->sortable()
              ->rules('required', 'max:255')
              ->withMeta([
              'extraAttributes' => [
                  'placeholder' => '上课时间',
              ],
          ])->hideFromIndex(),
          Text::make('开课时间','start_time')
              ->sortable()
              ->rules('required', 'max:255')
              ->withMeta([
              'extraAttributes' => [
                  'placeholder' => '开课时间',
              ],
          ])->hideFromIndex(),

          Text::make('上课地点','address')
              ->sortable()
              ->rules('required', 'max:255')
              ->withMeta([
              'extraAttributes' => [
                  'placeholder' => '上课地点',
              ],
          ])->hideFromIndex(),
          Boolean::make("是否群发",'delivery')->onlyOnForms(),
          Textarea::make('群发内容','description')->alwaysShow()->nullable()->hideFromIndex()->help(
            '群发!!!!！如果不为空则群发，特别注意！需要修改上面信息且不群发需要清空这里'
          )->onlyOnForms(),


          Text::make('image')->nullable()->onlyOnForms()->help(
          '如果为空，会自动生成'
          )->onlyOnForms(),
                      Text::make('media_id')->nullable()->hideFromIndex()->help(
              'image_group 上传后，微信公众号生成的永久素材ID'
          )->onlyOnForms(),
                      Image::make('image_group')->disk('edushu')->nullable()->hideFromIndex()->help(
              '可以上传微信群二维码图片到微信公众号永久素材'
          )->onlyOnForms(),
          HasMany::make('学员','users', 'App\Nova\UserClassRoom'),

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
        return [];
    }
}
