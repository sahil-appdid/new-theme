<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    use HasFactory;
    protected $guarded = [];

     protected $fillable = [
        'employee_id',
        'project_id',
    ];

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
