<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserAddressRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class useraddressCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserAddressCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\UserAddress');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/useraddress');
        $this->crud->setEntityNameStrings('useraddress', 'user_addresses');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        //$this->crud->setFromDb();

        CRUD::addColumns(['contact_name', 'address']); // add multiple columns, at the end of the stack

        CRUD::addColumn([
            // 1-n relationship
            'label'     => 'User',
            'type'      => 'select',
            'name'      => 'user_id', // the db column for the foreign key
            'entity'    => 'user', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'visibleInTable' => true,
            'visibleInModal' => false,
        ]);

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(UserAddressRequest::class);

        CRUD::addField([  // Select2
            'label'     => 'User',
            'type'      => 'select2',
            'name'      => 'user_id', // the db column for the foreign key
            'entity'    => 'user', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            // 'wrapperAttributes' => [
            //     'class' => 'form-group col-md-6'
            //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields

        ]);

        $this->crud->addFields([[
                'name'  => 'province',
                'label' => "Province",
                'type'  => 'text',
            ],
            [
                'name'  => 'city',
                'label' => "city",
                'type'  => 'text',
            ],
            [
                'name'  => 'district',
                'label' => "district",
                'type'  => 'text',
            ],
            [
                'name'  => 'address',
                'label' => "address",
                'type'  => 'text',
            ],
            [
                'name'  => 'zip',
                'label' => "zip",
                'type'  => 'text',
            ],
            [
                'name'  => 'contact_name',
                'label' => "contact_name",
                'type'  => 'text',
            ],
            [
                'name'  => 'contact_phone',
                'label' => "contact_phone",
                'type'  => 'text',
            ]
          ]
          );
          $this->crud->setOperationSetting('contentClass', 'col-md-12');

        // TODO: remove setFromDb() and manually define Fields
        //$this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
