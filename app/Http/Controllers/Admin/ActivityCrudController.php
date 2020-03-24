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
