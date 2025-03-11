<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory, CrudTrait;

    protected $table = "members";
    protected $fillable = [
        'name', 'photo', 'father_name', 'mother_name', 'birth_date',
        'mother_phone', 'father_phone', 'member_phone', 'address',
        'school', 'register_date', 'foulard', 'junior_degree',
        'second_degree', 'promoted', 'totem', 'totem_name',
        'member_type_id', 'branch_id', 'grade_id', 'branch_badge_id'
    ];

    //----------------------------------------
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function branchBadge()
    {
        return $this->belongsTo(BranchBadge::class);
    }

    public function memberType()
    {
        return $this->belongsTo(MemberType::class, 'member_type_id');
    }

    public function hobbyBadges()
    {
        return $this->belongsToMany(HobbyBadge::class, 'members_hobby_badges', 'member_id', 'hobby_badge_id');
    }

    public function publicBadges()
    {
        return $this->belongsToMany(PublicBadge::class, 'members_public_badges', 'member_id', 'public_badge_id');
    }

    public function branchBadges()
    {
        return $this->belongsToMany(BranchBadge::class, 'members_branch_badges', 'member_id', 'branch_badges_id');
    }

    //------------------------------------------------------------
    public function getFoulardTextAttribute()
    {
        return $this->foulard ? 'نعم' : 'لا';
    }

    public function getJuniorDegreeTextAttribute()
    {
        return $this->junior_degree ? 'نعم' : 'لا';
    }

    public function getSecondDegreeTextAttribute()
    {
        return $this->second_degree ? 'نعم' : 'لا';
    }

    public function getTotemTextAttribute()
    {
        return $this->totem ? 'نعم' : 'لا';
    }

    public function getPromotedTextAttribute()
    {
        return $this->promoted ? 'نعم' : 'لا';
    }

    //-------------------------------------------------------------
    public function upgradeMembersButton()
    {
        return '<a class="btn btn-secondary" href="javascript:void(0);" onclick="confirmUpgrade()">
                    <i class="la la-arrow-up"></i> ترقية صفوف جميع الأعضاء
                </a>

                <script>
                    function confirmUpgrade() {
                        Swal.fire({
                            title: "هل أنت متأكد؟",
                            text: "سيتم ترقية جميع الأعضاء إلى الصف التالي!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "نعم، قم بالترقية!",
                            cancelButtonText: "إلغاء"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "'.route('upgrade-members').'";
                            }
                        });
                    }
                </script>';
    }


}
