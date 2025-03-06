<x-dash-app-layout>

        <div class="flex ml-8">
            <x-crud-button :href="route('posts.create')" :add="true">
                Adauga o postare
            </x-crud-button>
            <h1 class="justify-content-sm-center text-center text-3xl m-0 m-auto">Postari</h1>
        </div>

    <table class="m-0 m-auto table table-bordered table-hover">
        <tr>
            <th>Titlu</th>
            <th>Category</th>
            <th>Date</th>
        </tr>
        @foreach ($posts as $post)
        <tr class="border-b-4 border-black mb-2">
                <td class="break-words text-left pr-3">{{$post->post_title}}</td>
                <td class="pr-3">{{$post->category}}</td>
                <td class="pr-3">{{Str::replaceMatches('/\s\d.*/', '', $post->post_date) }}</td>
                <td>
                    <x-crud-button :href="route('posts.show',$post->post_slug)" :view="true">
                        View
                    </x-crud-button>
                </td>
                <td>
                    <x-crud-button :href="route('posts.edit',$post->post_slug)" :edit="true">
                        Edit
                    </x-crud-button>
                </td>
                <td>
                    <form action="{{ route('posts.destroy', $post->post_slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <x-crud-button type="submit" :delete="true">
                            Delete
                        </x-crud-button>
                    </form>
                </td>
        </tr>
        @endforeach
    </table>
    <div class="flex justify-center mt-3">
        {{ $posts->links() }}
    </div>
</x-dash-app-layout>
