<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicBadge extends Model
{
    use HasFactory;

    protected $table = "public_badges";
    protected $fillable = [ 'name' ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'members_public_badges', 'member_id', 'public_badge_id');
    }
}
