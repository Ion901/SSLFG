<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlets;
use App\Models\Competitions;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AthletsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $athlets = Athlets::paginate(10);

        return view('admin.atleti.index',['athlets'=>$athlets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $year = Carbon::now()->year; //anul curent
        $competitions = Competitions::whereYear('date',$year)->get();//Competitiile anului curent

        return view('admin.atleti.create',['competitions' => $competitions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'inputs.*.fullName' => 'required|string',
            'inputs.*.age' => 'required|integer',
            'inputs.*.weight' => 'required|integer',
            'inputs.*.place' => 'required|integer',
            'inputs.*.id_competition' => 'required|integer'
        ],[
            'inputs.*.fullName' => 'Numele este obligatoriu',
            'inputs.*.age' => 'Virsta este obligatoriu',
            'inputs.*.weight' => 'Categoria este obligatoriu',
            'inputs.*.place' => 'Locul ocupat este obligatoriu',
            'inputs.*.id_competition' => 'Numele competitiei este obligatoriu'
        ]);


        foreach($request->inputs as $key => $value){
            // dd($value);
            Athlets::create($value);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
