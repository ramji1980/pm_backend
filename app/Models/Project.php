<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = ['title','description','created_by','status','start_date','end_date'];


    public function owner(){ return $this->belongsTo(User::class,'created_by'); }
    public function tasks(){ return $this->hasMany(Task::class); }
}
