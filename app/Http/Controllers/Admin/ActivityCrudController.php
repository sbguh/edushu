<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ActivityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ActivityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ActivityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Activity');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/activity');
        $this->crud->setEntityNameStrings('activity', 'activities');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ActivityRequest::class);

        // TODO: remove setFromDb() and manually define Fields
      //  $this->crud->setFromDb();

      CRUD::addField([ // Text
          'name'  => 'name',
          'label' => '名称',
          'type'  => 'text',
          'tab'   => 'Texts',
      ]);

      CRUD::addField([ // Text
          'name'  => 'slug',
          'label' => 'slug',
          'type'  => 'text',
          'tab'   => 'Texts',
      ]);

      CRUD::addField([ // Text
          'name'  => 'image',
          'label' => 'image',
          'type'  => 'text',
          'tab'   => 'Texts',
      ]);


      CRUD::addField([ // Text
          'name'  => 'description',
          'label' => 'description',
          'type'  => 'wysiwyg',
          'tab'   => 'Texts',
      ]);



      CRUD::addField([
          'label' => "微信群二维码图片",
          'name' => "image_group",
          'type' => 'image',
          'upload' => true,
          'crop' => true, // set to true to allow cropping, false to disable
          'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
            'tab' => 'Texts',
          // 'disk' => 's3_bucket', // in case you need to show images from a different disk
          // 'prefix' => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
      ]);




      CRUD::addField([ // Text
          'name'  => 'media_id',
          'label' => '微信群二维码图片永久素材ID',
          'type'  => 'text',
          'tab'   => 'Texts',
      ]);



      CRUD::addField([   // Textarea
          'label' => "Users",
          'type' => 'select2_multiple',
          'name' => 'users', // the method that defines the relationship in your Model
          'entity' => 'users', // the method that defines the relationship in your Model
          'attribute' => 'name', // foreign key attribute that is shown to user
          'pivot' => true, // on create&update, do you need to add/delete pivot table entries?

          // optional
          'model' => "App\User", // foreign key model
          'options'   => (function ($query) {
              return $query->orderBy('name', 'ASC')->get();
          }),

          'tab'   => 'Texts',
      ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
