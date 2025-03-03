<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
    ];

    public function children()
    {
        return $this->belongsToMany(
            People::class,
            'relationships',
            'parent_id',
            'child_id'
        );
    }

    public function parents()
    {
        return $this->belongsToMany(
            People::class,
            'relationships',
            'child_id',
            'parent_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(People::class, 'created_by');
    }
}
