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
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Date;
use App\Rules\UserNovelRule;
use Laravel\Nova\Fields\MorphToMany;

class Novel extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */

    public static $group = '借阅';
    public static $model = 'App\Models\Novel';

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
        'title','barcode','author'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
     public static function label()
     {
         return "书";
     }

     public static function singularLabel()
     {
         return "书";
     }

     public function title()
       {
           return $this->title;
       }
    public function fields(Request $request)
    {

        return [
            ID::make()->sortable(),
            Text::make('名称','title')
                ->sortable()
                ->rules('required', 'max:255')
                ->withMeta([
                'extraAttributes' => [
                    'placeholder' => '输入产品名称',
                ],
            ]),
            Text::make('副标题','sub_title')->hideFromIndex()
            ->rules('required', 'max:255'),
            Text::make('条形码','barcode')
            ->rules('required', 'max:255')
            ->hideFromIndex(),
            Text::make('本书字数，必须为阿拉伯数字','words')
                ->rules('required', 'max:255'),
            Text::make('总库存数','stock')
                ->rules('required', 'max:255'),
            Text::make('历史借出次数','rent_count')
                    ->rules('required', 'max:255')->onlyOnIndex(),
            Text::make('当前借出未还','current_rent')
                 ->rules('required', 'max:255')->onlyOnIndex(),

            Currency::make('价格','price')->nullable()->hideFromIndex(),
            /*
            Image::make('image')->disk('edushu')->nullable()->thumbnail(function ($value, $disk) {
                return $value? Storage::disk($disk)->url($value): null;
            }),
            */

            Image::make('图片','image')->disk('edushu')->nullable(),
            Image::make('thumbnail')
            ->disk('edushu')
            ->thumbnail(function ($value, $disk) {
                return $value
                            ? Storage::disk($disk)->url($value)
                            : null;
            })->hideFromIndex(),
            Boolean::make('是否销售','on_sale')->hideFromIndex(),
            Heading::make('详细信息'),
            Text::make('作者','author'),
            Text::make('出版社','press')->hideFromIndex(),
            Trix::make('详细描述','description')->alwaysShow()->nullable()->hideFromIndex()->withFiles('edushu'), //带附件

            KeyValue::make('额外书本信息','features')
                  ->keyLabel('属性') // Customize the key heading
                  ->valueLabel('属性值') // Customize the value heading
                  ->actionText('添加'),// Customize the "add row" button text


            KeyValue::make('meta属性','extras')
                  ->keyLabel('meta属性') // Customize the key heading
                  ->valueLabel('meta属性值') // Customize the value heading
                  ->actionText('添加') // Customize the "add row" button text
                  ->withMeta(['value'=>$this->extras ? $this->extras : ["meta_title"=>"", "meta_description"=>""]]),
            HasMany::make('借阅','rents','App\Nova\Rent')
              ->creationRules('required',new UserNovelRule($request->route('resourceId'))),

              MorphToMany::make('Tags'),

              MorphToMany::make('categories'), //禁止删除的选项

            HasMany::make('comments'),
                /*
            BelongsToMany::make('用户','users','App\Nova\User')->searchable()
                  ->creationRules('required',new UserNovelRule($request->route('resourceId')))
                  ->fields(new Fields\NovelUserFields),
                  */

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

        (new Actions\NovelAction)
          ->confirmText('是否确定要更新？?')
          ->confirmButtonText('更新')
          ->cancelButtonText("撤销操作")
          ->showOnTableRow(),
      ];
    }
}
