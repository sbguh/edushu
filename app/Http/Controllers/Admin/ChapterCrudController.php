<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChapterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ChapterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChapterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Chapter');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/chapter');
        $this->crud->setEntityNameStrings('chapter', 'chapters');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        //$this->crud->setFromDb();

        CRUD::addColumns(['id','title']); // add multiple columns, at the end of the stack
        CRUD::addColumn([
            // 1-n relationship
            'label'          => '书名', // Table column heading
            'type'           => 'select',
            'name'           => 'book_id', // the column that contains the ID of that connected entity;
            'entity'         => 'book', // the method that defines the relationship in your Model
            'attribute'      => 'name', // foreign key attribute that is shown to user
            'visibleInTable' => true,
            'visibleInModal' => false,
        ]);

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ChapterRequest::class);


        CRUD::addField([ // Text
            'name'  => 'title',
            'label' => '章节标题',
            'type'  => 'text',
            'tab'   => 'Texts',

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


        CRUD::addField([   // Textarea
            'name'  => 'content',
            'label' => '内容',
            'type' => 'wysiwyg',

            'tab'   => 'Texts',
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

        CRUD::addField([  // Select2
            'label'     => '书',
            'type'      => 'select2',
            'name'      => 'book_id', // the db column for the foreign key
            'entity'    => 'book', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            // 'wrapperAttributes' => [
            //     'class' => 'form-group col-md-6'
            //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields
          'tab'  => 'Texts',
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
