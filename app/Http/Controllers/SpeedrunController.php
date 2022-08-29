<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speedrun;
use App\Models\Segment; 
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class SpeedrunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        

        return Inertia::render('Dashboard');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $speedruns = DB::table('users')
        ->where('users.id', $user->id)
        ->join('speedruns', 'users.id', '=', 'speedruns.user_id')
        ->select('speedruns.*', 'users.name')
        ->get();
        return Inertia::render('Dashboard', ['speedruns' => $speedruns]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        /*
        $country = Country::findOrFail($id);
        return view('city_new', compact('country'));
        */
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
        $segments = Segment::where('speedrun_id', '=', $id)->get();
        $speedrun = Speedrun::where('id', '=', $id)->get();
        return Inertia::render('Speedrun/Speedrun', [
            'speedrun' => $speedrun,
            'segments' => $segments,
            'authu' => auth()->user(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$city = City::findOrFail($id);
        //return view('city_update', compact('id','city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*
        $validated = $request->validate([
            'city_name' => 'required|max:32'
        ]);
        $city = City::findOrFail($request->$id);
        $city->city_name = $request->city_name;
        $city->save();
        return redirect('city/country/' . $city->country_id);
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*
        $country_id = City::findOrFail($id)->country_id;
        City::findOrFail($id)->delete();
        return redirect('city/country/' . $country_id);
        */
    }
}
