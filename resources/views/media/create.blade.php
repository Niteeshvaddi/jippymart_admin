@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Create Media</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('media.index') }}">Media</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card pb-4">
            <div class="card-header">
                <span class="btn btn-primary">CREATE MEDIA</span>
            </div>
            <div class="card-body">
                <div class="error_top alert alert-danger" style="display:none"></div>
                <form id="mediaForm">
                    <div class="form-group row">
                        <label class="col-3 control-label">Name</label>
                        <div class="col-7">
                            <input type="text" class="form-control" id="media_name" required>
                            <small class="form-text text-muted">Insert Name</small>
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
                            <input type="file" id="media_image" accept="image/*" required>
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
var database = firebase.firestore();
var storageRef = firebase.storage().ref('media');
var photo = "";
var imageName = "";
var imagePath = "";

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

$('#mediaForm').submit(async function (e) {
    e.preventDefault();
    var name = $('#media_name').val();
    var slug = $('#media_slug').val();
    if (!name || !photo) {
        $('.error_top').show().html('<p>Please enter a name and select an image.</p>');
        return;
    }
    $('.error_top').hide();
    var uploadTask = storageRef.child(imageName).putString(photo.replace(/^data:image\/[a-z]+;base64,/, ''), 'base64', {contentType: 'image/jpg'});
    uploadTask.then(async function (snapshot) {
        imagePath = await snapshot.ref.getDownloadURL();
        $('#media_image_path').val(imagePath);
        var docRef = database.collection('media').doc();
        await docRef.set({
            id: docRef.id,
            name: name,
            slug: slug,
            image_name: imageName,
            image_path: imagePath
        });
        window.location.href = '{{ route('media.index') }}';
    }).catch(function (error) {
        $('.error_top').show().html('<p>' + error + '</p>');
    });
});
</script>
@endsection