<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Storage;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MemberCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MemberCrudController extends CrudController
{
    use UploadFile;
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
        $this->crud->setModel('App\Models\Member');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/member');
        $this->crud->setEntityNameStrings('member', 'members');
    }

    //---------------------------------------------------------------------------
    protected function setupListOperation()
    {
        CRUD::addButtonFromView('top', 'export_excel', 'export_excel', 'end');
        CRUD::addButtonFromModelFunction('top', 'upgrade_members', 'upgradeMembersButton', 'end');

        CRUD::setColumns([
            [
                'name' => 'photo',
                'label' => 'صورة',
                'type' => 'image',
                'disc' => 'public',
                'prefix' => 'storage/members/',
                'height' => '80px',
                'width'  => '80px',
            ],
            [
                'name' => 'name',
                'label' => 'الاسم'
            ],
            [
                'name' => 'member_phone',
                'label' => 'رقم الفارس'
            ],
            [
                'name' => 'grade_id',
                'label' => 'الصف',
                'entity' => 'grade',
                'model' => "App\Models\Grade",
                'attribute' => "name",
            ],
            [
                'name' => 'register_date',
                'label' => 'تاريخ الانضمام'
            ],
            [
                'name' => 'member_type_id',
                'label' => 'النوع',
                'entity' => 'memberType',
                'model' => "App\Models\MemberType",
                'attribute' => "name",
            ],
            [
                'name' => 'branch_id',
                'label' => 'الفرع',
                'entity' => 'branch',
                'model' => "App\Models\Branch",
                'attribute' => "name",
            ],

        ]);
    }

    //---------------------------------------------------------------------------
    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);

        CRUD::setColumns([
            [
                'name' => 'photo',
                'label' => 'صورة',
                'type' => 'image',
                'disc' => 'public',
                'prefix' => 'storage/members/',
                'height' => '200px',
                'width'  => '200px',
            ],
            [
                'name' => 'name',
                'label' => 'الاسم'
            ],
            [
                'name' => 'father_name',
                'label' => 'اسم الأب'
            ],
            [
                'name' => 'mother_name',
                'label' => 'اسم الأم'
            ],
            [
                'name' => 'birth_date',
                'label' => 'تاريخ الميلاد'
            ],
            [
                'name' => 'member_phone',
                'label' => 'رقم الفارس'
            ],
            [
                'name' => 'father_phone',
                'label' => 'رقم الأب'
            ],
            [
                'name' => 'mother_phone',
                'label' => 'رقم الأم'
            ],
            [
                'name' => 'address',
                'label' => 'العنوان'
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
                'name' => 'register_date',
                'label' => 'تاريخ الانضمام'
            ],
            [
                'name' => 'foulard_text',
                'label' => 'مثبت (فولار)'
            ],
            [
                'name' => 'junior_degree_text',
                'label' => 'درجة مبتدئ'
            ],
            [
                'name' => 'second_degree_text',
                'label' => 'درجة ثانية'
            ],
            [
                'name' => 'hobbyBadges',
                'label' => "أوسمة (هوايات)",
                'entity' => 'hobbyBadges',
                'model' => "App\Models\HobbyBadge",
                'attribute' => "name",
            ],
            [
                'name' => 'branchBadges',
                'label' => "أوسمة فرع",
                'entity' => 'branchBadges',
                'model' => "App\Models\BranchBadge",
                'attribute' => "name",
            ],
            [
                'label' => "النوع",
                'name' => 'member_type_id',
                'entity' => 'memberType',
                'model' => "App\Models\MemberType",
                'attribute' => "name",
            ],
            [
                'name' => 'promoted_text',
                'label' => 'ترفيع'
            ],
            [
                'label' => "الفرع",
                'name' => 'branch_id',
                'entity' => 'branch',
                'model' => "App\Models\Branch",
                'attribute' => "name",
            ],
            [
                'name' => 'totem_text',
                'label' => 'توتيم'
            ],
            [
                'name' => 'totem_name',
                'label' => 'توتيم'
            ],
            [
                'label' => "أوسمة عامة",
                'name' => 'publicBadges',
                'entity' => 'publicBadges',
                'model' => "App\Models\PublicBadge",
                'attribute' => "name",
            ]
        ]);
    }

    //---------------------------------------------------------------------------
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MemberRequest::class);

        CRUD::field('name')->label('الاسم');
        CRUD::field('father_name')->label('اسم الأب');
        CRUD::field('mother_name')->label('اسم الأم');
        CRUD::field('birth_date')->label('تاريخ الميلاد');
        CRUD::field('photo')
            ->type('upload')
            ->label('صورة شخصية')
            ->upload('public/members')
            ->withFiles([
                'disk' => 'public',
                'path' => 'members',
            ])
            ->attributes([
                'accept' => 'image/*', // السماح باختيار الصور فقط
            ]);
        CRUD::field('mother_phone')->label('رقم الأم');
        CRUD::field('father_phone')->label('رقم الأب');
        CRUD::field('member_phone')->label('رقم الفارس');
        CRUD::field('address')->label('العنوان');
        CRUD::field('school')->label('المدرسة');
        CRUD::field('register_date')->label('تاريخ التسجيل');
        CRUD::addField([
            'label' => "الصف",
            'type' => "select2",
            'name' => 'grade_id',
            'entity' => 'grade',
            'model' => "App\Models\Grade",
            'attribute' => "name",
            'default' => null,
            'allows_null' => true,
        ]);
        CRUD::field('foulard')->type('toggle')->label('(فولار)مثبت');
        CRUD::field('junior_degree')->type('toggle')->label('درجة مبتدئ');
        CRUD::field('second_degree')->type('toggle')->label('درجة ثانية');

        CRUD::addField([
            'label' => "أوسمة فرع",
            'type' => "select2_multiple",
            'name' => 'branchBadges',
            'entity' => 'branchBadges',
            'model' => "App\Models\BranchBadge",
            'attribute' => "name",
            'pivot' => true,
        ]);

        CRUD::addField([
            'label' => "أوسمة(هوايات)",
            'type' => "select2_multiple",
            'name' => 'hobbyBadges',
            'entity' => 'hobbyBadges',
            'model' => "App\Models\HobbyBadge",
            'attribute' => "name",
            'pivot' => true,
        ]);


        //--------------------
        // Chief
        CRUD::addField([
            'label' => "النوع",
            'type' => "select2",
            'name' => 'member_type_id',
            'entity' => 'memberType',
            'model' => "App\Models\MemberType",
            'attribute' => "name",
            'default' => null,
            'allows_null' => true,
        ]);

        CRUD::addField([
            'label' => 'ترفيع',
            'name'  => 'promoted',
            'type'  => 'toggle',
        ]);


        CRUD::addField([
            'label' => "الفرع",
            'type' => "select2",
            'name' => 'branch_id',
            'entity' => 'branch',
            'model' => "App\Models\Branch",
            'attribute' => "name",
            'default' => null,
            'allows_null' => true,
        ]);

        CRUD::field('totem')->label('التوتيم')->type('toggle');
        CRUD::field('totem_name')->label('التوتيم');

        CRUD::addField([
            'label' => "أوسمة عامة",
            'type' => "select2_multiple",
            'name' => 'publicBadges',
            'entity' => 'publicBadges',
            'model' => "App\Models\PublicBadge",
            'attribute' => "name",
            'pivot' => true,
        ]);
    }

    //---------------------------------------------------------------------------
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    //---------------------------------------------------------------------------
    public function store(MemberRequest $request)
    {
        DB::beginTransaction();
        try {
            $photo = $request->hasFile('photo') ? $this->uploadFile('members/', $request->file('photo')) : null;

            $data = $this->crud->getRequest()->except(['photo']);
            $member = $this->crud->create($data);
            $member->update([
                'photo' => $photo
            ]);

            DB::commit();
            \Alert::success('Member created successfully')->flash();
            return redirect()->route('member.index');
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
        }
    }

    //----------------------------------------------------------------
    public function update(MemberRequest $request)
    {
        DB::beginTransaction();
        try {
            $id = $this->crud->getRequest()->get('id');
            $member = $this->crud->getEntry($id);

            if ($request->hasFile('photo')) {
                if ($member->photo) {
                    Storage::disk('public')->delete('members/' . $member->photo);
                }

                $data['photo'] = $this->uploadFile('members/', $request->file('photo'));
            } else {
                $data['photo'] = $member->photo;
            }

            $updateData = $this->crud->getRequest()->except(['photo']);
            $updateData['photo'] = $data['photo'];

            $member = $this->crud->update($id, $updateData);

            DB::commit();
            \Alert::success('Member created successfully')->flash();
            return redirect()->route('member.index');
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
        }
    }

    //----------------------------------------------------------------
    public function destroy($id)
    {
        $member = $this->crud->getEntry($id);

        // حذف الصورة من التخزين إذا كانت موجودة
        if ($member->photo) {
            Storage::disk('public')->delete('members/' . $member->photo);
        }

        // استدعاء الدالة الأصلية للحذف من قاعدة البيانات
        $this->crud->delete($id);
        return redirect()->route('member.index');
    }

}
