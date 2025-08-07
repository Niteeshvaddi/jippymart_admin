@extends('layouts.app') 
@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Create Promotion</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('promotions') !!}">Promotions</a></li>
                    <li class="breadcrumb-item active">Create Promotion</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="cat-edite-page max-width-box">
                <div class="card pb-4">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li role="presentation" class="nav-item">
                                <a href="#promotion_information" aria-controls="description" role="tab" data-toggle="tab"
                                   class="nav-link active">Promotion Information</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="error_top" style="display:none"></div>
                        <div class="row restaurant_payout_create" role="tabpanel">
                            <div class="restaurant_payout_create-inner tab-content">
                                <div role="tabpanel" class="tab-pane active" id="promotion_information">
                                    <fieldset>
                                        <legend>Create Promotion</legend>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">Restaurant</label>
                                            <div class="col-7">
                                                <select id="promotion_restaurant" class="form-control"></select>
                                                <div class="form-text text-muted">Select the restaurant for this promotion.</div>
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">Product</label>
                                            <div class="col-7">
                                                <select id="promotion_product" class="form-control"></select>
                                                <div class="form-text text-muted">
                                                    Select the product for this promotion (filtered by restaurant).
                                                    <span id="actual_price_display" class="text-warning" style="display: none;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">Special Price</label>
                                            <div class="col-7">
                                                <input type="number" class="form-control" id="promotion_special_price" min="0">
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">Extra KM Charge</label>
                                            <div class="col-7">
                                                <input type="number" class="form-control" id="promotion_extra_km_charge" min="0">
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">Free Delivery KM</label>
                                            <div class="col-7">
                                                <input type="number" class="form-control" id="promotion_free_delivery_km" min="0">
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">Start Time</label>
                                            <div class="col-7">
                                                <input type="datetime-local" class="form-control" id="promotion_start_time">
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">End Time</label>
                                            <div class="col-7">
                                                <input type="datetime-local" class="form-control" id="promotion_end_time">
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">Payment Mode</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control" value="prepaid" id="promotion_payment_mode" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row width-100">
                                            <div class="col-7 offset-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="promotion_is_available" checked>
                                                    <label class="form-check-label" for="promotion_is_available">
                                                        Available
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 text-center btm-btn">
                        <button type="button" class="btn btn-primary save-promotion-btn"><i class="fa fa-save"></i>
                            Save
                        </button>
                        <a href="{!! route('promotions') !!}" class="btn btn-default"><i class="fa fa-undo"></i>Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
var database = firebase.firestore();
var restaurantSelect = $('#promotion_restaurant');
var productSelect = $('#promotion_product');
var restaurantList = [];
var productList = [];

function populateRestaurants() {
    restaurantSelect.empty();
    restaurantSelect.append('<option value="">Select Restaurant</option>');
    database.collection('vendors').orderBy('title').get().then(function(snapshot) {
        snapshot.forEach(function(doc) {
            var data = doc.data();
            restaurantList.push(data);
            restaurantSelect.append('<option value="' + data.id + '">' + data.title + '</option>');
        });
    });
}

function populateProducts(restaurantId) {
    productSelect.empty();
    productSelect.append('<option value="">Select Product</option>');
    $('#actual_price_display').hide();
    if (!restaurantId) return;
    database.collection('vendor_products').where('vendorID', '==', restaurantId).get().then(function(snapshot) {
        snapshot.forEach(function(doc) {
            var data = doc.data();
            var displayPrice = data.disPrice && data.disPrice > 0 ? data.disPrice : (data.price || 0);
            productSelect.append('<option value="' + data.id + '" data-price="' + displayPrice + '">' + data.name + '</option>');
        });
    });
}

$(document).ready(function () {
    populateRestaurants();
    restaurantSelect.on('change', function() {
        var restId = $(this).val();
        populateProducts(restId);
    });
    
    productSelect.on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var price = selectedOption.data('price');
        if (price && price > 0) {
            $('#actual_price_display').show().text('Actual price: ₹' + price);
        } else {
            $('#actual_price_display').hide();
        }
    });
    $('.save-promotion-btn').click(async function () {
        var restaurant_id = restaurantSelect.val();
        var product_id = productSelect.val();
        var special_price = parseFloat($('#promotion_special_price').val()) || 0;
        var extra_km_charge = parseFloat($('#promotion_extra_km_charge').val()) || 0;
        var free_delivery_km = parseFloat($('#promotion_free_delivery_km').val()) || 0;
        var start_time = $('#promotion_start_time').val();
        var end_time = $('#promotion_end_time').val();
        var payment_mode = 'prepaid';
        var isAvailable = $('#promotion_is_available').is(':checked');
        if (!restaurant_id || !product_id || !start_time || !end_time) {
            $('.error_top').show().html('<p>Please fill all required fields.</p>');
            window.scrollTo(0, 0);
            return;
        }
        $('.error_top').hide();
        jQuery('#data-table_processing').show();
        await database.collection('promotions').add({
            restaurant_id,
            product_id,
            special_price,
            extra_km_charge,
            free_delivery_km,
            start_time: new Date(start_time),
            end_time: new Date(end_time),
            payment_mode,
            isAvailable
        }).then(function () {
            jQuery('#data-table_processing').hide();
            window.location.href = '{!! route('promotions') !!}';
        }).catch(function (error) {
            jQuery('#data-table_processing').hide();
            $('.error_top').show().html('<p>' + error + '</p>');
            window.scrollTo(0, 0);
        });
    });
});
</script>
@endsection