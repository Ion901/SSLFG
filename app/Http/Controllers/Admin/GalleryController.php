<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gallery = Gallery::all();
        return view('admin.galerie.index',compact('gallery'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galerie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    $request->validate([
        'photo.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

        if ($request->hasFile('photo')) {

            foreach ($request['photo'] as $image) {
                $photo = new Gallery();
                $extension = $image->getClientOriginalExtension();
                $photoName = uniqid() . time() . '.' . $extension;
                $target_dir = public_path('/storage/images/');
                $image->move($target_dir, $photoName);

                $photo->gallery_path = '/storage/images/' . $photoName;
                $photo->saveOrFail();
            }
        }else{
            return redirect()->back()->with('error', "Nu ati adauagat nici o fotografie");
        }

        return redirect(route('gallery'))->with('message', "Imaginile au fost adaugate cu succes");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'photo.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if($request->hasFile('images')){ //pentru a actualiza pozele prezente la moment
            $oldPhotoStoragePath = public_path(Gallery::where('id', $request->imageId)->pluck('gallery_path')?->first());
            $image = new Gallery();
            // dd($oldPhotoStoragePath, File::exists($oldPhotoStoragePath));
            if(File::exists($oldPhotoStoragePath)){

                $extension = $request->images->getClientOriginalExtension();
                $photoName = uniqid() . time() . '.' . $extension;
                $target_dir = public_path('/storage/images/');
                File::delete($oldPhotoStoragePath);
                $request->images->move($target_dir, $photoName);

                $image->where('id',$request->imageId)->update(['gallery_path' => '/storage/images/'.$photoName]);

                return redirect()->back()->with('success','Imaginea a fost actualizata cu succes');
            }else{//actualizam imaginea fara a o sterge pe cea veche fiindca ea nu exista
                $extension = $request->images->getClientOriginalExtension();
                $photoName = uniqid() . time() . '.' . $extension;
                $target_dir = public_path('/storage/images/');
                $request->images->move($target_dir, $photoName);

                $image->where('id',$request->imageId)->update(['gallery_path' => '/storage/images/'.$photoName]);

                return redirect()->back()->with('success','Imaginea a fost actualizata cu succes');
            }
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $image = Gallery::where('id',$id)->firstOrFail();
        // dd(File::exists(public_path($image->gallery_path)));
            if(File::exists(public_path($image->gallery_path))){
                File::delete(public_path($image->gallery_path));
                if($image->exists()){
                    $image->delete();
                }
                return redirect()->back()->with('success','Fotografia a fost stearsa cu succes');
            }else{
                return redirect()->back()->with('error','Ceva nu a mers bine');
            }
    }
}
