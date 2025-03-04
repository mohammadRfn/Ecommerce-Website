<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatusEnum;
use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.
        CRUD::column('title')->label('Title');
        CRUD::column('slug')->label('Slug');
        CRUD::column('description')->type('text')->label('Description');
        CRUD::column('department_id')->label('Department')->type('select')
            ->entity('department')->model('App\Models\Department')->attribute('name');
        CRUD::column('category_id')->label('Category')->type('select')
            ->entity('category')->model('App\Models\Category')->attribute('name');
        CRUD::column('quantity')->type('number')->label('Quantity');
        CRUD::column('price')->type('number')->label('Price');
        CRUD::column('status')->label('Status')->type('select_from_array')
            ->options(ProductStatusEnum::labels());
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.
        CRUD::field('title')->type('text')->label('Title');
        CRUD::field('slug')->type('text')->label('Slug');
        CRUD::field('description')->type('textarea')->label('Description');

        CRUD::field('department_id')->label('Department')->type('select')
            ->entity('department')->model('App\Models\Department')->attribute('name');

        CRUD::field('category_id')->label('Category')->type('select')
            ->entity('category')->model('App\Models\Category')->attribute('name');

        CRUD::field('quantity')->type('number')->label('Quantity');
        CRUD::field('price')->type('number')->label('Price');

        CRUD::field('status')->label('Status')->type('select_from_array')
            ->options(ProductStatusEnum::labels());
        // Automatically assign created_by and updated_by
        CRUD::addField([
            'name' => 'created_by',
            'type' => 'hidden',
            'value' => backpack_auth()->id(),
        ]);

        CRUD::addField([
            'name' => 'updated_by',
            'type' => 'hidden',
            'value' => backpack_auth()->id(),
        ]);
        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        CRUD::modifyField('created_by', ['attributes' => ['disabled' => 'disabled']]); // Disable editing
        CRUD::modifyField('updated_by', ['value' => backpack_auth()->id()]); // Update updated_by field
    }
}
