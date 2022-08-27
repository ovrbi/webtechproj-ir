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
        return $this->belongsTo(Speedrun::class, 'speedrun_id', 'id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item', 'id');
    }
    public function boss()
    {
        return $this->belongsTo(Boss::class, 'boss', 'id');
    }
    public function place()
    {
        return $this->belongsTo(Place::class, 'place', 'id');
    }
}
