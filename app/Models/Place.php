<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Segment;

class Place extends Model
{
    use HasFactory;
    protected $fillable = ['name','positions'];

    public function segment()
    {
        return $this->hasMany(Segment::class, 'name', 'place');
    }
}
