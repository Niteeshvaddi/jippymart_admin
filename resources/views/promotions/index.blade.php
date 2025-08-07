@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Promotions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Promotions</li>
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
                            <h3 class="mb-0">Promotions List</h3>
                            <span class="counter ml-3 promotion_count"></span>
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

        {{-- <div class="row mb-4">
            <div class="col-12">
                <div class="card border">
                    <div class="card-header d-flex justify-content-between align-items-center border-0">
                        <div class="card-header-title">
                            <h3 class="text-dark-2 mb-2 h4">Bulk Import Promotions</h3>
                            <p class="mb-0 text-dark-2">Upload Excel file to import multiple promotions at once</p>
                        </div>
                        <div class="card-header-right d-flex align-items-center">
                            <div class="card-header-btn mr-3">
                                <a href="{{ route('promotions.download-template') }}" class="btn btn-outline-primary rounded-full">
                                    <i class="mdi mdi-download mr-2"></i>Download Template
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('promotions.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="importFile" class="control-label">Select Excel File (.xls/.xlsx)</label>
                                        <input type="file" name="file" id="importFile" accept=".xls,.xlsx" class="form-control" required>
                                        <div class="form-text text-muted">
                                            <i class="mdi mdi-information-outline mr-1"></i>
                                            File should contain: restaurant_id, product_id, special_price, extra_km_charge, free_delivery_km, start_time, end_time, payment_mode
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary rounded-full">
                                        <i class="mdi mdi-upload mr-2"></i>Import Promotions
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="table-list">
            <div class="row">
                <div class="col-12">
                    <div class="card border">
                        <div class="card-header d-flex justify-content-between align-items-center border-0">
                            <div class="card-header-title">
                                <h3 class="text-dark-2 mb-2 h4">Promotions Table</h3>
                                <p class="mb-0 text-dark-2">Manage all promotions and their details</p>
                            </div>
                            <div class="card-header-right d-flex align-items-center">
                                <div class="card-header-btn mr-3">
                                    <a href="{{ route('promotions.create') }}" class="btn-primary btn rounded-full">
                                        <i class="mdi mdi-plus mr-2"></i>Add Promotion
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive m-t-10">
                                <table id="promotionsTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> All</a></label></th>
                                            <th>Restaurant</th>
                                            <th>Product</th>
                                            <th>Special Price</th>
                                            <th>Extra KM Charge</th>
                                            <th>Free Delivery KM</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Payment Mode</th>
                                            <th>Available</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="promotion-table-body">
                                    </tbody>
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
<script>
var database = firebase.firestore();
var promotionsRef = database.collection('promotions');
var vendorsMap = {};
var productsMap = {};

function fetchVendorsAndProducts() {
    return database.collection('vendors').get().then(function(vendorSnap) {
        vendorSnap.forEach(function(doc) {
            var data = doc.data();
            vendorsMap[data.id] = data.title;
        });
        return database.collection('vendor_products').get();
    }).then(function(productSnap) {
        productSnap.forEach(function(doc) {
            var data = doc.data();
            productsMap[data.id] = data.name;
        });
    });
}

function formatDateTime(ts) {
    if (!ts) return '';
    var date = ts.seconds ? new Date(ts.seconds * 1000) : new Date(ts);
    return date.toLocaleString();
}

function renderTable(promotions) {
    var tbody = '';
    promotions.forEach(function(promo) {
        tbody += '<tr>' +
            '<td class="delete-all"><input type="checkbox" id="is_open_' + promo.id + '" class="is_open" dataId="' + promo.id + '"><label class="col-3 control-label" for="is_open_' + promo.id + '" ></label></td>' +
            '<td>' + (vendorsMap[promo.restaurant_id] || promo.restaurant_id || '-') + '</td>' +
            '<td>' + (productsMap[promo.product_id] || promo.product_id || '-') + '</td>' +
            '<td>' + (promo.special_price !== undefined ? promo.special_price : '-') + '</td>' +
            '<td>' + (promo.extra_km_charge !== undefined ? promo.extra_km_charge : '-') + '</td>' +
            '<td>' + (promo.free_delivery_km !== undefined ? promo.free_delivery_km : '-') + '</td>' +
            '<td>' + formatDateTime(promo.start_time) + '</td>' +
            '<td>' + formatDateTime(promo.end_time) + '</td>' +
            '<td>' + (promo.payment_mode || '-') + '</td>' +
            '<td>' + (promo.isAvailable ? '<label class="switch"><input type="checkbox" checked id="'+promo.id+'" name="isAvailable"><span class="slider round"></span></label>' : '<label class="switch"><input type="checkbox" id="'+promo.id+'" name="isAvailable"><span class="slider round"></span></label>') + '</td>' +
            '<td>' +
                '<span class="action-btn">' +
                    '<a href="'+editUrl(promo.id)+'"><i class="mdi mdi-lead-pencil" title="Edit"></i></a> ' +
                    '<a id="'+promo.id+'" name="promotion-delete" class="delete-btn" href="javascript:void(0)"><i class="mdi mdi-delete" title="Delete"></i></a>' +
                '</span>' +
            '</td>' +
            '</tr>';
    });
    $('#promotion-table-body').html(tbody);
    $('.promotion_count').text(promotions.length);
}

function editUrl(id) {
    return '{{ route('promotions.edit', ['id' => 'PROMOID']) }}'.replace('PROMOID', id);
}

function loadPromotions() {
    jQuery('#data-table_processing').show();
    fetchVendorsAndProducts().then(function() {
        promotionsRef.get().then(function(snapshot) {
            var promotions = [];
            snapshot.forEach(function(doc) {
                var data = doc.data();
                data.id = doc.id;
                promotions.push(data);
            });
            renderTable(promotions);
            jQuery('#data-table_processing').hide();
            $('#promotionsTable').DataTable({
                destroy: true,
                pageLength: 10,
                responsive: true,
                searching: true,
                ordering: true,
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [0, 9, 10] }
                ],
                "language": {
                    "zeroRecords": "No records found",
                    "emptyTable": "No records found",
                    "processing": ""
                }
            });
        });
    });
}

$(document).ready(function() {
    loadPromotions();
    
    // Select all checkboxes
    $("#is_active").click(function () {
        $("#promotionsTable .is_open").prop('checked', $(this).prop('checked'));
    });
    
    // Delete selected
    $("#deleteAll").click(function () {
        if ($('#promotionsTable .is_open:checked').length) {
            if (confirm("Are you sure you want to delete selected promotions?")) {
                jQuery("#data-table_processing").show();
                $('#promotionsTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    promotionsRef.doc(dataId).delete().then(function() {
                        loadPromotions();
                        jQuery("#data-table_processing").hide();
                    });
                });
            }
        } else {
            alert("Please select promotions to delete");
        }
    });
    
    // Single delete
    $(document).on("click", "a[name='promotion-delete']", function() {
        var id = this.id;
        if (confirm('Are you sure you want to delete this promotion?')) {
            jQuery('#data-table_processing').show();
            promotionsRef.doc(id).delete().then(function() {
                loadPromotions();
                jQuery('#data-table_processing').hide();
            });
        }
    });
    
    // Toggle isAvailable
    $(document).on("click", "input[name='isAvailable']", function(e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('promotions').doc(id).update({'isAvailable': true}).then(function(result) {
            });
        } else {
            database.collection('promotions').doc(id).update({'isAvailable': false}).then(function(result) {
            });
        }
    });
});
</script>
@endsection
