<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, CrudTrait;

    protected $table = "questions";
    protected $fillable = ['form_id', 'text'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function evaluation()
    {
        return $this->hasMany(Evaluation::class);
    }
}
