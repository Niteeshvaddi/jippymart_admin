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
                                    <a class="btn-primary btn rounded-full" href="{!! route('media.create') !!}"><i
                                            class="mdi mdi-plus mr-2"></i>{{trans('Media Create')}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive m-t-10">
                                <table id="mediaTable" class="display table table-hover table-striped table-bordered"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="delete-all" style="width:70px;">
                                            <input type="checkbox" id="select-all">
                                            <label class="col-3 control-label d-inline-flex align-items-center"
                                                   for="select-all" style="margin-bottom:0; margin-left:4px;">
                                                <a id="deleteAll" class="do_not_delete d-inline-flex align-items-center"
                                                   href="javascript:void(0);"
                                                   style="color:#ff5722; text-decoration:none;">
                                                    <i class="mdi mdi-delete"
                                                       style="color:#ff5722; font-size:18px; margin-right:2px;"></i>
                                                    <span style="color:#ff5722; font-size:14px;">All</span>
                                                </a>
                                            </label>
                                        </th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Slug</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Data loaded by JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
            @section('scripts')
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
                    $(document).ready(function () {
                        // Add CSS to ensure checkboxes are visible
                        $('<style>')
                            .text(`
                                .is_open {
                                    display: inline-block !important;
                                    visibility: visible !important;
                                    opacity: 1 !important;
                                    width: 16px !important;
                                    height: 16px !important;
                                    position: relative !important;
                                    margin-left: 0 !important;
                                    appearance: auto !important;
                                    -webkit-appearance: auto !important;
                                    -moz-appearance: auto !important;
                                }
                                .delete-all input[type="checkbox"] {
                                    display: inline-block !important;
                                    visibility: visible !important;
                                    opacity: 1 !important;
                                }
                                table.dataTable tbody td {
                                    vertical-align: middle !important;
                                }
                                table.dataTable tbody td input[type="checkbox"] {
                                    display: inline-block !important;
                                    visibility: visible !important;
                                    opacity: 1 !important;
                                    width: 16px !important;
                                    height: 16px !important;
                                    appearance: auto !important;
                                    -webkit-appearance: auto !important;
                                    -moz-appearance: auto !important;
                                    clip: auto !important;
                                    clip-path: none !important;
                                    position: static !important;
                                    left: auto !important;
                                    top: auto !important;
                                }
                                /* Force checkbox visibility in all contexts */
                                input[type="checkbox"].is_open {
                                    display: inline-block !important;
                                    visibility: visible !important;
                                    opacity: 1 !important;
                                    width: 16px !important;
                                    height: 16px !important;
                                    appearance: auto !important;
                                    -webkit-appearance: auto !important;
                                    -moz-appearance: auto !important;
                                    clip: auto !important;
                                    clip-path: none !important;
                                    position: static !important;
                                    left: auto !important;
                                    top: auto !important;
                                }
                                .action-btn {
                                    white-space: nowrap;
                                }
                            `)
                            .appendTo('head');

                        // Get placeholder image
                        database.collection('settings').doc('placeHolderImage').get().then(function (snap) {
                            if (snap.exists) placeholderImage = snap.data().image;
                        });

                        var table = $('#mediaTable').DataTable({
                            pageLength: 10,
                            processing: false,
                            serverSide: true,
                            responsive: true,
                            ajax: function (data, callback, settings) {
                                database.collection('media').orderBy('name').get().then(function (querySnapshot) {
                                    var records = [];
                                    querySnapshot.forEach(function (doc) {
                                        var d = doc.data();
                                        var id = doc.id;
                                        var checked = selectedMedia.has(id) ? 'checked' : '';
                                        var cell = `
    <div style="display: flex; align-items: center; gap: 6px;">
        
        <input type="checkbox" name="record" class="is_open" dataId="${id}" ${checked} style="margin: 0; display: inline-block !important; visibility: visible !important; opacity: 1 !important; width: 16px !important; height: 16px !important; appearance: auto !important;">
        <button class="expand-row" data-id="${id}" tabindex="-1" style="
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: #28a745;
            border: 2px solid #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        ">
            <i class="fa fa-plus" style="color: white; font-size: 8px;"></i>
        </button>
    </div>
`;
                                        var imageHtml = d.image_path
                                            ? `<img src="${d.image_path}" style="width:70px;height:70px;border-radius:5px;" onerror="this.onerror=null;this.src='${placeholderImage}'">`
                                            : `<img src="${placeholderImage}" style="width:70px;height:70px;border-radius:5px;">`;
                                        var actions = `
                        <span class="action-btn">
                            <a href="/media/edit/${id}" class="link-td"><i class="mdi mdi-lead-pencil" title="Edit"></i></a>
                            <a id="${id}" name="media-delete" href="javascript:void(0)" class="delete-btn"><i class="mdi mdi-delete"></i></a>
                        </span>
                    `;
                                        records.push([
                                            cell,
                                            imageHtml,
                                            d.name || '',
                                            d.slug || '',
                                            actions,
                                            id, // hidden for expand
                                            d.image_path || '' // hidden for expand
                                        ]);

                                        // Debug: Log to ensure checkboxes are being generated
                                        // console.log('Generated cell for ID:', id, 'Checkbox included:', cell.includes('checkbox'));
                                    });
                                    callback({
                                        draw: data.draw,
                                        recordsTotal: records.length,
                                        recordsFiltered: records.length,
                                        data: records
                                    });
                                });
                            },
                            order: [2, 'asc'],
                            columnDefs: [
                                {orderable: false, targets: [0, 4]}
                            ],
                                                    language: {
                            zeroRecords: "No record found",
                            emptyTable: "No record found",
                            processing: ""
                        },
                        "drawCallback": function(settings) {
                            // Check if checkboxes are visible after table is drawn
                            setTimeout(function() {
                                var checkboxes = $('.is_open');
                                // console.log('Total checkboxes found:', checkboxes.length);
                                checkboxes.each(function(index) {
                                    var isVisible = $(this).is(':visible');
                                    var display = $(this).css('display');
                                    var visibility = $(this).css('visibility');
                                    var opacity = $(this).css('opacity');
                                    console.log('Checkbox', index, 'Visible:', isVisible, 'Display:', display, 'Visibility:', visibility, 'Opacity:', opacity);
                                });
                            }, 100);
                        }
                        });

                        // Select all logic
                        $('#mediaTable').on('change', '#select-all', function () {
                            var checked = this.checked;
                            $('.is_open').prop('checked', checked).trigger('change');
                        });

                        // Row checkbox logic
                        $('#mediaTable tbody').on('change', '.is_open', function () {
                            var id = $(this).attr('dataId');
                            if (this.checked) {
                                selectedMedia.add(id);
                            } else {
                                selectedMedia.delete(id);
                            }
                            $('#select-all').prop('checked', $('.is_open:checked').length === $('.is_open').length);
                        });

                        // Expand/collapse row
                        $('#mediaTable tbody').on('click', '.expand-row', function (e) {
                            e.preventDefault();
                            var tr = $(this).closest('tr');
                            var row = table.row(tr);
                            var id = row.data()[5];
                            var imagePath = row.data()[6];
                            var icon = $(this).find('i');
                            if (row.child.isShown()) {
                                row.child.hide();
                                icon.removeClass('fa-minus text-danger').addClass('fa-plus text-success');
                            } else {
                                row.child(formatExpandRow({image_path: imagePath, id: id})).show();
                                icon.removeClass('fa-plus text-success').addClass('fa-minus text-danger');
                            }
                        });

                        // Single delete
                        $('#mediaTable tbody').on('click', '.delete-btn', function () {
                            var id = $(this).attr('id');
                            if (confirm('Are you sure you want to delete this media?')) {
                                database.collection('media').doc(id).delete().then(function () {
                                    selectedMedia.delete(id);
                                    table.ajax.reload();
                                });
                            }
                        });

                        // Bulk delete
                        $('#deleteAll').click(function () {
                            if ($('.is_open:checked').length) {
                                if (confirm("Delete selected media?")) {
                                    $('.is_open:checked').each(function () {
                                        var id = $(this).attr('dataId');
                                        database.collection('media').doc(id).delete();
                                        selectedMedia.delete(id);
                                    });
                                    setTimeout(function () {
                                        table.ajax.reload();
                                    }, 500);
                                }
                            } else {
                                alert("Select at least one media to delete.");
                            }
                        });
                    });
                </script>
@endsection
