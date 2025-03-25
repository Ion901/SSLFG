<?php

use App\Models\Athlets;
use App\Models\Premiants;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\Posts;
use App\Models\Competitions;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('HOME', route('home'));
});
Breadcrumbs::for('post', function (BreadcrumbTrail $trail) {
    $trail->push('Postari', route('posts'));
});

Breadcrumbs::for('athlets', function (BreadcrumbTrail $trail) {
    $trail->push('Sportivi', route('athlets.index'));
});

Breadcrumbs::for('competitions', function (BreadcrumbTrail $trail) {
    $trail->push('Competiții', route('competitions'));
});

Breadcrumbs::for('sportivi', function (BreadcrumbTrail $trail) {
    $trail->push('Premianți', route('premiants'));
});

Breadcrumbs::for('about',function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('ABOUT',route('about'));
});

Breadcrumbs::for('fotografii', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('FOTOGRAFII', route('fotografii'));
});

Breadcrumbs::for('noutati', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('NOUTĂȚI', route('noutati'));
});

Breadcrumbs::for('contacte', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('CONTACTE', route('contacte'));
});

Breadcrumbs::for('post_title', function (BreadcrumbTrail $trail) {
    $trail->parent('noutati');
    $slug = preg_replace('/noutati\//','',request()->path());
    $post_title = Posts::where('post_slug',$slug)->valueOrFail('post_title');
    $trail->push($post_title, route('NewsPost',$post_title));
});

Breadcrumbs::for('addPost', function (BreadcrumbTrail $trail) {
    $trail->parent('post');
    $trail->push('Adauga o Postare', route('posts.create'));
});

Breadcrumbs::for('addCompetition', function (BreadcrumbTrail $trail) {
    $trail->parent('competitions');
    $trail->push('Adauga o competitie', route('competitions.create'));
});

Breadcrumbs::for('addAthlets', function (BreadcrumbTrail $trail) {
    $trail->parent('sportivi');
    $trail->push('Adauga premianti', route('premiants.create'));
});

Breadcrumbs::for('addSportivi', function (BreadcrumbTrail $trail) {
    $trail->parent('athlets');
    $trail->push('Adauga sportivi', route('athlets.create'));
});


Breadcrumbs::for('viewPost', function (BreadcrumbTrail $trail) {
    $trail->parent('post');
    $slug = preg_replace('/posts\//','',request()->path());
    $post_title = Posts::where('post_slug',$slug)->valueOrFail('post_title');
    $trail->push('Vezi Postarea', route('posts.show',$post_title));
});

Breadcrumbs::for('editPost', function (BreadcrumbTrail $trail) {
    $trail->parent('post');
    $slug = preg_match("/posts\/([^\/]+)\//",request()->path(),$matches);
    $slug = $matches ?? null;
    $post_title = Posts::where('post_slug',$slug[1])->valueOrFail('post_title');
    $trail->push('Editeaza Postarea', route('posts.edit',$post_title));
});

Breadcrumbs::for('editCompetition', function (BreadcrumbTrail $trail) {
    $trail->parent('competitions');
    preg_match("/competitions\/(\d+)\/edit/",request()->path(),$matches);
    $id = $matches[1];
    $competition_name = Competitions::where('id',$id)->valueOrFail('name');
    $trail->push('Editează Competiția', route('posts.edit',$competition_name));
});

Breadcrumbs::for('editPremiant', function (BreadcrumbTrail $trail) {
    $trail->parent('sportivi');
    preg_match("/premiants\/(\d+)\/edit/",request()->path(),$matches);
    $id = $matches[1];
    $trail->push('Editeaza datele premiantului', route('premiants.edit',$id));
});

Breadcrumbs::for('editAthlet', function (BreadcrumbTrail $trail) {
    $trail->parent('athlets');
    preg_match("/athlets\/(\d+)\/edit/",request()->path(),$matches);
    $id = $matches[1];
    $trail->push('Editeaza datele sportivului', route('athlets.edit',$id));
});



