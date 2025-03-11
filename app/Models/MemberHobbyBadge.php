<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberHobbyBadge extends Model
{
    use HasFactory;

    protected $table = "members_hobby_badges";
    protected $fillable = [ 'member_id', 'hobby_badge_id' ];
}
