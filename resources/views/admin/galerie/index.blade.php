<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"> </script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script src="https://kit.fontawesome.com/d258707c8d.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
@vite(['resources/js/galerie.js','resources/css/admin/galerie.css','resources/css/breadcrumb.css'])
<x-dash-app-layout>
    <div class="page">
        {{ Breadcrumbs::render('gallery') }}
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @elseif(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <section class="image-container">

        @foreach ($gallery as $image)
        <ul>
        <div class="flex flex-col w-[300px]">
            <div class="images-slider w-[300px]">
                <img loading="lazy" class="myImg" data-index="{{ $image->id }}" data-lazy="{{ asset($image->gallery_path) }}" alt="error">
            </div>
            <div class="border-2 border-gray-200 p-2 flex flex-wrap items-end">
                <form action="{{route('gallery.update',$image->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="custom-file mb-1 ">
                        <input type="file" class="custom-file-input" accept="image/*" id="customFile" name="images">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                        <input type="hidden" name="imageId" value="{{$image->id}}">
                    </div>
                        <button type="submit" class="w-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                            Actualizează
                        </button>
                        <button type="button" class="clear-file w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 ml-2.5 rounded">
                            Anuleaza
                        </button>
                </form>
                <form action="{{route('gallery.destroy', $image->id)}}" method="POST" id="delete">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="imageId" value="{{$image->id}}">
                    <button type="submit"
                    class="clear-file w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                    onclick="return confirm('Esti sigur ca vrei sa stergi aceasta poza?')">
                        Sterge
                    </button>
                </form>
            </div>

        </div>



        <!-- Lightbox Modal -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div class="lightbox-nav">
                <span class="prev">&#10094;</span>
                <span class="next">&#10095;</span>
            </div>
        </div>
    </ul>
            @endforeach

    </section>
    <div style="direction: rtl;padding-right:10px; position:sticky;bottom:4%;left: 94.5%;z-index:99999;">
        <a href="{{route('gallery.create')}}" class="link">
        <div class="add-new-album">
            <div>
                    <i class="fa-solid fa-plus"></i>
                    <span class="tooltiptext">Adauga poze</span>
            </div>
        </div>
    </a>
    </div>
</x-dash-app-layout>
<script>
        $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $(".clear-file").on("click", function () {
        var fileInput = $(this).closest("form").find(".custom-file-input");
        var fileLabel = $(this).closest("form").find(".custom-file-label");

        fileInput.val(""); // Clear only this specific input
        fileLabel.removeClass("selected").html("Choose file"); // Reset label
    });

</script>
