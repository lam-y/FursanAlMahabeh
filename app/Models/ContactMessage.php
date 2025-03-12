<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory, CrudTrait;

    protected $table = "contact_messages";
    protected $fillable = ['name', 'email', 'phone', 'message', 'birthdate', 'school', 'grade_id'];

    //------------------------------------------------------
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
