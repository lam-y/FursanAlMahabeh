<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBranchBadge extends Model
{
    use HasFactory;

    protected $table = "members_branch_badges";
    protected $fillable = [ 'member_id', 'branch_badges_id' ];
}
