<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContactMessageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContactMessageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactMessageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\ContactMessage');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/contactmessage');
        $this->crud->setEntityNameStrings('contactmessage', 'contact_messages');
        $this->crud->denyAccess(['update', 'create']);
    }

    protected function setupListOperation()
    {
        CRUD::setColumns([
            [
                'name' => 'name',
                'label' => 'الاسم'
            ],
            [
                'name' => 'email',
                'label' => 'الايميل'
            ],
            [
                'name' => 'phone',
                'label' => 'رقم الموبايل'
            ],
            [
                'name' => 'birthdate',
                'label' => 'تاريخ الميلاد'
            ],
            [
                'name' => 'school',
                'label' => 'المدرسة'
            ],
            [
                'name' => 'grade_id',
                'label' => 'الصف',
                'entity' => 'grade',
                'model' => "App\Models\Grade",
                'attribute' => "name",
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('grade', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%$searchTerm%");
                    });
                },
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ContactMessageRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }


    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);

        CRUD::setColumns([
            [
                'name' => 'name',
                'label' => 'الاسم'
            ],
            [
                'name' => 'email',
                'label' => 'الايميل'
            ],
            [
                'name' => 'phone',
                'label' => 'رقم الموبايل'
            ],
            [
                'name' => 'birthdate',
                'label' => 'تاريخ الميلاد'
            ],
            [
                'name' => 'school',
                'label' => 'المدرسة'
            ],
            [
                'name' => 'grade_id',
                'label' => 'الصف',
                'entity' => 'grade',
                'model' => "App\Models\Grade",
                'attribute' => "name",
            ],
            [
                'name' => 'message',
                'label' => 'الرسالة'
            ],
        ]);
    }
}
