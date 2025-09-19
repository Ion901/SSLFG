<?php

namespace App\Http\Controllers;

use App\Models\Premiants;
use App\Models\Gallery;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Posts::with(['image' => function($query){
            $query->select('id_post','image_path');
        }])->get();

        $latestCompetitionId = Premiants::join('posts', 'premiants.id_competition', '=', 'posts.id_competition')
        ->orderBy('premiants.id', 'desc')
        ->limit(1)
        ->pluck('premiants.id_competition')
        ->first();

        $athlets = Premiants::with('competition.post','athlet')
        ->where('id_competition', $latestCompetitionId)
        ->orderBy('id', 'desc')
        ->get();

        $athlets->each(function($athlet){
            $athlet->postCompetition = $athlet->competition->post->post_slug ?? null;
        });

        return view('pages.index')->with(['posts'=>$posts, 'athlets' => $athlets]);
    }
    public function news()
    {
        $posts = Posts::with('image','competition')->paginate(10);
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

    public function post(Request $request, Posts $post){
        //random 3 postari sugerate la sfarsitul paginii
        $posts = Posts::with(['image' => function($query){
            $query->whereNotNull('image_path')->select('id_post', 'image_path');
        }])
            ->where('post_slug', '!=', $post->post_slug)
            ->whereNotNull('post_content')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $posts->each(function($item){
            $item->images = $item->image->first()?->image_path;
        });

        if($post->id_category === 1){
            $post->competitionDetails = $post->competition;
            $post->athlets = Premiants::with('athlet')
                                ->where('id_competition',$post->competition->id)
                                ->get();
        }

        if($post->image->count() <= 1 && !$post->post_content){
            return view('pages.noutati',['error' => 'Needs more photos']);
        }else{
            return view('pages.noutati',['post'=>$post,'posts'=>$posts]);
        }
    }

}
