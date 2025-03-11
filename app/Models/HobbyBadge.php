<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HobbyBadge extends Model
{
    use HasFactory;

    protected $table = "hobby_badges";
    protected $fillable = [ 'name' ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'members_hobby_badges', 'member_id', 'hobby_badge_id');
    }
}
