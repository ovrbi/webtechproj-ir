<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Segment;
use App\Models\User;

class Speedrun extends Model
{
    use HasFactory;
    protected $fillable = ['timetotal','damagetaken','video', 'posted'];

    public function segment()
    {
        return $this->hasMany(Segment::class, 'id', 'speedrun_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function verifier()
    {
        return $this->belongsTo(User::class, 'confirmed_by', 'id');
    }
}
