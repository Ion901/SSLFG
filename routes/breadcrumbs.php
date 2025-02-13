<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\Posts;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('HOME', route('home'));
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


// Breadcrumbs::for('noutate', function (BreadcrumbTrail $trail) {

//     $trail->parent('noutati');
//     $trail->push('', route('noutati'));
// });

