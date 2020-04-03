<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductSkuRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Product;

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
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\ProductSku');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/productsku');
        $this->crud->setEntityNameStrings('productsku', 'product_skus');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    public function fetchProduct()
    {
        //return $this->fetch(Product::class);
        return $this->fetch([
            'model' => Product::class, // required
            'searchable_attributes' => ['name'],
            'paginate' => 10, // items to show per page

        ]);

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ProductSkuRequest::class);

        // TODO: remove setFromDb() and manually define Fields
      //  $this->crud->setFromDb();

      //CRUD::addField(['name']);

      CRUD::addField([ // Text
          'name'  => 'title',
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

      CRUD::addField([ // Text
          'name'  => 'stock',
          'label' => '库存',
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
        'type' => "relationship",
        'name' => 'product_id', // the method on your model that defines the relationship
        'entity' => 'product',
        'ajax' => true,
        'inline_create' => true, // assumes the URL will be "/admin/category/inline/create"

              'tab'   => 'Texts',
          ]);


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
