<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Premiants;
use App\Models\Category;
use App\Models\Competitions;
use App\Models\PostImages;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Filters\PostFilter;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'post_title' => 'nullable|string|max:255',
            'category' => 'nullable|int|exists:category,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:date_from',
        ]);

        $filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);
        $posts = Posts::with('category')->filter($filter)->paginate(10);
        $category = Category::all();
        return view('admin.posts.index', ['posts' => $posts, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryes = Category::all();
        return view('admin.posts.create', compact('categoryes'));
    }

    private function uploadImages($images, $postId, $competitionId = null)
    {
        // dd($competitionId);
        foreach ($images as $image) {
            $photo = new PostImages();
            $extension = $image->getClientOriginalExtension();
            $photoName = uniqid() . time() . '.' . $extension;
            $target_dir = public_path('/storage/images/post/');
            $image->move($target_dir, $photoName);

            $photo->image_path = '/storage/images/post/' . $photoName;
            $photo->id_post = $postId;
            $photo->id_competition = $competitionId;
            $photo->saveOrFail();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'category' => 'required|string',
            'photo.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string',
            'title' => 'required|string'
        ];

        if ($request->has('category') && $request->category == 'SPORT') {
            $rules = array_merge($rules, [
                'competition_name' => 'required|string',
                'competition_location' => 'required|string',
                'competition_date' => 'required|date'
            ]);
        }
        $request->validate($rules);

        $input = $request->all();

        $post = new Posts();
        $competition = new Competitions();

        // Daca categoria este sport se adauga detalii despre competitii
        if ($input['category'] === "SPORT") {
            // Adaug datele despre competitie
            $competition->name = $input['competition_name'];
            $competition->location = $input['competition_location'];
            $competition->date = $input['competition_date'];
            $competition->saveOrFail();

            //Adaug datele despre postare cu id-ul competitiei
            $post->post_title = strtoupper($input['title']);
            $post->post_content = $input['content'];
            $post->post_date = date('Y-m-d H:m:s');
            $post->id_category = Category::where('type', $input['category'])->value('id');
            $post->id_competition = $competition->orderBy('id', 'desc')->first('id')?->id;
            $post->post_slug = Str::slug($input['title']);

            $post->saveOrFail();

            if ($request->hasFile('photo')) {
                $lastPostId = $post->id;
                $lastCompetitionId = $competition->id;
                $this->uploadImages($input['photo'], $lastPostId, $lastCompetitionId ?? null);
            }

            return redirect(route('posts'))->with('message', "The post has been succesfully created");
        } else {
            $post->post_title = $input['title'];
            $post->post_content = $input['content'];
            $post->post_date = date('Y-m-d H:m:s');
            $post->id_category = Category::where('type', $input['category'])->value('id');
            $post->id_competition = null;
            $post->post_slug = Str::slug($input['title']);

            $post->saveOrFail();

            if ($request->hasFile('photo')) {
                $lastPostId = $post->id;
                $lastCompetitionId = $competition->id;
                $this->uploadImages($input['photo'], $lastPostId, $lastCompetitionId ?? null);
            }
            return redirect(route('posts'))->with('message', "The post has been succesfully created");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $post)
    {
        $post->images = $post->image->pluck('image_path');

        if ($post->id_category === 1) {
            $post->athlets =  $post->competition->athlet;
        };

        return view('admin.posts.view', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posts $post)
    {
        $post->images = $post->image;
        $post->categoryType = $post->category->type;

        if ($post->id_category === 1) {
            $post->competitionDetails = $post->competition()->first();
        };
        // dd($post->images);

        $categoryes = Category::all();
        $competitions = Competitions::distinct()->get();

        return view('admin.posts.edit', ['post' => $post, 'categoryes' => $categoryes, 'competitions' => $competitions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $post)
    {

        $updates = [];
        $rules = [
            'category' => 'string',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'string',
            'title' => 'string'
        ];

        if ($request->has('category') && $request->category == 'SPORT') {
            $rules = array_merge($rules, [
                'competition_name' => 'string',
                'competition_location' => 'string',
                'competition_date' => 'date'
            ]);
        }

        $request->validate($rules);

        $competition = $post->competition;

        if (request('title')) {

            if (
                strtolower($post->post_title) != strtolower($request->title) && //titlu este schimbat
                Posts::where('post_title', $request->title)->where('id', '!=', $post->id)->exists()
            ) { //titlu este acelasi cu alt titlu din tabel){
                return redirect()->back()->with('error', 'This title already exists.');
            } else if ($post->post_title !== $request->title) {
                $updates['post_title'] = $request->title;
                $updates['post_slug'] = Str::slug($request->title);
            }
        }

        if (request('content')) {
            if (
                strtolower($post->post_content) != strtolower($request->content) && //contentul este schimbat
                Posts::where('post_content', $request->content)->where('id', '!=', $post->id)->exists()
            ) { //contentul este acelasi cu alt content din tabel){
                return redirect()->back()->with('error', 'This post content already exists.');
            } elseif ($post->post_content !== $request->content) {
                $updates['post_content'] = $request->content;
            }
        }

        if (request('category') && $request->category === 'SPORT' && !is_null($post->id_competition)) { //este aleasa categoria, este Sport si este o postare sportive initial

            if ($request->filled('competition_name')) {

                $existingCompetition = Competitions::where('name', $request->competition_name)
                    ->where('id', '!=', optional($competition)->id) // Prevents errors if $competition is null
                    ->whereDate('date', $request->competition_date)
                    ->exists(); // Directly check if such a competition exists

                $existingCompetitionLocation = Competitions::where('location', $request->competition_location)
                    ->where('id', '!=', optional($competition)->id) // Prevents errors if $competition is null
                    ->whereDate('date', $request->competition_date)
                    ->exists(); // Directly check if such a competition location exists

                $existingCompetitionDate = Competitions::whereDate('date', $request->competition_date)
                    ->where('id', '!=', optional($competition)->id) // Prevents errors if $competition is null
                    ->where('name', $request->competition_name)
                    ->exists(); // Directly check if such a competition date exists

                // Update competition details only if needed
                // cand competitia/data/locatia este selectata din baza de date, dar poate este modificata
                // actualizez intreg randul din tabel competition cand este schimbat ceva, actualizez doar id_competition din posts daca este doar ales din optiuni fara modificarile userului
                if (($competition->name !== $request->competition_name && !$existingCompetition) ||
                    ($competition->location !== $request->competition_location && !$existingCompetitionLocation) ||
                    (date('Y-m-d', strtotime($competition->date)) !== $request->competition_date && !$existingCompetitionDate)
                ) {

                    $competition->update([
                        'name' => $request->competition_name,
                        'location' => $request->competition_location,
                        'date' => $request->competition_date
                    ]);

                    if (empty($updates)) {
                        return redirect()->back()->with('success', 'Succesfully updated');
                    }
                } elseif($request->id_competition_fetched) {
                    $updates['id_competition'] = (int) $request->id_competition_fetched;
                }
            }
        } else if (request('category') && $request->category === 'SPORT' && is_null($post->id_competition)) { //case cand schimbam categoria din non-Sport in Sport si facem modificari
            if ($request->filled('competition_name')) {
                $competition = Competitions::where('id', $request->id_competition_fetched)->firstOrFail(); // Get the related competition

                $existingCompetition = Competitions::where('name', $request->competition_name)
                    ->where('id', '!=', optional($competition)->id) // Prevents errors if $competition is null
                    ->where('date', $request->competition_date)
                    ->exists(); // Directly check if such a competition exists

                $existingCompetitionLocation = Competitions::where('location', $request->competition_location)
                    ->where('id', '!=', optional($competition)->id) // Prevents errors if $competition is null
                    ->where('date', $request->competition_date)
                    ->exists(); // Directly check if such a competition location exists

                $existingCompetitionDate = Competitions::where('date', $request->competition_date)
                    ->where('id', '!=', optional($competition)->id) // Prevents errors if $competition is null
                    ->where('name', $request->competition_name)
                    ->exists(); // Directly check if such a competition date exists
                // Ensure $competition is not null before accessing its properties

                if (($competition->name !== $request->competition_name && !$existingCompetition) ||
                    ($competition->location !== $request->competition_location && !$existingCompetitionLocation) ||
                    (date('Y-m-d', strtotime($competition->date)) !== $request->competition_date && !$existingCompetitionDate)
                ) {

                    $competition->update([
                        'name' => $request->competition_name,
                        'location' => $request->competition_location,
                        'date' => $request->competition_date
                    ]);

                    if (empty($updates)) {
                        return redirect()->back()->with('success', 'Succesfully updated');
                    }
                } else {
                    $updates['id_competition'] = (int) $request->id_competition_fetched;
                    $updates['id_category'] = Category::where('type', $request->category)->value('id');
                }
            }
        } else if (request('category') && $request->category !== 'SPORT') { //categorie nu este SPORT
            $updates['id_category'] = Category::where('type', $request->category)->value('id');
            $updates['id_competition'] = null;
        }

        $hasUpdates = !empty($updates);
        $hasImages = $request->hasFile('photo');

        //daca in postare avem imagini, actualizam si id_competition din tabelul[post_images]
        if($post->image){
            $post->image->each(function ($image) use ($updates) {
                $image->update([
                    'id_competition' => $updates['id_competition']
                ]);
            });
        };

        // If only updates exist, update the post
        if ($hasUpdates && !$hasImages) {
            $post->update($updates);
            return redirect()->back()->with('success', 'Updated successfully');
        }
        // If images exist, process them
        if ($hasImages) {

            $lastPostId = $post->id;
            $lastCompetitionId = $request->id_competition_fetched ?? $post->competition->id ?? null;
            dd($lastCompetitionId);
            $this->uploadImages($request->file('photo'), $lastPostId, $lastCompetitionId);

            // If updates also exist, update the post
            if ($hasUpdates) {
                $post->update($updates);
                return redirect()->back()->with('success', 'The images and the record details were updated');
            }

            return redirect()->back()->with('success','The image was added succesfully');
        }


        if ($request->hasFile('images')) { //pentru a actualiza pozele prezente la moment
            $oldPhotoStoragePath = public_path($post->image()->where('id', $request->imageId)->pluck('image_path')?->first());
            $oldImage = PostImages::find($request->imageId);

            if ($oldImage && File::exists($oldPhotoStoragePath)) {
                File::delete($oldPhotoStoragePath);
            }
            $extension = $request->images->getClientOriginalExtension();
            $photoName = uniqid() . time() . '.' . $extension;
            $target_dir = public_path('/storage/images/post/');
            $request->images->move($target_dir, $photoName);

            $oldImage?->update(['image_path' => '/storage/images/post/' . $photoName]);

            return redirect()->back()->with('success', 'The image was succesfully updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $post, Request $request)
    {
        $postImage = $request->imageId;
        if ($post && !$postImage) {
            $post->delete();

            return redirect()->back()->with('success', 'The post was succesfully deleted');
        } else {
            $image = $post->image()->where('id', $postImage)->firstOrFail();

            if (File::exists(public_path($image->image_path))) {
                File::delete(public_path($image->image_path));
                if ($image->exists()) {
                    $image->delete();
                }
                return redirect()->back()->with('success', 'The image was succesfully deleted');
            } else {
                return redirect()->back()->with('error', 'Something is wrong');
            }
        }
    }
}
