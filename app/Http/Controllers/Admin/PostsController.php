<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Athlets;
use App\Models\Category;
use App\Models\Competitions;
use App\Models\PostImages;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // DB::enableQueryLog();
        $posts = Posts::paginate(10);

        $posts->each(function ($post) {
            $post->category = $post->category()->where('id', $post->id_category)->value('type');
        });

        // dd(DB::getQueryLog($posts));
        // dd($posts);
        return view('admin.posts.index', ['posts' => $posts]);
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

                $lastPostId = $post->orderBy('id', 'desc')->first()?->id;
                $lastCompetitionId = $competition->orderBy('id', 'desc')->first()?->id;
                foreach ($input['photo'] as $image) {
                    $photo = new PostImages();
                    $extension = $image->getClientOriginalExtension();
                    $photoName = uniqid() . time() . '.' . $extension;
                    $target_dir = public_path('/storage/images/post/');
                    $image->move($target_dir, $photoName);

                    $photo->image_path = '/storage/images/post/' . $photoName;
                    $photo->id_post = $lastPostId;
                    $photo->id_competition = $lastCompetitionId;
                    $photo->saveOrFail();
                }
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

            $lastPostId = $post->orderBy('id', 'desc')->first()?->id;
            $lastCompetitionId = $competition->orderBy('id', 'desc')->first()?->id;
            if ($request->hasFile('photo')) {
            foreach ($input['photo'] as $image) {
                $photo = new PostImages();
                $extension = $image->getClientOriginalExtension();
                $photoName = uniqid() . time() . '.' . $extension;
                $target_dir = public_path('/storage/images/post/');
                $image->move($target_dir, $photoName);

                $photo->image_path = '/storage/images/post/' . $photoName;
                $photo->id_post = $lastPostId;
                $photo->id_competition = $lastCompetitionId;
                $photo->saveOrFail();
            }
        }
        return redirect(route('posts'))->with('message', "The post has been succesfully created");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $post = Posts::where('post_slug', $slug)->firstOrFail();
        $post->images = $post->image()->where('id_post', $post->id)->pluck('image_path');
        // dd($post->images);
        if ($post->id_category === 1) {
            $post->competition = $post->competition()->first();
            $post->athlets = Athlets::where('id_competition', $post->competition->id)->get();
        };
        return view('admin.posts.view', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $post = Posts::where('post_slug', $slug)->firstOrFail();
        $post->images = $post->image()->where('id_post', $post->id)->get();
        $post->category = Category::where('id', $post->id_category)->value('type');

        if ($post->id_category === 1) {
            $post->competition = $post->competition()->first();
            // $post->athlets = Athlets::where('id_competition',$post->competition->id)->get();
        };
        // dd($post->images);

        $categoryes = Category::all();
        $competitions = Competitions::distinct()->get();

        return view('admin.posts.edit', ['post' => $post, 'categoryes' => $categoryes, 'competitions' => $competitions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        // dd($request);
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

        $post = Posts::where('post_slug', $slug)->firstOrFail();
        $competition = Competitions::where('id',$post->id_competition);

        if (request('title')) {

            if (strtolower($post->post_title) != strtolower($request->title) && //titlu este schimbat
                Posts::where('post_title',$request->title)->where('id', '!=', $post->id)->exists()){ //titlu este acelasi cu alt titlu din tabel){
                return redirect()->back()->with('error', 'This title already exists.');
            }else if($post->post_title !== $request->title){
                $updates['post_title'] = $request->title;
                $updates['post_slug'] = Str::slug($request->title);
            }
        }

        if (request('content')) {
            if (strtolower($post->post_content) != strtolower($request->content) && //contentul este schimbat
                Posts::where('post_content',$request->content)->where('id', '!=', $post->id)->exists()){ //contentul este acelasi cu alt titlu din tabel){
                return redirect()->back()->with('error', 'This post content already exists.');
            }elseif($post->post_content !== $request->content){
                $updates['post_content'] = $request->content;
            }
        }
        // dd(!is_null($post->id_competition));
        if (request('category') && $request->category === 'SPORT' && !is_null($post->id_competition)) {

            if ($request->filled('competition_name')) {
                $competition = $post->competition; // Get the related competition

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
                if ($competition->name !== $request->competition_name ||
                    $competition->location !== $request->competition_location ||
                    date('Y-m-d',strtotime($competition->date)) !== $request->competition_date) {

                    if(!empty($updates)){
                        $competition->update([
                            'name' => $request->competition_name,
                            'location' => $request->competition_location,
                            'date' => $request->competition_date
                        ]);
                    }else{
                        $competition->update([
                            'name' => $request->competition_name,
                            'location' => $request->competition_location,
                            'date' => $request->competition_date
                        ]);
                        // $request->category !== Category::where('type', $request->category)->value('type') ? $updates['id_category'] = Category::where('type', $request->category)->value('id') : "";
                        return redirect()->back()->with('success','Succesfully updated');
                    }

                }
            }
        }else if(request('category') && $request->category === 'SPORT' && is_null($post->id_competition)){//case cand schimbam categoria din non-Sport in Sport si facem modificari
            if ($request->filled('competition_name')) {
                $competition = Competitions::where('id',$request->id_competition_fetched)->firstOrFail(); // Get the related competition

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
                $updates['id_competition'] =(int) $request->id_competition_fetched;
                $updates['id_category'] = Category::where('type',$request->category)->value('id');

                // Update competition details only if needed
                if ($competition->name !== $request->competition_name ||
                    $competition->location !== $request->competition_location ||
                    date('Y-m-d',strtotime($competition->date)) !== $request->competition_date) {

                    if(!empty($updates)){
                        $competition->update([
                            'name' => $request->competition_name,
                            'location' => $request->competition_location,
                            'date' => $request->competition_date
                        ]);
                    }else{
                        $competition->update([
                            'name' => $request->competition_name,
                            'location' => $request->competition_location,
                            'date' => $request->competition_date
                        ]);
                        return redirect()->back()->with('success','Succesfully updated');
                    }

                }
            }
        }else if(request('category') && $request->category !== 'SPORT'){
            // $post->id_category = Category::where('type',$request->category)->value('id');
            $updates['id_category'] = Category::where('type',$request->category)->value('id');
            $updates['id_competition'] = null;

        }

        $hasUpdates = !empty($updates);
        $hasImages = $request->hasFile('photo');

        // If only updates exist, update the post
        if ($hasUpdates && !$hasImages) {
            // dd($post);
            $post->update($updates);
            // dd($post->id_category);
            return redirect()->back()->with('success', 'Updated successfully');
        }

        // If images exist, process them
        if ($hasImages ) {
            $lastPostId = $post->id;
            $lastCompetitionId = $request->id_competition_fetched; // Avoids null error

            foreach ($request->file('photo') as $image) {
                $photo = new PostImages();
                $extension = $image->getClientOriginalExtension();
                $photoName = uniqid() . time() . '.' . $extension;
                $target_dir = public_path('/storage/images/post/');
                $image->move($target_dir, $photoName);

                $photo->image_path = '/storage/images/post/' . $photoName;
                $photo->id_post = $lastPostId;
                $photo->id_competition = $lastCompetitionId;
                $photo->save();
            }

            // If updates also exist, update the post
            if ($hasUpdates) {
                $post->update($updates);
                return redirect()->back()->with('success', 'The images and the record details were updated');
            }

            return redirect()->back()->with('success', 'The images were uploaded successfully');
        }


        if($request->hasFile('images')){ //pentru a actualiza pozele prezente la moment
            $oldPhotoStoragePath = public_path($post->image()->where('id', $request->imageId)->pluck('image_path')?->first());
            // dd($oldPhotoStoragePath);
            $image = new PostImages();
            if(File::exists($oldPhotoStoragePath)){

                $extension = $request->images->getClientOriginalExtension();
                $photoName = uniqid() . time() . '.' . $extension;
                $target_dir = public_path('/storage/images/post/');
                File::delete($oldPhotoStoragePath);
                $request->images->move($target_dir, $photoName);

                $image->where('id',$request->imageId)->update(['image_path' => '/storage/images/post/'.$photoName]);

                return redirect()->back()->with('success','The image was succesfully updated');
            }else{//actualizam imaginea fara a o sterge pe cea veche fiindca ea nu exista
                $extension = $request->images->getClientOriginalExtension();
                $photoName = uniqid() . time() . '.' . $extension;
                $target_dir = public_path('/storage/images/post/');
                $request->images->move($target_dir, $photoName);

                $image->where('id',$request->imageId)->update(['image_path' => '/storage/images/post/'.$photoName]);

                return redirect()->back()->with('success','The image was succesfully updated');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug, Request $request)
    {
        $post = Posts::where('post_slug', $slug)->firstOrFail();
        $postImage = $request->imageId;
        if($post && !$postImage){
            $post->delete();

            return redirect()->back()->with('success','The post was succesfully deleted');
        }else{
            $image = $post->image()->where('id',$postImage)->firstOrFail();

            if(File::exists(public_path($image->image_path))){
                File::delete(public_path($image->image_path));
                if($image->exists()){
                    $image->delete();
                }
                return redirect()->back()->with('success','The image was succesfully deleted');
            }else{
                return redirect()->back()->with('error','Something is wrong');
            }
        }

    }
}
