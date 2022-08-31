<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speedrun;
use App\Models\Segment; 
use App\Models\User; 
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class SpeedrunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        if ($id == null || !User::where('id','=',$id)->exists())
        {
            $speedruns = DB::table('users')
            ->join('speedruns', 'users.id', '=', 'speedruns.user_id')
            ->select('speedruns.*', 'users.name', 'users.id as userid')
            ->orderBy('speedruns.timetotal', 'ASC')
            ->take(100)
            ->get();
            return Inertia::render('Speedrun/Home', ['speedruns' => $speedruns]);
        }
        else
        {
            $speedruns = DB::table('users')
            ->where('users.id', $id)
            ->join('speedruns', 'users.id', '=', 'speedruns.user_id')
            ->select('speedruns.*', 'users.name', 'users.id as userid')
            ->get();
            return Inertia::render('Speedrun/Home', ['speedruns' => $speedruns]);
        }
    }

    public function dashboard()
    {
        $user = auth()->user();
        $speedruns = DB::table('users')
        ->where('users.id', $user->id)
        ->join('speedruns', 'users.id', '=', 'speedruns.user_id')
        ->select('speedruns.*', 'users.name', 'users.id as userid')
        ->get();
        return Inertia::render('Dashboard', ['speedruns' => $speedruns]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_name' => 'required|max:32'
        ]);

        $city = new City();
        $city->city_name = $request->city_name;
        $city->country_id = $request->country_id;
        $city->save();
        return redirect('city/country/' . $city->country_id);
    }*/

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Speedrun::where('id','=',$id)->exists()) return abort(404);
        $segments = Segment::where('speedrun_id', '=', $id)
        ->leftjoin('items', 'items.id', '=', 'segments.item')
        ->join('places', 'places.id', '=', 'segments.place')
        ->join('bosses', 'bosses.id', '=', 'segments.boss')
        ->select('segments.*','items.name as itemname', 'places.name as placename', 'bosses.name as bossname')
        ->orderBy('segments.order', 'ASC')->get();
        $speedrun = Speedrun::where('speedruns.id', '=', $id)
        ->join('users', 'users.id', '=', 'speedruns.user_id')
        ->leftjoin('users as mods', 'mods.id', '=', 'speedruns.confirmed_by')
        ->join('segments', 'segments.speedrun_id','=','speedruns.id')
        ->join('items', 'items.id', '=', 'segments.item')
        ->groupby('speedruns.id','users.name', 'mods.name')
        ->select('speedruns.*','users.name as uname','mods.name as confirmed',DB::raw('sum(items.strength) as strength,sum(items.speed) as speed,sum(items.endurance) as endurance'))
        ->first();
        return Inertia::render('Speedrun/Speedrun', [
            'speedrun' => $speedrun,
            'segments' => $segments,
        ]);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'video' => ['nullable','url','max:100'],
            'id' => ['required','integer'],
        ]);
        $speedrun = Speedrun::findOrFail($request->id);
        if ($speedrun->user->id != auth()->user()->id || $speedrun->confirmed_by!=null)
        throw ValidationException::withMessages(['Id' => 'Access denied!']);
        $speedrun->video = $request->video;
        $speedrun->save();
        throw ValidationException::withMessages(['Success' => 'Video updated!']);
        return redirect('speedruns/' . $speedrun->id);
        //*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //*
        if(Speedrun::findOrFail($id)->user->id!=auth()->user()->id&&auth()->user()->type==0)
        {
            throw ValidationException::withMessages(['Id' => 'Access denied!']);
        }
        Speedrun::findOrFail($id)->delete();
        Segment::where('speedrun_id', '=', $id)->delete();
        return redirect('/');
        //*/
    }

    public function confirm($id)
    {
        $speedrun = Speedrun::findOrFail($id);
        if(auth()->user()->type==0 ||auth()->user()->id==$speedrun->user_id) throw ValidationException::withMessages(['Id' => 'Access denied!']);
        if($speedrun->confirmed_by!=null||$speedrun->video==null) throw ValidationException::withMessages(['Speedrun' => 'Unconfirmable speedrun!']);

        $speedrun->confirmed_by = auth()->user()->id;
        $speedrun->save();
        return redirect('speedruns/' . $speedrun->id);
    }
}
