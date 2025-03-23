<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory, CrudTrait;

    protected $table = "evaluations";
    protected $fillable = ['form_id', 'member_id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
