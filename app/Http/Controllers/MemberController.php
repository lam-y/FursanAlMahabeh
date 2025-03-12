<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::select('members.name', 'members.photo', 'member_types.name as member_type_name')
                            ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
                            // ->orderBy('members.created_at', 'desc')
                            ->paginate(48);

        return view('front.all-members', compact('members'));
    }

    //----------------------------------------------
    public function export()
    {
        return Excel::download(new MembersExport, 'members.xlsx');
    }

    //---------------------------------------------------
    public function upgradeMembers()
    {
        $grades = Grade::orderBy('id')->pluck('id', 'name')->toArray();

        Member::all()->each(function ($member) use ($grades) {
            $currentIndex = array_search($member->grade_id, array_values($grades));
            if ($currentIndex !== false && $currentIndex < count($grades) - 1) {
                $member->update(['grade_id' => array_values($grades)[$currentIndex + 1]]);
            }
        });

        \Alert::success('تمت ترقية جميع الأعضاء بنجاح!')->flash();
        return redirect()->back();
    }

}
