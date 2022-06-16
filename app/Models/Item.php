<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Segment;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name','strength','speed','endurance'];

    public function segment()
    {
        return $this->hasMany(Segment::class, 'name', 'item');
    }
}
