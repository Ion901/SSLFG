<?php

namespace App\Http\Controllers;

use App\Models\Premiants;
use App\Models\Competitions;
use App\Models\Gallery;
use App\Models\PostImages;
use App\Models\Posts;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Posts::all();

        // ultimii atleti care au participat la o competitie care are 100% o postare dedicata ei
        $posts->each(function($post){
            $post->images = $post->image()->where('id_post',$post->id)->first(['image_path'])?->image_path;
            $post->competition = $post->competition()->first(['id'])?->id;
        });

        $latestCompetitionId = Premiants::join('posts', 'premiants.id_competition', '=', 'posts.id_competition')
        ->orderBy('premiants.id', 'desc')
        ->limit(1)
        ->pluck('premiants.id_competition')
        ->first();

        $athlets = Premiants::where('id_competition', $latestCompetitionId)
        ->orderBy('id', 'desc')
        ->get();
        // dd(Premiants::first()->athlet->fullName);

        $athlets->each(function($athlet){
            $athlet->postCompetition = Posts::where('id_competition',$athlet->id_competition)->value('post_slug');
        });

        return view('pages.index')->with(['posts'=>$posts, 'athlets' => $athlets]);
    }
    public function news()
    {
        $posts = Posts::paginate(10);

        $posts->each(function($post){
            $post->images = $post->image()->where('id_post',$post->id)->first(['image_path'])?->image_path;
            $post->competition = $post->competition()->first(['id'])?->id;
        });
        return view('pages.noutati',['posts'=>$posts]);
    }
    public function gallery()
    {
        $images = Gallery::all();

        return view('pages.galerie',['images' => $images]);
    }
    public function about()
    {
        return view('pages.about');
    }
    public function contacte()
    {
        return view('pages.contacte');
    }

    public function post(Request $request, $slug){

        // $postSlug = $request->post_slug;
        $posts = Posts::where('post_slug', '!=', $slug)->whereNotNull('post_content')->inRandomOrder()->take(3)->get();
        // dump($slug);
        $posts->each(function($post){
            $post->image = $post->image()->where('id_post',$post->id)->whereNotNull('image_path')->first(['image_path'])?->image_path;
        });
        // dd($posts);  

        // return response()->json($posts);

        $post = Posts::where('post_slug',$slug)->firstOrFail();
        $post->images = $post->image()->where('id_post',$post->id)->pluck('image_path');
        // dd($post->images);
        if($post->id_category === 1){
            $post->competition = $post->competition()->first();
            $post->athlets = Premiants::where('id_competition',$post->competition->id)->get();
        }

        if(count($post->images) <= 1 && !$post->post_content){
            return view('pages.noutati',['error' => 'Needs more photos']);
        }else{
            return view('pages.noutati',['post'=>$post,'posts'=>$posts]);
        }
    }

}
