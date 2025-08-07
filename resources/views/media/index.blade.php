@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('Media')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('Media')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="admin-top-section">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex top-title-section pb-4 justify-content-between">
                        <div class="d-flex top-title-left align-self-center">
                            <span class="icon mr-3"><img src="{{ asset('images/category.png') }}"></span>
                            <h3 class="mb-0">{{trans('Media List')}}</h3>
                            <span class="counter ml-3 media_count"></span>
                        </div>
                        <div class="d-flex top-title-right align-self-center">
                            <div class="select-box pl-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-list">
            <div class="row">
                <div class="col-12">
                    <div class="card border">
                        <div class="card-header d-flex justify-content-between align-items-center border-0">
                            <div class="card-header-title">
                                <h3 class="text-dark-2 mb-2 h4">{{trans('Media List')}}</h3>
                                <p class="mb-0 text-dark-2">{{trans('View and manage all the media')}}</p>
                            </div>
                            <div class="card-header-right d-flex align-items-center">
                                <div class="card-header-btn mr-3">
                                    <a class="btn-primary btn rounded-full" href="{!! route('media.create') !!}">
                                        <i class="mdi mdi-plus mr-2"></i>{{trans('Media Create')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive m-t-10">
                                <table id="mediaTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> All</a></label></th>
                                            <th class="text-center">Media Info</th>
                                            <th class="text-center">Slug</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="append_media"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="data-table_processing" class="data-table-processing" style="display: none">Processing...</div>
@endsection
@section('scripts')
<style>
.table-responsive {
    overflow-x: auto;
}
#mediaTable {
    width: 100% !important;
}
#mediaTable td {
    white-space: nowrap;
    vertical-align: middle;
}
#mediaTable .delete-all {
    width: 80px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}
#mediaTable .delete-all input[type="checkbox"] {
    margin: 0;
}
#mediaTable .delete-all .expand-row {
    margin: 0;
}
#mediaTable th:nth-child(2) {
    width: 200px;
}
#mediaTable th:nth-child(3) {
    width: 150px;
}
#mediaTable th:nth-child(4) {
    width: 100px;
}
.action-btn {
    white-space: nowrap;
}
</style>
<script>
var database = firebase.firestore();
var placeholderImage = '';
var selectedMedia = new Set();

function formatExpandRow(data) {
    return `
        <div class="p-2">
            <strong>Image Path:</strong> <span class="text-monospace">${data.image_path || ''}</span>
        </div>
    `;
}

async function buildHTML(val) {
    var html = [];
    var id = val.id;
    var route1 = '{{route("media.edit",":id")}}';
    route1 = route1.replace(':id', id);
    
    // Checkbox column with expand button - same structure as restaurants
    html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label" for="is_open_' + id + '" ></label><button class="expand-row" data-id="' + id + '" tabindex="-1" style="width: 18px; height: 18px; border-radius: 50%; background-color: #28a745; border: 2px solid #ffffff; display: inline-flex; align-items: center; justify-content: center; padding: 0; margin-left: 5px; position: relative; z-index: 1;"><i class="fa fa-plus" style="color: white; font-size: 8px;"></i></button></td>');
    
    // Media Info column - same structure as restaurants
    var mediaInfo = '';
    if (val.image_path && val.image_path != '') {
        mediaInfo += '<img src="' + val.image_path + '" style="width:70px;height:70px;border-radius:5px;" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
    } else {
        mediaInfo += '<img src="' + placeholderImage + '" style="width:70px;height:70px;border-radius:5px;">';
    }
    if(val.name != " " && val.name != "null" && val.name != null && val.name != ""){
        mediaInfo += '<a href="' + route1 + '">' + val.name + '</a>';
    }else{
        mediaInfo += 'UNKNOWN';
    }
    html.push(mediaInfo);
    
    // Slug column
    html.push(val.slug || '');
    
    // Actions column - same structure as restaurants
    var actionHtml = '<span class="action-btn">';
    actionHtml += '<a href="' + route1 + '"><i class="mdi mdi-lead-pencil" title="Edit"></i></a>';
    actionHtml += '<a id="' + id + '" name="media-delete" href="javascript:void(0)" class="delete-btn"><i class="mdi mdi-delete" title="Delete"></i></a>';
    actionHtml += '</span>';
    html.push(actionHtml);
    
    return html;
}

