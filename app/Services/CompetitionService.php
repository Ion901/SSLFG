<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Competitions;
use App\Models\Category;
use Exception;

class CompetitionService
{

    private function checkDuplicates(?Competitions $competition, Request $request): array
    {

        $excludeId = optional($competition)->id;

        $existingCompetition = Competitions::where('name', $request->competition_name)
            ->where('id', '!=', $excludeId) // Prevents errors if $competition is null
            ->whereDate('date', $request->competition_date)
            ->exists(); // Directly check if such a competition exists

        $existingCompetitionLocation = Competitions::where('location', $request->competition_location)
            ->where('id', '!=', $excludeId) // Prevents errors if $competition is null
            ->whereDate('date', $request->competition_date)
            ->exists(); // Directly check if such a competition location exists

        $existingCompetitionDate = Competitions::whereDate('date', $request->competition_date)
            ->where('id', '!=', $excludeId) // Prevents errors if $competition is null
            ->where('name', $request->competition_name)
            ->exists(); // Directly check if such a competition date exists


        return [
            'existingCompetition' => $existingCompetition,
            'existingCompetitionDate' => $existingCompetitionDate,
            'existingCompetitionLocation' => $existingCompetitionLocation
        ];
    }


    public function updateExistingCompetition(
        Request $request,
        ?Competitions $competition
    ): array {

        if (!$request->filled('competition_name')) {
            return [];
        }

        $duplicates = $this->checkDuplicates($competition, $request);

        $nameChanged     = $competition->name !== $request->competition_name;
        $locationChanged = $competition->location !== $request->competition_location;
        $dateChanged     = date('Y-m-d', strtotime($competition->date)) !== $request->competition_date;

        // Update competition details only if needed
        // cand competitia/data/locatia este selectata din baza de date, dar poate este modificata
        // actualizez intreg randul din tabel competition cand este schimbat ceva, actualizez doar id_competition din posts daca este doar ales din optiuni fara modificarile userului
        if (
            ($nameChanged     && !$duplicates['existingCompetition']) ||
            ($locationChanged && !$duplicates['existingCompetitionLocation']) ||
            ($dateChanged     && !$duplicates['existingCompetitionDate'])
        ) {

            $competition->update([
                'name' => $request->competition_name,
                'location' => $request->competition_location,
                'date' => $request->competition_date
            ]);

            return ['succes' => "Succesfully updated"];
        } elseif ($request->id_competition_fetched) {
            return ['id_competition' => (int) $request->id_competition_fetched];
        }
        return [];
    }


    public function attachCompetitionToPost(Request $request, Competitions $competition)
    {

        if (!$request->filled('competition_name')) {
            return [];
        }

        $duplicates = $this->checkDuplicates($competition, $request);

        $nameChanged     = $competition->name !== $request->competition_name;
        $locationChanged = $competition->location !== $request->competition_location;
        $dateChanged     = date('Y-m-d', strtotime($competition->date)) !== $request->competition_date;

        // Update competition details only if needed
        // cand competitia/data/locatia este selectata din baza de date, dar poate este modificata
        // actualizez intreg randul din tabel competition cand este schimbat ceva, actualizez doar id_competition din posts daca este doar ales din optiuni fara modificarile userului
        if (
            ($nameChanged     && !$duplicates['existingCompetition']) ||
            ($locationChanged && !$duplicates['existingCompetitionLocation']) ||
            ($dateChanged     && !$duplicates['existingCompetitionDate'])
        ) {

            $competition->update([
                'name' => $request->competition_name,
                'location' => $request->competition_location,
                'date' => $request->competition_date
            ]);
            return ['succes' => "Succesfully updated"];

        } elseif ($request->id_competition_fetched) {
            return [
                'id_competition' => (int) $request->id_competition_fetched,
                'id_category' => Category::where('type', $request->category)->value('id')
            ];
        }
        return [];
    }

    public function dettachCompetitionToPost(Request $request)
    {
        return [
            'id_category' => Category::where('type',$request->category)->value('id'),
            'id_competition' => null
        ];
    }
}
