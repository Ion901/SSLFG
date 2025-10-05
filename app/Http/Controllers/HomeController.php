<?php

namespace App\Http\Controllers;

use App\Models\Premiants;
use App\Models\Gallery;
use App\Models\Posts;
use App\Models\Campioni;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Posts::with('image')->limit(6)->get();

        $postsForSlider = Posts::with('image')->orderByDesc('post_date')->limit(3)->get();

        $latestCompetitionId = $this->getLatestCompetitionId();

        $athlets = Premiants::with('competition.post','athlet')
        ->where('id_competition', $latestCompetitionId)
        ->orderBy('id', 'desc')
        ->get();

        $athlets->each(function($athlet){
            $athlet->postCompetition = $athlet->competition->post->post_slug ?? null;
        });

        return view('pages.index')->with(compact('posts', 'postsForSlider', 'athlets'));
    }

    /**
     * Get the latest competition ID by joining premiants and posts.
     *
     * @return int|null
     */
    private function getLatestCompetitionId()
    {
        return Premiants::join('posts', 'premiants.id_competition', '=', 'posts.id_competition')
            ->orderBy('premiants.id', 'desc')
            ->limit(1)
            ->pluck('premiants.id_competition')
            ->first();
    }
    public function news()
    {
        $posts = Posts::with('image','competition')->paginate(10);
        // dd($posts);
        return view('pages.noutati',['posts'=>$posts]);
    }

    public function gallery()
    {
        $images = Gallery::all();
        return view('pages.galerie',['images' => $images]);
    }

    public function about()
    {
        $staticYears = ["2024","2022","2021","2020","2016","2015","2014","2013","2012","2011","2010","2008","2006","2005","2004","2003","2002","2001","2000","1997","1995","1994","1993","1987","1985","1983","1980","1980"
        ];

        $currentYear = date('Y');
        $previousYear = $currentYear - 1;

        $dateRange = array_unique(array_merge([$currentYear,$previousYear], $staticYears));

        $dataCampioni = Campioni::all();

        return view('pages.about', ['dateRange' => $dateRange,'campioni' => $dataCampioni]);
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
