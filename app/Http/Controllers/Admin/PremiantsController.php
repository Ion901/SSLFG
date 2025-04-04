<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\PremiantsFilter;
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
    public function index(Request $request)
    {

        $data = $request->validate([
            'fullName' => 'nullable|string|max:255',
            'age' => 'nullable|int|exists:athlets,age',
            'competition' => 'nullable|string',
            'weight' => 'nullable|int',
            'place' => 'nullable|int',
        ]);

        $filter = app()->make(PremiantsFilter::class, ['queryParams' => array_filter($data)]);


        $athletes = Premiants::with('athlet')->filter($filter)->paginate(12)->through(function($athlet){
            return [
            'id'=> $athlet->id,
            'fullName' => $athlet->fullName(),
            'age' => $athlet->age(),
            'weight' => $athlet->weight,
            'place' => $athlet->place,
            'competitionName' => $athlet->competitionName()
            ];
        });


        return view('admin.atleti.index',['athletes'=>$athletes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $year         = Carbon::now()->year; //anul curent
        $competitions = Competitions::whereYear('date',$year)->get();//Competitiile anului curent
        $athlets      = Athlets::all();

        return view('admin.atleti.create',['competitions' => $competitions,'athlets'=>$athlets]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'inputs.*.id_athlet'      => 'required|integer',
            'inputs.*.weight'         => 'required|integer',
            'inputs.*.place'          => 'required|integer',
            'inputs.*.id_competition' => 'required|integer'
        ],[
            'inputs.*.id_athlet'      => 'Numele este obligatoriu',
            'inputs.*.weight'         => 'Categoria este obligatoriu',
            'inputs.*.place'          => 'Locul ocupat este obligatoriu',
            'inputs.*.id_competition' => 'Numele competitiei este obligatoriu'
        ]);


        foreach($request->inputs as $key => $value){
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
        $premiant = Premiants::findOrFail($id);
        $updates = [];
        $request->validate([
            'athlet_id_fetched'  => 'required|integer',
            'athlet_weight'      => 'required|integer',
            'athlet_place'       => 'required|integer',
            'athlet_competition' => 'required|string'
        ],
        [
            'athlet_id_fetched'  => 'Numele sportivului este obligatoriu',
            'athlet_weight'      => 'Greuatatea este obligatorie',
            'athlet_place'       => 'Locul ocupat este obligatoriu',
            'athlet_competition' => 'Competitia este obligatorie']
    );

        $idCompetition              = Competitions::where('name',$request->athlet_competition)->value('id');
        $isSameWeight               = $premiant->weight == $request->athlet_weight;
        $isSameAthlete              = $premiant->id_athlet == $request->athlet_id_fetched;
        $athleteExistsInCompetition = Premiants::where('id_athlet', $request->athlet_id_fetched)
                                                ->where('id_competition', $idCompetition)
                                                ->exists();

        if($request->athlet_place && $premiant->place != $request->athlet_place){
            $updates['place'] = (int)$request->athlet_place;
        }

        if($request->athlet_competition && $premiant->id_competition != $idCompetition){
            $updates['id_competition'] = $idCompetition;
        }

        if (!$athleteExistsInCompetition) {
            if ($isSameWeight) { //Schimbam sportivul dar greutatea nu
                $updates['id_athlet'] = (int) $request->athlet_id_fetched;
            } else { //Schimbam sportivul si schimbam si greutatea
                $updates['id_athlet'] = (int)$request->athlet_id_fetched;
                $updates['weight'] = (int) $request->athlet_weight;
            }
        } else {
            if ($isSameAthlete && !$isSameWeight) { //Nu schimbam sportivul, schimbam greutatea
                $updates['weight'] = (int) $request->athlet_weight;
            }
        }


        if(!empty($updates)){
            $premiant->update($updates);
            return redirect()->back()->with('success','Actualizat cu succes');
        }else{
            return redirect()->back()->with('error','Nu este nici o modificare');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $premiant = Premiants::findOrFail($id);
        $premiant->delete();

        return redirect()->route('premiants')->with('success','Premiantul a fost șters cu succes');

    }
}
