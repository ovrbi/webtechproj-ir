<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Speedrun;
use App\Models\Place;
use App\Models\Item;
use App\Models\Boss;

class Segment extends Model
{
    use HasFactory;
    protected $fillable = ['order','starttime','endtime','itemtime','damagetaken','boss_starttime','boss_endtime','boss_damagetaken'];

    public function speedrun()
    {
        return $this->belongsTo(Speedrun::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item', 'name');
    }
    public function boss()
    {
        return $this->belongsTo(Boss::class, 'boss', 'name');
    }
    public function place()
    {
        return $this->belongsTo(Place::class, 'place', 'name');
    }
}
