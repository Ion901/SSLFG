<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DuplicateEntriesException;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Category;
use App\Models\Competitions;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Filters\PostFilter;
use App\Http\Requests\UpdatePostRequest;
use App\Services\PostService;
use App\Services\CompetitionService;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImageService $imageService)
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

        $validated = $request->validate($rules);
        $competition = null;

        // Daca categoria este sport se adauga detalii despre competitii
        if ($validated['category'] === "SPORT") {
            // Adaug datele despre competitie
            $competition = Competitions::create([
                'name' => $validated['competition_name'],
                'location' => $validated['competition_location'],
                'date' => $validated['competition_date']
            ]);
        }

        //Adaug datele despre postare cu id-ul competitiei
        $post = new Posts();
        $post->post_title = strtoupper($validated['title']);
        $post->post_content = $validated['content'];
        $post->post_date = date('Y-m-d H:m:s');
        $post->id_category = Category::where('type', $validated['category'])->value('id');
        $post->id_competition = $competition?->id;
        $post->post_slug = Str::slug($validated['title']);

        $post->saveOrFail();

        if ($request->hasFile('photo')) {
            $imageService->uploadImages(
                $validated['photo'],
                $post,
                $competition?->id
            );
        }
        return redirect(route('posts'))->with('message', "The post has been succesfully created");
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
        $post->load(['category', 'image']);
        //lazy eager loading

        if ($post->category->id === 1) {
            $post->competitionDetails = $post->competition()->first();
        };
        // dd($post->image);

        $categoryes = Category::all();
        $competitions = Competitions::distinct()->get();

        return view('admin.posts.edit', ['post' => $post, 'categoryes' => $categoryes, 'competitions' => $competitions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdatePostRequest $request,
        Posts $post,
        PostService $postService,
        CompetitionService $competitionService,
        ImageService $imageService
    ) {

        $updates = [];

        $competition = $post->competition;

        try {
            $updates += $postService->prepareTitleUpdate($post, $request->title);
            $updates += $postService->prepareContentUpdate($post, $request->content);
        } catch (DuplicateEntriesException $error) {
            return redirect()->back()->with('error', $error->getMessage());
        }

        $isAlreadySport      = $request->category === "SPORT" && !is_null($post->id_competition); // 👈 era deja sport
        $isChangingToSport   = $request->category === "SPORT" && is_null($post->id_competition);  // 👈 devine sport
        $isChangingFromSport = $request->category !== "SPORT";

        if ($isAlreadySport) {
            $updates += $competitionService->updateExistingCompetition($request, $competition);
        } elseif ($isChangingToSport) {
            try {
                $competition = Competitions::findOrFail($request->id_competition_fetched);
                $updates += $competitionService->attachCompetitionToPost($request, $competition);
            } catch (ModelNotFoundException $e) {
                return redirect()->back()->with('error', 'Competition not found.');
            }
        } elseif ($isChangingFromSport) {
            $updates += $competitionService->dettachCompetitionToPost($request->category);
        }

        //daca in postare avem imagini, actualizam si id_competition din tabelul[post_images]
        if ($post->image && array_key_exists('id_competition', $updates)) {
            $imageService->syncCompetitionOnImages($post, $updates['id_competition']);
        };


        $hasUpdates = !empty($updates);
        $hasImages = $request->hasFile('photo');


        // If only updates exist, update the post
        if (!$hasUpdates && !$hasImages) {
            return back()->with('error', 'No changes were made');
        }

        if ($hasUpdates) {
            $postService->applyUpdates($post, $updates);
        }

        // $imageService->updateExistingImages();
        // If images exist, process them
        if ($hasImages) {
            // dd($request->file('photo'), $request->hasFile('photo'));

            // $lastPostId = $post->id;
            // $lastCompetitionId = $request->id_competition_fetched ?? $post->competition->id ?? null;

            $imageService->uploadImages($request->file('photo'), $post, $updates);

            // If updates also exist, update the post
            return redirect()->back()->with(
                'success',
                $hasUpdates ? 'Images and details updated' : 'Images uploaded successfully'
            );
        }


        if ($request->hasFile('images')) {
            $imageService->updateExistingImages($request->file('images'), $request->imageId, $post);
            return redirect()->back()->with('success', 'The image was succesfully updated');
        }

        return redirect()->back()->with('success', 'Updated successfully');
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
