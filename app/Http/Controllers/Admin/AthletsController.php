<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlets;
use Illuminate\Http\Request;

class AthletsController extends Controller
{
    public function index()
    {
        $athlets = Athlets::paginate(12);

        return view('admin.sportivi.index', ['athlets' => $athlets]);
    }
    public function create()
    {
        return view('admin.sportivi.create');
    }
    public function edit(string $id)
    {
        $athlet = Athlets::findOrFail($id);
        return view('admin.sportivi.edit', compact('athlet'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'athlet_fullName'  => 'required|string',
            'athlet_birthdate' => 'required|string'
        ], [
            'athlet_fullName'  => 'Adauga numele sportivului',
            'athlet_birthdate' => 'Adauga data nasterii sportivului'
        ]);

        $athlets = Athlets::all();
        if(!$athlets->where('fullName',$request['athlet_fullName'])->where('age',$request['athlet_birthdate'])->isNotEmpty()){
            $newAthlets = Athlets::where('id',$id)->firstOrFail();
            $newAthlets->fullName = $request['athlet_fullName'];
            $newAthlets->age = $request['athlet_birthdate'];
            // $newAthlets->updateOrFail(['fullName' => $request['athlet_fullName'], 'age' => $request['athlet_birthdate']]);
            $newAthlets->updateOrFail();
        }else{
            return redirect()->back()->with('error', 'Sportivul '.$request['athlet_fullName'].' cu anul nasterii: '.$request['athlet_birthdate'].' a fost deja adaugat');
        }
        return redirect()->back()->with('success', 'Datele au fost actualizate cu succes');

    }

    public function destroy(Request $request, string $id){
        $athlet = Athlets::where('id',$id)->firstOrFail();
        if($athlet){
            $athlet->deleteOrFail();
                return redirect()->back()->with('success', 'Datele au fost actualizate cu succes');
        }
        return redirect()->back()->with('error','Ceva nu a functionat');
    }

    public function store(Request $request)
    {
        $athlets = Athlets::all();
        $request->validate([
            'inputs.*.athlet_fullName'  => 'required|string',
            'inputs.*.athlet_birthdate' => 'required|string'
        ], [
            'inputs.*.athlet_fullName'  => 'Adauga numele sportivului',
            'inputs.*.athlet_birthdate' => 'Adauga data nasterii sportivului'
        ]);


        foreach ($request->inputs as $key => $value) {
            if(!$athlets->where('fullName',$value['athlet_fullName'])->where('age',$value['athlet_birthdate'])->isNotEmpty()){
                $newAthlets = new Athlets();
                $newAthlets->fullName = $value['athlet_fullName'];
                $newAthlets->age = $value['athlet_birthdate'];
                $newAthlets->saveOrFail();
            }else{
                return redirect()->back()->with('error', 'Sportivul '.$value['athlet_fullName'].' cu anul nasterii: '.$value['athlet_birthdate'].' a fost deja adaugat');
            }
        }
        return redirect()->back()->with('success', 'Datele au fost salvate cu succes');



    }

}
