<?php

namespace App\Services;

use App\Exceptions\DuplicateEntriesException;
use App\Models\Posts;
use Exception;
use Illuminate\Support\Str;

class PostService
{
    public function prepareTitleUpdate(Posts $post, string $title): array
    {
        if (empty($title))
            return [];

        if ($post->post_title !== $title)
            return [];

        $changedTitle = strtolower($post->post_title) !== strtolower($title);
        $uniqueTitle = Posts::where('post_title', $title)
            ->where('id', '!=', $post->id)
            ->exists();

        if ($changedTitle && $uniqueTitle) {
            throw new DuplicateEntriesException('This title already exists');
        }

        return [
            'post_title' => $title,
            'post_slug' => Str::Slug($title)
        ];
    }

    public function prepareContentUpdate(Posts $post, string $content): array
    {
        if (empty($content))
            return [];

        if ($post->post_content !== $content)
            return [];

        $changedContent = strtolower($post->post_content) !== strtolower($content);
        $uniqueContent = Posts::where('post_content', $content)
            ->where('id', '!=', $post->id)
            ->exists();

        if ($changedContent && $uniqueContent) {
            throw new DuplicateEntriesException('This content already exists');
        }

        return [
            'post_content' => $content,
            'post_slug' => Str::Slug($content)
        ];
    }

    public function applyUpdates(Posts $post, array $updated): bool
    {
        if (empty($updated))
            return false;

        $post->update($updated);
        return true;
    }
}
