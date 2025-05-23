<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'assign');
    }

}
