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
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\KeyValue;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $group = 'product';
    public static $model = 'App\Models\Product';

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
        return "产品";
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

                  //  Gravatar::make('Avatar', 'name')->maxWidth(50),

                    Text::make('名称','name')
                        ->sortable()
                        ->rules('required', 'max:255')
                        ->withMeta([
                        'extraAttributes' => [
                            'placeholder' => '输入产品名称',
                        ],
                    ]),
                    Text::make('副标题','sub_title')->hideFromIndex()
                    ->rules('required', 'max:255'),

                    Currency::make('价格','price')->nullable()->hideFromIndex(),
                    /*
                    Image::make('image')->disk('edushu')->nullable()->thumbnail(function ($value, $disk) {
                        return $value? Storage::disk($disk)->url($value): null;
                    }),
                    */
                    Image::make('图片','image')->disk('edushu')->nullable(),
                    Boolean::make('是否销售','on_sale'),
                    Boolean::make('虚拟物品','virtual')->hideFromIndex(),
                    Heading::make('详细信息')->hideFromIndex(),
                    Trix::make('详细描述','description')->alwaysShow()->nullable()->hideFromIndex()->withFiles('edushu'),
                    KeyValue::make('meta属性','extras')
                          ->keyLabel('meta属性') // Customize the key heading
                          ->valueLabel('meta属性值') // Customize the value heading
                          ->actionText('添加') // Customize the "add row" button text
                          ->withMeta(['value'=>$this->extras ? $this->extras : ["meta_title"=>"", "meta_description"=>""]]),


                  //  HasMany::make('users'),

                    //HasMany::make('ProductSku','ProductSku','App\Models\ProductSku'),
                    HasMany::make('SKU','skus','App\Nova\ProductSku'),  // 第一个参数，显示的，第二个参数models里面定义的一对多，多对多关联的，第三个参数，定义的Nova模型
                    MorphToMany::make('tags'),


                    MorphToMany::make('categories'), //禁止删除的选项
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
        return [


        ];
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

          (new Actions\ProductAction)
            ->confirmText('是否确定要更新？?')
            ->confirmButtonText('更新')
            ->cancelButtonText("撤销操作")
            ->showOnTableRow(),
        ];
    }
}
