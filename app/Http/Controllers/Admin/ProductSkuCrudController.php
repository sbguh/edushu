<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductSkuRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductSkuCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductSkuCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Product_sku');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product_sku');
        $this->crud->setEntityNameStrings('product_sku', 'product_skus');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        //$this->crud->setFromDb();
        CRUD::addColumns(['id','title','price','stock']); // add multiple columns, at the end of the stack

        CRUD::addColumn([
            // 1-n relationship
            'label'          => 'Product', // Table column heading
            'type'           => 'select',
            'name'           => 'product_id', // the column that contains the ID of that connected entity;
            'entity'         => 'product', // the method that defines the relationship in your Model
            'attribute'      => 'name', // foreign key attribute that is shown to user
            'visibleInTable' => true,
            'visibleInModal' => false,
        ]);

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(Product_skuRequest::class);

        CRUD::addField([ // Text
            'name'  => 'title',
            'label' => '名称',
            'type'  => 'text',
            'tab'   => 'Texts',
        ]);

        CRUD::addField([   // Textarea
            'name'  => 'description',
            'label' => 'Description',
            'type'  => 'textarea',
            'tab'   => 'Texts',
        ]);

        CRUD::addField([  // Select2
            'label'     => 'Product',
            'type'      => 'select2',
            'name'      => 'product_id', // the db column for the foreign key
            'entity'    => 'product', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            // 'wrapperAttributes' => [
            //     'class' => 'form-group col-md-6'
            //   ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            'tab' => 'Texts',
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
            'tab' => 'Texts',
        ]);

        CRUD::addField([   // Number
            'name'  => 'stock',
            'label' => 'stock',
            'type'  => 'text', //number
            'default' => '100',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
          //  'suffix' => '.00',
            // 'wrapperAttributes' => [
            //    'class' => 'form-group col-md-6'
            //  ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            'tab' => 'Texts',
        ]);

        // TODO: remove setFromDb() and manually define Fields
      //$this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
  }
