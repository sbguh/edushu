<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel("App\Models\Category");
        CRUD::setRoute(config('backpack.base.route_prefix', 'admin').'/category');
        CRUD::setEntityNameStrings('category', 'categories');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn('name');
        CRUD::addColumn('slug');
        CRUD::addColumn([
            'label' => 'Parent',
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name',
        ]);
    }

    protected function setupShowOperation()
    {
        return $this->setupListOperation();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);

        CRUD::addField([
            'name' => 'name',
            'label' => 'Name',
        ]);

        CRUD::addField([ // Text
          'name'        => 'enable', // the name of the db column
           'label'       => 'enable', // the input label
           'type'        => 'radio',
           'options'     => [
               // the key will be stored in the db, the value will be shown as label;
               0 => "False",
               1 => "True"
           ],

        ]);

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



        CRUD::addField([
            'name' => 'slug',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from your name, if left empty.',
            // 'disabled' => 'disabled'
        ]);
        CRUD::addField([
            'label' => 'Parent',
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'name');
        CRUD::set('reorder.max_level', 2);
    }
}
