<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'profile_pic',
    ];

    protected $hidden = [
        'password',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'assign');
    }

}
