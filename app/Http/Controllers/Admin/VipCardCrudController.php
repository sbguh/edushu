<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VipCardRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VipCardCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VipCardCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\VipCard');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/vipcard');
        $this->crud->setEntityNameStrings('vipcard', 'vip_cards');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(VipCardRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        //$this->crud->setFromDb();

        CRUD::addField([  // Select2
            'label'     => '微信号',
            'type'      => 'select2',
            'name'      => 'user_id', // the db column for the foreign key
            'entity'    => 'user', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'attributes' => [
    //   'readonly'=>'readonly',
    //   'disabled'=>'disabled',
     ],
            // 'wrapperAttributes' => [
            //     'class' => 'form-group col-md-6'
            //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields
          'tab'  => 'Texts',
        ]);

        CRUD::addField([ // Text
            'name'  => 'real_name',
            'label' => '姓名',
            'type'  => 'text',
            'tab'   => 'Texts',
        ]);

        CRUD::addField([ // Text
            'name'  => 'phone_number',
            'label' => '电话',
            'type'  => 'text',
            'tab'   => 'Texts',
        ]);

        CRUD::addField([ // Text
          'name'        => 'gender', // the name of the db column
           'label'       => '性别', // the input label
           'type'        => 'radio',
           'default' => 1,
           'options'     => [
               // the key will be stored in the db, the value will be shown as label;
               0 => "女",
               1 => "男"
           ],
           'tab'   => 'Texts',
        ]);
        CRUD::addField([ // Text
          'name' => 'birthday',
          'label' => 'Birthday',
          'type' => 'date',
          'tab'   => 'Texts',
        ]);

        CRUD::addField([ // Text
          'name' => 'deposit',
          'label' => '押金',
          'type' => 'number',
          'default' => 0,
          'tab'   => 'Texts',
        ]);

        CRUD::addField([ // Text
          'name' => 'balance',
          'label' => '余额',
          'type' => 'number',
          'default' => 0,
          'tab'   => 'Texts',
        ]);


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
