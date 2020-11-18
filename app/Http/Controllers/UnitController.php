<?php

namespace App\Http\Controllers;

use App\Post;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units=Unit::paginate(env('PAGINATION_COUNT'));
        return view('admin.units.units',['units'=>$units,'showLinks'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (! $this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if (!$this->unitCodeExists($unitCode)){
            return redirect()->back();
        }
       $unit=new Unit();
       $unit->unit_name=$request->input('unit_name');
       $unit->unit_code=$request->input('unit_code');
       $unit->save();

        $request->session()->flash('status','unit was created');
       return redirect()->route('units.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (!$this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if (!$this->unitCodeExists($unitCode)){
            return redirect()->back();
        }

        $unit=Unit::find($id);
        $unit->unit_name=$request->input('unit_name');
        $unit->unit_code=$request->input('unit_code');
        $unit->save();
        $request->session()->flash('status','Unit'.$unit->unit_name.'has been added');
        return redirect()->route('units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request , $id)
    {
        $unit=Unit::destroy($id);
       session()->flash('status','unit was deleted');
        return redirect()->route('units.index');

    }
    /**
     * Store a newly created resource in storage.
     *@param  string  $unitName
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function unitNameExists(string $unitName)
    {
        $unit = Unit::where(
            'unit_name', '=', $unitName
        )->first();
        if (!is_null($unit)) {
            session()->flash('status', 'Unit Name(' . $unitName . ') already exists');

            return false;

        }
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *@param  string  $unitCode
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function unitCodeExists(string $unitCode)
    {
        $unit = Unit::where(
            'unit_code', '=', $unitCode
        )->first();
        if (!is_null($unit)) {
            session()->flash('status', 'Unit Name(' . $unitCode . ') already exists');
            return false;
        }
        return true;
    }
public function search( Request $request){
    $searchTerm=$request->input('unit_search');
    $units=Unit::where(
        'unit_name' , 'LIKE','%'.$searchTerm.'%'
    )->orwhere(
        'unit_code','LIKE','%'.$searchTerm.'%'
    )->get();
    if(count($units)>0){
        return view('admin.units.units')->with([
            'units'=>$units,
            'showLinks'=>false,
        ]);
    }
    Session()->flash('status','Nothing Found!!!');
    return redirect()->route('units.index');
    }
}
