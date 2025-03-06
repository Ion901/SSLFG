<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Competitions;
use Illuminate\Http\Request;

class CompetitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competitions = Competitions::paginate(10);
        return view('admin.competitions.index', ['competitions' => $competitions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.competitions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'competition_name' => 'required|string',
            'competition_location' => 'required|string',
            'competition_date' => 'required|date'
        ]);
        $input = $request->all();

        $competition = new Competitions();
        // dd(Competitions::where('name',$input['competition_name'])->whereDate('date',$input['competition_date'])->exists());
        if (Competitions::where('name', $input['competition_name'])->whereDate('date', $input['competition_date'])->exists()) {
            return redirect()->back()->with('error', 'This competition on this date already exists! Change the title or the date');
        }
        $competition->name = $input['competition_name'];
        $competition->location = $input['competition_location'];
        $competition->date = $input['competition_date'];
        $competition->saveOrFail();

        return redirect()->back()->with('success','The competition was succesfully saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $competition = Competitions::where('id', $id)->firstOrFail();

        return view('admin.competitions.edit', ['competition' => $competition]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'competition_name' => 'required|string',
            'competition_location' => 'required|string',
            'competition_date' => 'required|date'
        ]);

        $competition = Competitions::where('id', $id)->firstOrFail();
        if ($request->filled('competition_name')) {

            // Ensure $competition is not null before accessing its properties
            if ($competition && strtolower($competition->name) !== strtolower($request->competition_name)) {
                $existingCompetition = Competitions::where('name', $request->competition_name)
                    ->where('id', '!=', optional($competition)->id) // Prevents errors if $competition is null
                    ->where('date', $request->competition_date)
                    ->exists(); // Directly check if such a competition exists

                if ($existingCompetition) {
                    return redirect()->back()->with('error', 'A competition with the same name and date already exists!');
                }
            }

            // Update competition details only if needed
            if (
                $competition->name !== $request->competition_name ||
                $competition->location !== $request->competition_location ||
                date('Y-m-d', strtotime($competition->date)) !== $request->competition_date
            ) {

                $competition->update([
                    'name' => $request->competition_name,
                    'location' => $request->competition_location,
                    'date' => $request->competition_date
                ]);

                return redirect()->back()->with('success', 'Succesfully updated');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $competition = Competitions::findOrFail($id);
        $competition->delete();

        return redirect()->route('competitions')->with('success','The competition was succesfully deleted');
    }
}
