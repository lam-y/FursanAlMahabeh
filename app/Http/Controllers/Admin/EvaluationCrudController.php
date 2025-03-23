<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EvaluationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EvaluationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EvaluationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitCreate;
    }

    public function setup()
    {
        $this->crud->setModel('App\Models\Evaluation');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/evaluation');
        $this->crud->setEntityNameStrings('evaluation', 'evaluations');
    }

    //---------------------------------------------------------------------------
    protected function setupListOperation()
    {
        CRUD::setColumns([
            [
                'name' => 'member_id',
                'label' => 'العضو',
                'entity' => 'member',
                'model' => "App\Models\Member",
                'attribute' => "name",
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('member', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%$searchTerm%");
                    });
                },
            ],
            [
                'name' => 'form_id',
                'label' => 'نوع التقييم',
                'entity' => 'form',
                'model' => "App\Models\Form",
                'attribute' => "title",
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('form', function ($q) use ($searchTerm) {
                        $q->where('title', 'LIKE', "%$searchTerm%");
                    });
                },
            ],
        ]);
    }

    //---------------------------------------------------------------------------
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(EvaluationRequest::class);

        CRUD::field('member_id')
            ->label('العضو')
            ->type('select2')
            ->entity('member')
            ->attribute('name')
            ->model("App\Models\Member");

        CRUD::field('form_id')
            ->label('نوع التقييم')
            ->type('select2')
            ->entity('form')
            ->attribute('title')
            ->model("App\Models\Form");

        CRUD::addField([
            'name' => 'questions_container',
            'type' => 'custom_html',
            'value' => '<div id="questions-container"></div>',
            'attributes' => ['class' => 'form-control'],
        ]);
    }

    //---------------------------------------------------------------------------
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        // تعطيل حقل العضو في صفحة التعديل
        CRUD::field('member_id')
            ->label('العضو')
            ->type('select2')
            ->entity('member')
            ->attribute('name')
            ->model("App\Models\Member")
            ->attributes(['disabled' => 'disabled']);

        CRUD::field('member_id_hidden')
            ->type('hidden')
            ->value(old('member_id', $this->crud->getCurrentEntry()->member_id));

        CRUD::field('form_id')
            ->label('نوع التقييم')
            ->type('select2')
            ->entity('form')
            ->attribute('title')
            ->model("App\Models\Form");

        CRUD::addField([
            'name' => 'questions_container',
            'type' => 'custom_html',
            'value' => '<div id="questions-container"></div>',
            'attributes' => ['class' => 'form-control'],
        ]);
    }

    //---------------------------------------------------------------------------
    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);

        $this->crud->addColumn(
            [
                'name' => 'member_id',
                'label' => 'اسم العضو',
                'entity' => 'member',
                'attribute' => 'name',
                'model' => 'App\Models\Member'
            ]
        );

        $this->crud->addColumn(
            [
                'name' => 'form_id',
                'label' => 'نوع التقييم',
                'entity' => 'form',
                'attribute' => 'title',
                'model' => 'App\Models\Form'
            ]
        );

        $this->crud->addColumn([
            'name' => 'answers',
            'label' => 'التقييم',
            'type' => 'eval_relationship',
            'entity' => 'answers',
            'attribute' => 'text',
        ]);

    }

    //---------------------------------------------------------------------------
    public function store(EvaluationRequest $request)
    {
        DB::beginTransaction();
        try {
            $evaluationId = Evaluation::create([
                    'form_id' => $request->form_id,
                    'member_id' => $request->member_id,
                ])->id;

            foreach ($request->answers as $key=>$answer) {
                Answer::updateOrCreate(
                    [
                        'evaluation_id' => $evaluationId,
                        'question_id' => $key,
                    ],
                    [
                        'text' => $answer,
                    ]
                );
            }

            DB::commit();
            \Alert::success('Evaluation Done Successfully')->flash();
            return redirect()->route('evaluation.index');
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
        }
    }

    //---------------------------------------------------------------------------
    public function update(EvaluationRequest $request)
    {
        DB::beginTransaction();
        try {
            $evaluation = Evaluation::find($request->id);
            $evaluation->update([
                'form_id' => $request->form_id
            ]);

            Answer::where('evaluation_id', $evaluation->id)->delete();

            foreach ($request->answers as $key=>$answer) {
                Answer::updateOrCreate(
                    [
                        'evaluation_id' => $evaluation->id,
                        'question_id' => $key,
                    ],
                    [
                        'text' => $answer,
                    ]
                );
            }

            DB::commit();
            \Alert::success('Evaluation Done Successfully')->flash();
            return redirect()->route('evaluation.index');
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
        }
    }

    //---------------------------------------------------------------------------
    public function destroy($id)
    {
        Answer::where('evaluation_id', $id)->delete();
        $this->crud->delete($id);
        return response()->json(1);
    }
}
