<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Webfactor\Laravel\Backpack\InstantFields\InstantFields;
/**
 * Class BookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookCrudController extends CrudController
{
    use InstantFields;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    //use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;

  //  use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }

        // ...



    public function setup()
    {
      //$this->setAjaxEntity('entity');
      $this->setAjaxStoreRequest(\RequestNamespace\StoreRequest::class);
      $this->setAjaxUpdateRequest(\RequestNamespace\UpdateRequest::class);
      //$this->crud->setEditView('vendor.backpack.crud.books.edit');
      $this->crud->setCreateView('vendor.backpack.crud.books.create');
        $this->crud->setModel('App\Models\Book');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/book');
        $this->crud->setEntityNameStrings('book', 'books');

    }







    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        //$this->crud->setFromDb();

        CRUD::addColumns(['id','name']); // add multiple columns, at the end of the stack
        CRUD::addColumn([
            'name'           => 'price',
            'type'           => 'text',
            'label'          => 'Price',
            'visibleInTable' => true,
            'visibleInModal' => true,
        ]);


    }

    protected function setupCreateOperation()
    {



        //$this->crud->setValidation(BookRequest::class);

        CRUD::setValidation(BookRequest::class);

        CRUD::addField([ // Text
            'name'  => 'name',
            'label' => '标题',
            'type'  => 'text',
            'tab'   => 'Texts',
            'attributes'=>['v-model'=>'name'],

            // optional
            //'prefix' => '',
            //'suffix' => '',
            //'default'    => 'some value', // default value
            //'hint'       => 'Some hint text', // helpful text, show up after input
            //'attributes' => [
            //'placeholder' => 'Some text when empty',
            //'class' => 'form-control some-class'
            //], // extra HTML attributes and values your input might need
            //'wrapperAttributes' => [
            //'class' => 'form-group col-md-12'
            //], // extra HTML attributes for the field wrapper - mostly for resizing fields
            //'readonly'=>'readonly',
        ]);

        CRUD::addField([ // Text
            'name'  => 'barcode',
            'label' => '条码',
            'type'  => 'text',
            'tab'   => 'Texts',
        ]);

        CRUD::addField([ // Text
          'name'        => 'check_subscribe', // the name of the db column
           'label'       => '是否设置为关注公众号才可以观看', // the input label
           'type'        => 'radio',
           'options'     => [
               // the key will be stored in the db, the value will be shown as label;
               0 => "False",
               1 => "True"
           ],
           'tab'   => 'Texts',
        ]);


        CRUD::addField([ // Text
            'name'  => 'stock',
            'label' => '库存',
            'type'  => 'text',
            'tab'   => 'Texts',
        ]);


        CRUD::addField([ // Text
          'name'        => 'on_sale', // the name of the db column
           'label'       => 'on sale', // the input label
           'type'        => 'radio',
           'options'     => [
               // the key will be stored in the db, the value will be shown as label;
               0 => "False",
               1 => "True"
           ],
           'tab'   => 'Texts',
        ]);


        CRUD::addField([ // Text
          'name'        => 'state', // the name of the db column
           'label'       => 'state', // the input label
           'type'        => 'radio',
           'options'     => [
               // the key will be stored in the db, the value will be shown as label;
               0 => "disable",
               1 => "enable"
           ],
           'tab'   => 'Texts',
        ]);

        CRUD::addField([ // Text
            'name'  => 'author',
            'label' => '作者',
            'type'  => 'text',
            'tab'   => 'Texts',
        ]);

        CRUD::addField([   // Textarea
            'name'  => 'description',
            'label' => 'Description',
            'type' => 'wysiwyg',

            'tab'   => 'Texts',
        ]);

        CRUD::addField([   // Textarea
            'label' => "Tags",
            'type' => 'select2_multiple',
            'name' => 'tags', // the method that defines the relationship in your Model
            'entity' => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?

            // optional
            'model' => "App\Models\Tag", // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }),

            'tab'   => 'Texts',
        ]);

        CRUD::addField([   // Textarea
            'label' => "Categories",
            'type' => 'select2_multiple',
            'name' => 'categories', // the method that defines the relationship in your Model
            'entity' => 'categories', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?

            // optional
            'model' => "App\Models\Category", // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }),

            'tab'   => 'Texts',
        ]);

/*
        CRUD::addField([   // Textarea
            'label' => "chapters",
            'type' => 'select2_multiple',
            'name' => 'chapters', // the method that defines the relationship in your Model
          //  'entity' => 'books', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            //'pivot' => false, // on create&update, do you need to add/delete pivot table entries?

            // optional
            'model' => "App\Models\Chapter", // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('title', 'ASC')->get();
            }),

            'tab'   => 'Texts',
        ]);
*/
        CRUD::addField([
            'label' => "Profile Image",
            'name' => "image",
            'type' => 'image',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
              'tab' => 'Texts',
            // 'disk' => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix' => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);


        CRUD::addField([ // Table
          'name' => 'images',
          'label' => 'Images',
          'type' => 'upload_multiple',
          'upload' => true,
            'tab' => 'Texts',
        ]);

        CRUD::addField([ // Table
          'name' => 'audio',
          'label' => 'MP3音频',
          'type' => 'upload',
          'disk' => 'edushu',
          'upload' => true,
            'tab' => 'Texts',
        ]);

        CRUD::addField([ // Table
          'name' => 'video',
          'label' => 'MP4视频',
          'type' => 'upload',
          'disk' => 'edushu',
          'upload' => true,
            'tab' => 'Texts',
        ]);



        CRUD::addField([ // Table
            'name'            => 'features',
            'label'           => 'Features',
            'type'            => 'table',
            'entity_singular' => 'feature', // used on the "Add X" button
            'columns'         => [
                'name' => 'Feature',
                'desc' => 'Value',
            ],
            'max' => 25, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table
            'tab' => 'Texts',
        ]);

        CRUD::addField([ // Table
            'name'            => 'extra_features',
            'label'           => 'Extra Features',
            'type'            => 'table',
            'entity_singular' => 'extra feature', // used on the "Add X" button
            'columns'         => [
                'name' => 'Feature',
                'desc' => 'Value',
            ],
            'fake' => true,
            'max'  => 25, // maximum rows allowed in the table
            'min'  => 0, // minimum rows allowed in the table
            'tab'  => 'Texts',
        ]);


        CRUD::addField([   // Number
            'name'  => 'price',
            'label' => 'Price',
            'type'  => 'text', //number
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            'prefix' => '$',
          //  'suffix' => '.00',
            // 'wrapperAttributes' => [
            //    'class' => 'form-group col-md-6'
            //  ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            'tab' => 'Basic Info',
        ]);

        CRUD::addFields([
            [ // Text
                'name'  => 'meta_title',
                'label' => 'Meta Title',
                'type'  => 'text',
                'fake'  => true,
                'tab'   => 'Metas',
            ],
            [ // Text
                'name'  => 'meta_description',
                'label' => 'Meta Description',
                'type'  => 'text',
                'fake'  => true,
                'tab'   => 'Metas',
            ],
            [ // Text
                'name'  => 'meta_keywords',
                'label' => 'Meta Keywords',
                'type'  => 'text',
                'fake'  => true,
                'tab'   => 'Metas',
            ],
        ]);


        $this->crud->setOperationSetting('contentClass', 'col-md-12');


        // TODO: remove setFromDb() and manually define Fields
        //$this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
