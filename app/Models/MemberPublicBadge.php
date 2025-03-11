<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPublicBadge extends Model
{
    use HasFactory;

    protected $table = "members_public_badges";
    protected $fillable = [ 'member_id', 'public_badge_id' ];
}