$(document).ready(function () {
    // Get placeholder image
    database.collection('settings').doc('placeHolderImage').get().then(function (snap) {
        if (snap.exists) placeholderImage = snap.data().image;
    });

    var table = $('#mediaTable').DataTable({
        pageLength: 10,
        processing: false,
        serverSide: true,
        responsive: true,
        ajax: async function(data, callback, settings) {
            const start = data.start;
            const length = data.length;
            const searchValue = data.search.value.toLowerCase();
            const orderColumnIndex = data.order[0].column;
            const orderDirection = data.order[0].dir;
            const orderableColumns = ['', 'name', 'slug', ''];
            const orderByField = orderableColumns[orderColumnIndex];
            
            if (searchValue.length >= 3 || searchValue.length === 0) {
                $('#data-table_processing').show();
            }
            
            database.collection('media').orderBy('name').get().then(async function(querySnapshot) {
                if (querySnapshot.empty) {
                    $('.media_count').text(0);
                    $('#data-table_processing').hide();
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: []
                    });
                    return;
                }
                
                let records = [];
                let filteredRecords = [];
                
                querySnapshot.forEach(function(doc) {
                    var d = doc.data();
                    d.id = doc.id;
                    
                    if (searchValue) {
                        if (
                            (d.name && d.name.toString().toLowerCase().includes(searchValue)) ||
                            (d.slug && d.slug.toString().toLowerCase().includes(searchValue))
                        ) {
                            filteredRecords.push(d);
                        }
                    } else {
                        filteredRecords.push(d);
                    }
                });
                
                filteredRecords.sort((a, b) => {
                    let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase() : '';
                    let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase() : '';
                    
                    if (orderDirection === 'asc') {
                        return (aValue > bValue) ? 1 : -1;
                    } else {
                        return (aValue < bValue) ? 1 : -1;
                    }
                });
                
                const totalRecords = filteredRecords.length;
                $('.media_count').text(totalRecords);
                
                const paginatedRecords = filteredRecords.slice(start, start + length);
                
                await Promise.all(paginatedRecords.map(async (mediaData) => {
                    var getData = await buildHTML(mediaData);
                    records.push(getData);
                }));
                
                $('#data-table_processing').hide();
                callback({
                    draw: data.draw,
                    recordsTotal: totalRecords,
                    recordsFiltered: totalRecords,
                    data: records
                });
            });
        },
        order: [1, 'asc'],
        columnDefs: [
            {orderable: false, targets: [0, 3]}
        ],
        "language": {
            "zeroRecords": "No record found",
            "emptyTable": "No record found",
            "processing": ""
        }
    });

    // Select all logic
    $("#is_active").click(function () {
        $("#mediaTable .is_open").prop('checked', $(this).prop('checked'));
    });

    // Row checkbox logic
    $('#mediaTable tbody').on('change', '.is_open', function () {
        var id = $(this).attr('dataId');
        if (this.checked) {
            selectedMedia.add(id);
        } else {
            selectedMedia.delete(id);
        }
        $('#is_active').prop('checked', $('.is_open:checked').length === $('.is_open').length);
    });

    // Expand/collapse row
    $('#mediaTable tbody').on('click', '.expand-row', function (e) {
        e.preventDefault();
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var id = $(this).data('id');
        var icon = $(this).find('i');
        
        // Get the media data for this row
        database.collection('media').doc(id).get().then(function(doc) {
            if (doc.exists) {
                var mediaData = doc.data();
                if (row.child.isShown()) {
                    row.child.hide();
                    icon.removeClass('fa-minus text-danger').addClass('fa-plus text-success');
                    $(this).css('background-color', '#28a745');
                } else {
                    row.child(formatExpandRow(mediaData)).show();
                    icon.removeClass('fa-plus text-success').addClass('fa-minus text-danger');
                    $(this).css('background-color', '#dc3545');
                }
            }
        });
    });

    // Single delete
    $('#mediaTable tbody').on('click', '.delete-btn', function () {
        var id = $(this).attr('id');
        if (confirm('Are you sure you want to delete this media?')) {
            jQuery('#data-table_processing').show();
            database.collection('media').doc(id).delete().then(function () {
                selectedMedia.delete(id);
                table.ajax.reload();
                jQuery('#data-table_processing').hide();
            });
        }
    });

    // Bulk delete
    $("#deleteAll").click(function () {
        if ($('#mediaTable .is_open:checked').length) {
            if (confirm("Delete selected media?")) {
                jQuery('#data-table_processing').show();
                $('#mediaTable .is_open:checked').each(function () {
                    var id = $(this).attr('dataId');
                    database.collection('media').doc(id).delete();
                    selectedMedia.delete(id);
                });
                setTimeout(function () {
                    table.ajax.reload();
                    jQuery('#data-table_processing').hide();
                }, 500);
            }
        } else {
            alert("Select at least one media to delete.");
        }
    });
});
</script>
@endsection
