<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = "branches";
    protected $fillable = [ 'name' ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
