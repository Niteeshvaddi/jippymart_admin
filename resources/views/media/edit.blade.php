@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Edit Media</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('media.index') }}">Media</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card pb-4">
            <div class="card-header">
                <span class="btn btn-primary">EDIT MEDIA</span>
            </div>
            <div class="card-body">
                <div class="error_top alert alert-danger" style="display:none"></div>
                <form id="mediaEditForm">
                    <div class="form-group row">
                        <label class="col-3 control-label">Name</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="media_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label">Slug</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="media_slug" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label">Image</label>
                        <div class="col-7">
                            <input type="file" id="media_image" accept="image/*">
                            <div class="media_image_preview mt-2"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label">Image Path</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="media_image_path" disabled>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        <a href="{{ route('media.index') }}" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function slugify(text) {
    return text.toString().toLowerCase().replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}
var id = "{{ $id ?? '' }}";
var database = firebase.firestore();
var ref = database.collection('media').doc(id);
var storageRef = firebase.storage().ref('media');
var photo = "";
var imageName = "";
var imagePath = "";
var oldImagePath = "";

$(document).ready(function () {
    ref.get().then(function (doc) {
        if (!doc.exists) {
            $('.error_top').show().html('<p>Error: Media not found for the given ID.</p>');
            return;
        }
        var media = doc.data();
        $('#media_name').val(media.name);
        $('#media_slug').val(media.slug);
        $('#media_image_path').val(media.image_path);
        oldImagePath = media.image_path;
        $('.media_image_preview').html(media.image_path ? '<img class="rounded" style="width:70px" src="' + media.image_path + '" alt="image">' : '');
    });

    $('#media_name').on('input', function () {
        var name = $(this).val();
        var slug = 'media-' + slugify(name);
        imageName = 'media_' + slug + '_' + Date.now();
        $('#media_slug').val(slug);
    });

    $('#media_image').change(function (evt) {
        var f = evt.target.files[0];
        if (!f) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            photo = e.target.result;
            $('.media_image_preview').html('<img class="rounded" style="width:70px" src="' + photo + '" alt="image">');
        };
        reader.readAsDataURL(f);
    });

    $('#mediaEditForm').submit(async function (e) {
        e.preventDefault();
        var name = $('#media_name').val();
        var slug = $('#media_slug').val();
        if (!name) {
            $('.error_top').show().html('<p>Please enter a name.</p>');
            return;
        }
        $('.error_top').hide();
        let newImagePath = oldImagePath;
        if (photo) {
            var uploadTask = storageRef.child(imageName).putString(photo.replace(/^data:image\/[a-z]+;base64,/, ''), 'base64', {contentType: 'image/jpg'});
            await uploadTask.then(async function (snapshot) {
                newImagePath = await snapshot.ref.getDownloadURL();
                $('#media_image_path').val(newImagePath);
            });
        }
        await ref.update({
            name: name,
            slug: slug,
            image_name: imageName,
            image_path: newImagePath
        });
        window.location.href = '{{ route('media.index') }}';
    });
});
</script>
@endsection