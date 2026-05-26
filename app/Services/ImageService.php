<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Models\Posts;
use App\Models\PostImages;
use Illuminate\Support\Facades\File;

class ImageService
{

    private function storeImages(UploadedFile $image): string
    {
        $extension = $image->getClientOriginalExtension();

        $photoName = uniqid() . time() . '.' . $extension;

        $path = $image->storeAs(
            'images/post',
            $photoName,
            'public'
        );

        return '/storage/' . $path;
    }
    // upload imagini noi
    public function uploadImages(array $images, Posts $post, int|array $updates): void
    {
        if(is_array($updates) && array_key_exists('id_competition',$updates)){
            $value = $updates['id_competition'];
        }else if(!is_array($updates)){
            $value = $updates;
        }else{
            $value = null;  
        }
        $competitionId = $value
            ?? optional($post->competition)->id
            ?? null;

        foreach ($images as $image) {
            $photo = new PostImages();

            $imagePath = $this->storeImages($image);

            $photo->image_path = $imagePath;
            $photo->id_post = $post->id;
            $photo->id_competition = $competitionId;
            $photo->saveOrFail();
        }
    }


    // update imagine existentă
    public function updateExistingImages(UploadedFile $newImage, int $imageId, Posts $post): void
    {
        //pentru a actualiza pozele prezente la moment
        $oldPhotoStoragePath = public_path($post->image()->where('id', $imageId)->pluck('image_path')?->first());
        $oldImage = PostImages::find($imageId);

        if ($oldImage && File::exists($oldPhotoStoragePath)) {
            File::delete($oldPhotoStoragePath);
        }

        $imagePath = $this->storeImages($newImage);

        $oldImage?->update(['image_path' => $imagePath]);
    }


    // sync id_competition pe imagini
    public function syncCompetitionOnImages(Posts $post, ?int $competitionId): void
    {
        $post->image->each(function ($image) use ($competitionId) {
            $image->update([
                'id_competition' => $competitionId
            ]);
        });
    }
}
