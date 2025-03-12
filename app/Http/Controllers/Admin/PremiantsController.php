<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlets;
use App\Models\Premiants;
use App\Models\Competitions;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PremiantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $athlets = Premiants::paginate(12);

        return view('admin.atleti.index',['athlets'=>$athlets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $year = Carbon::now()->year; //anul curent
        $competitions = Competitions::whereYear('date',$year)->get();//Competitiile anului curent
        $athlets = Athlets::all();

        return view('admin.atleti.create',['competitions' => $competitions,'athlets'=>$athlets]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'inputs.*.id_athlet' => 'required|integer',
            'inputs.*.weight' => 'required|integer',
            'inputs.*.place' => 'required|integer',
            'inputs.*.id_competition' => 'required|integer'
        ],[
            'inputs.*.id_athlet' => 'Numele este obligatoriu',
            'inputs.*.weight' => 'Categoria este obligatoriu',
            'inputs.*.place' => 'Locul ocupat este obligatoriu',
            'inputs.*.id_competition' => 'Numele competitiei este obligatoriu'
        ]);


        foreach($request->inputs as $key => $value){
            // dd($value);
            Premiants::create($value);
        }
        return redirect()->back()->with('success','The athletes are succesfuly saved');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $premiant = Premiants::findOrFail($id);
        $competitions = Competitions::whereYear('date',Carbon::now()->year)->get();
        $athlets = Athlets::all();
        return view('admin.atleti.edit',['premiant' => $premiant,'competitions'=>$competitions,'athlets' => $athlets]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($request);
        $request->validate([
            'athlet_name' => 'required|string',
            'athlet_age' => 'required|integer',
            'athlet_weight' => 'required|integer',
            'athlet_place' => 'required|integer',
            'athlet_competition' => 'required|string'
        ],
        [
            'athlet_name' => 'Numele sportivului este obligatoriu',
            'athlet_age' => 'Virsta Este obligatorie',
            'athlet_weight' => 'Greuatatea este obligatorie',
            'athlet_place' => 'Locul ocupat este obligatoriu',
            'athlet_competition' => 'Competitia este obligatorie']
    );

    $data_from_request        = $request->all();
    $data_from_db             = Premiants::findOrFail($id);
    $athlet_name_from_request = strtolower(preg_replace('/\s/u','',$data_from_request['athlet_name']));
    $athlet_name_from_db      = strtolower(preg_replace('/\s/u','',$data_from_db['fullName']));
    $existAthlete             = Premiants::where('fullName',$data_from_request['athlet_name'])->where('age',$data_from_request['athlet_age'])->exists();

    // dd($athlet_name_from_request,  $athlet_name_from_db);

    if($athlet_name_from_request !== $athlet_name_from_db ){
        if($existAthlete){
            return redirect()->back()->with('error','Acest sportiv este deja adaugat');
        }
    }else{

    }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
