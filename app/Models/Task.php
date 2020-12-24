<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'is_done',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
