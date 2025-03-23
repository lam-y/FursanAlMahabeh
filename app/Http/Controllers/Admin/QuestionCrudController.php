<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class QuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QuestionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Question');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/question');
        $this->crud->setEntityNameStrings('question', 'questions');
    }

    protected function setupListOperation()
    {
        CRUD::setColumns([
            [
                'name' => 'form_id',
                'label' => 'النموذج',
                'entity' => 'form',
                'model' => "App\Models\Form",
                'attribute' => "title",
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('form', function ($q) use ($searchTerm) {
                        $q->where('title', 'LIKE', "%$searchTerm%");
                    });
                },
            ],
            [
                'name' => 'text',
                'label' => 'السؤال'
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(QuestionRequest::class);

        CRUD::field('form_id')
            ->label('النموذج')
            ->type('select2')
            ->entity('form')
            ->attribute('title')
            ->model("App\Models\Form");

        CRUD::field('text')->label('السؤال');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
