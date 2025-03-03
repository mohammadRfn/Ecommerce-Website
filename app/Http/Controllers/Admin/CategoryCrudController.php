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
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $this->middleware(['role:Admin']);
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('category', 'categories');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // set columns from db columns.
        CRUD::column('name')->label('Category name');
        CRUD::column('parent')
        ->label('Parent Category')
        ->type('select')
        ->entity('parent') // Define the relationship name
        ->model('App\Models\Category') // Define the related model
        ->attribute('name');
        CRUD::column('department_id')->label('Department name');
        CRUD::column('active')->label('Active')->type('boolean')->options([1 => 'Yes', 0 => 'No']);

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
        CRUD::setValidation(CategoryRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.
        CRUD::field('name')->label('Category Name');
        // Add the category field
        CRUD::addField([
            'name' => 'Department_id',  // Foreign key column
            'label' => 'Department',    // The field label
            'type' => 'select',       // Use select (not select2)
            'entity' => 'department',   // Relationship method on Department model
            'model' => 'App\Models\Department',  // Category model
            'attribute' => 'name',    // What to display in the dropdown
            'searchable' => true,     // Make the dropdown searchable
        ]);
        CRUD::addField([
            'name' => 'parent_id',      // Foreign key column
            'label' => 'Parent Category', // The field label
            'type' => 'select',         // Use select2 for better UX
            'entity' => 'parent',        // Relationship method on Category model
            'model' => 'App\Models\Category',  // Category model (self-referencing)
            'attribute' => 'name',       // What to display in the dropdown
            'searchable' => true,        // Make the dropdown searchable
            'allows_null' => true,       // Allow no parent (root category)
        ]);
        CRUD::field('active')->type('checkbox')->label('Active');
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
    }
}
