<?php

namespace App\Http\Controllers;

use App\Models\Athlets;
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

        $posts->each(function($post){
            $post->images = $post->image()->where('id_post',$post->id)->first(['image_path'])?->image_path;
            $post->competition = $post->competition()->first(['id'])?->id;
        });

        $lastCompetition = Competitions::orderBy('date', 'desc')->first();
        $athlets = Athlets::where('id_competition', $lastCompetition->id)
            ->select('athlets.*', 'competitions.location', 'competitions.date')
            ->join('competitions', 'athlets.id_competition', '=', 'competitions.id')
            ->get();

        if($athlets->isEmpty()){
            $previousCompetition = Competitions::where('date','<',$lastCompetition->date)->orderBy('date','desc')->first();

            if($previousCompetition){
                $athlets = Athlets::where('id_competition', $previousCompetition->id)
            ->select('athlets.*', 'competitions.location', 'competitions.date')
            ->join('competitions', 'athlets.id_competition', '=', 'competitions.id')
            ->get();
            }
        }
        $athlets->postCompetition = $posts->where('id_competition',$athlets->first()?->id_competition)->value('post_slug');

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

    public function post($slug){

        $post = Posts::where('post_slug',$slug)->firstOrFail();
        $post->images = $post->image()->where('id_post',$post->id)->pluck('image_path');
        // dd($post->images);
        if($post->id_category === 1){
            $post->competition = $post->competition()->first();
            $post->athlets = Athlets::where('id_competition',$post->competition->id)->get();
        }
        if(count($post->images) <= 3){
            return view('pages.noutati',['error' => 'Needs more photos']);
        }else{
            return view('pages.noutati',['post'=>$post]);
        }
    }

}
