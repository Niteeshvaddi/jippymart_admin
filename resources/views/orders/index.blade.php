@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.order_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.order_table')}}</li>
            </ol>
        </div>
        <div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="admin-top-section">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex top-title-section pb-4 justify-content-between">
                        <div class="d-flex top-title-left align-self-center">
                            <span class="icon mr-3"><img src="{{ asset('images/order.png') }}"></span>
                            <h3 class="mb-0">{{trans('lang.order_plural')}}</h3>
                            <span class="counter ml-3 order_count"></span>
                        </div>
                        <div class="d-flex top-title-right align-self-center">
                            <div class="d-flex top-title-right align-self-center">
                                <div class="select-box pl-3">
                                    <select class="form-control zone_selector filteredRecords">
                                        <option value="" selected>{{trans("lang.select_zone")}}</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3">
                                    <select class="form-control status_selector filteredRecords">
                                        <option value="" selected>{{trans("lang.status")}}</option>
                                        <option value="All">{{trans("lang.all_status")}}</option>
                                        <option value="Order Placed">{{trans("lang.order_placed")}}</option>
                                        <option value="Order Accepted">{{trans("lang.order_accepted")}}</option>
                                        <option value="Order Rejected">{{trans("lang.order_rejected")}}</option>
                                        <option value="Driver Pending">{{trans("lang.driver_pending")}}</option>
                                        <option value="Driver Rejected">{{trans("lang.driver_rejected")}}</option>
                                        <option value="Order Shipped">{{trans("lang.order_shipped")}}</option>
                                        <option value="In Transit">{{trans("lang.in_transit")}}</option>
                                        <option value="Order Completed">{{trans("lang.order_completed")}}</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3">
                                    <select class="form-control order_type_selector filteredRecords">
                                        <option value="" selected>{{trans("lang.order_type")}}</option>
                                        <option value="takeaway">{{trans("lang.order_takeaway")}}</option>
                                        <option value="delivery">{{trans("lang.delivery")}}</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3">
                                    <div id="daterange"><i class="fa fa-calendar"></i>&nbsp;
                                        <span></span>&nbsp; <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-list">
            <div class="row">
                <div class="col-12">
                    <div class="menu-tab d-none vendorMenuTab">
                        <ul>
                            <li>
                                <a href="{{route('restaurants.view', $id)}}">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li>
                                <a href="{{route('restaurants.foods', $id)}}">{{trans('lang.tab_foods')}}</a>
                            </li>
                            <li class="active">
                                <a href="{{route('restaurants.orders', $id)}}">{{trans('lang.tab_orders')}}</a>
                            </li>
                            <li>
                                <a href="{{route('restaurants.coupons', $id)}}">{{trans('lang.tab_promos')}}</a>
                            </li>
                            <li>
                                <a href="{{route('restaurants.payout', $id)}}">{{trans('lang.tab_payouts')}}</a>
                            </li>
                            <li>
                                <a
                                    href="{{route('payoutRequests.restaurants.view', $id)}}">{{trans('lang.tab_payout_request')}}</a>
                            </li>
                            <li>
                                <a href="{{route('restaurants.booktable', $id)}}">{{trans('lang.dine_in_future')}}</a>
                            </li>
                            <li id="restaurant_wallet"></li>
                            <li id="subscription_plan"></li>
                        </ul>
                    </div>
                    @if(request()->has('driverId'))
                        <div class="menu-tab d-none driverMenuTab">
                            <ul>
                                <li>
                                    <a
                                        href="{{route('drivers.view', request()->query('driverId'))}}">{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li class="active">
                                    <a
                                        href="{{route('orders')}}?driverId={{request()->query('driverId')}}">{{trans('lang.tab_orders')}}</a>
                                </li>
                                <li>
                                    <a
                                        href="{{route('driver.payout', request()->query('driverId'))}}">{{trans('lang.tab_payouts')}}</a>
                                </li>
                                <li>
                                    <a
                                        href="{{route('payoutRequests.drivers.view', request()->query('driverId'))}}">{{trans('lang.tab_payout_request')}}</a>
                                </li>
                                <li>
                                    <a
                                        href="{{route('users.walletstransaction', request()->query('driverId'))}}">{{trans('lang.wallet_transaction')}}</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                    @if(request()->has('userId'))
                        <div class="menu-tab d-none userMenuTab">
                            <ul>
                                <li>
                                    <a
                                        href="{{ route('users.view', request()->query('userId')) }}">{{ trans('lang.tab_basic') }}</a>
                                </li>
                                <li class="active">
                                    <a
                                        href="{{route('orders', 'userId='.request()->query('userId'))}}">{{trans('lang.tab_orders')}}</a>
                                </li>
                                <li>
                                    <a
                                        href="{{route('users.walletstransaction', request()->query('userId'))}}">{{trans('lang.wallet_transaction')}}</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                    <div class="card border">
                        <div class="card-header d-flex justify-content-between align-items-center border-0">
                            <div class="card-header-title">
                                <h3 class="text-dark-2 mb-2 h4">{{trans('lang.order_table')}}</h3>
                                <p class="mb-0 text-dark-2">{{trans('lang.order_table_text')}}</p>
                            </div>
                            <div class="card-header-right d-flex align-items-center">
                                <div class="card-header-btn mr-3">
                                    <!-- <a class="btn-primary btn rounded-full" href="{!! route('users.create') !!}"><i class="mdi mdi-plus mr-2"></i>{{trans('lang.user_create')}}</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive m-t-10">
                                <table id="orderTable"
                                    class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <?php if (in_array('orders.delete', json_decode(@session('user_permissions'), true))) { ?>
                                            <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                    class="col-3 control-label" for="is_active">
                                                    <a id="deleteAll" class="do_not_delete" href="javascript:void(0)">
                                                        <i class="mdi mdi-delete"></i> {{trans('lang.all')}}</a></label>
                                            </th>
                                            <?php } ?>
                                            <th>{{trans('lang.order_id')}}</th>
                                            @if ($id == '')
                                                <th>{{trans('lang.restaurant')}}</th>
                                            @endif
                                            @if (isset($_GET['userId']))
                                                <th class="driverClass">{{trans('lang.driver_plural')}}</th>
                                            @elseif (isset($_GET['driverId']))
                                                <th>{{trans('lang.order_user_id')}}</th>
                                            @else
                                                <th class="driverClass">{{trans('lang.driver_plural')}}</th>
                                                <th>{{trans('lang.order_user_id')}}</th>
                                            @endif
                                            <th>{{trans('lang.date')}}</th>
                                            <th>{{trans('lang.restaurants_payout_amount')}}</th>
                                            <th>{{trans('lang.order_type')}}</th>
                                            <th>{{trans('lang.order_order_status_id')}}</th>
                                            <th>{{trans('lang.actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="append_list1">
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

<!-- Quick Driver Assignment Modal -->
<div class="modal fade" id="quickDriverAssignmentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('lang.assign_driver') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="quick_driver_selector">{{ trans('lang.select_driver') }}</label>
                        <select id="quick_driver_selector" class="form-control">
                            <option value="">{{ trans('lang.select_driver') }}</option>
                        </select>
                        <div class="form-text text-muted">
                            {{ trans('lang.manual_driver_assignment_help') }}
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.cancel') }}</button>
                <button type="button" class="btn btn-success" id="quick_assign_driver_btn">
                    <i class="fa fa-user-plus"></i> {{ trans('lang.assign_driver') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    var database=firebase.firestore();
    console.log('=== FIREBASE CONNECTION TEST ===');
    console.log('Firebase Firestore instance:', database);
    console.log('Firebase app:', firebase.app());
    
    var vendor_id='<?php echo $id; ?>';
    var append_list='';
    var redData=ref;
    var currentCurrency='';
    var currencyAtRight=false;
    var decimal_degits=0;
    var refCurrency=database.collection('currencies').where('isActive','==',true);
    refCurrency.get().then(async function(snapshots) {
        var currencyData=snapshots.docs[0].data();
        currentCurrency=currencyData.symbol;
        currencyAtRight=currencyData.symbolAtRight;
        if(currencyData.decimal_degits) {
            decimal_degits=currencyData.decimal_degits;
        }
    });
    var user_permissions='<?php echo @session("user_permissions") ?>';
    user_permissions=Object.values(JSON.parse(user_permissions));
    var checkDeletePermission=false;
    if($.inArray('orders.delete',user_permissions)>=0) {
        checkDeletePermission=true;
    }
    var order_status=jQuery('#order_status').val();
    var search=jQuery("#search").val();
    var refData=database.collection('restaurant_orders');
    var ref='';
    
    console.log('=== VARIABLE INITIALIZATION DEBUG ===');
    console.log('order_status:', order_status);
    console.log('search:', search);
    console.log('refData:', refData);
    console.log('Initial ref:', ref);
    $(document.body).on('change','#order_status',function() {
        order_status=jQuery(this).val();
        console.log('order_status changed to:', order_status);
    });
    $(document.body).on('keyup','#search',function() {
        search=jQuery(this).val();
        console.log('search changed to:', search);
    });
    var getId='<?php echo $id; ?>';
    var userID='<?php if (isset($_GET['userId'])) {
    echo $_GET['userId'];
} else {
    echo '';
} ?>';
    var driverID='<?php if (isset($_GET['driverId'])) {
    echo $_GET['driverId'];
} else {
    echo '';
} ?>';
    var orderStatus='<?php if (isset($_GET['status'])) {
    echo $_GET['status'];
} else {
    echo '';
} ?>';
    
    console.log('=== URL PARAMETERS DEBUG ===');
    console.log('getId:', getId);
    console.log('userID:', userID);
    console.log('driverID:', driverID);
    console.log('orderStatus:', orderStatus);
    if(userID) {
        const getUserName=getUserNameFunction(userID);
        $('.userMenuTab').removeClass('d-none');
        if(search!='') {
            ref=refData.where('authorID','==',userID);
        } else {
            ref=refData.orderBy('createdAt','desc').where('authorID','==',userID);
        }
    } else if(driverID) {
        const getUserName=getUserNameFunction(driverID);
        $('.driverMenuTab').removeClass('d-none');
        if(search!='') {
            ref=refData.where('driverID','==',driverID);
        } else {
            ref=refData.orderBy('createdAt','desc').where('driverID','==',driverID);
        }
    } else if(orderStatus) {
        if(orderStatus=='order-placed') {
            ref=refData.orderBy('createdAt','desc').where('status','==','Order Placed');
        }
        else if(orderStatus=='order-confirmed') {
            ref=refData.orderBy('createdAt','desc').where('status','in',['Order Accepted','Driver Accepted']);
        }
        else if(orderStatus=='order-shipped') {
            ref=refData.orderBy('createdAt','desc').where('status','in',['Order Shipped','In Transit']);
        }
        else if(orderStatus=='order-completed') {
            ref=refData.orderBy('createdAt','desc').where('status','==','Order Completed');
        }
        else if(orderStatus=='order-canceled') {
            ref=refData.orderBy('createdAt','desc').where('status','==','Order Rejected');
        }
        else if(orderStatus=='order-failed') {
            ref=refData.orderBy('createdAt','desc').where('status','==','Driver Rejected');
        }
        else if(orderStatus=='order-pending') {
            ref=refData.orderBy('createdAt','desc').where('status','==','Driver Pending');
        } else {
            ref=refData.orderBy('createdAt','desc');
        }
    }
    else if(getId!='') {
        $('.vendorMenuTab').removeClass('d-none');
        database.collection('vendors').where("id","==",getId).get().then(async function(snapshots) {
            var vendorData=snapshots.docs[0].data();
            walletRoute="{{route('users.walletstransaction', ':id')}}";
            walletRoute=walletRoute.replace(":id",vendorData.author);
            $('#restaurant_wallet').append('<a href="'+walletRoute+'">{{trans("lang.wallet_transaction")}}</a>');
            $('#subscription_plan').append('<a href="'+"{{route('vendor.subscriptionPlanHistory', ':id')}}".replace(':id',vendorData.author)+'">'+'{{trans('lang.subscription_history')}}'+'</a>');
        });
        const getStoreName=getStoreNameFunction(getId);
        if(search!='') {
            ref=refData.where('vendorID','==',getId);
        } else {
            ref=refData.orderBy('createdAt','desc').where('vendorID','==',getId);
        }
    } else {
        console.log('=== INITIAL REF SETUP DEBUG ===');
        console.log('No specific filters - setting up default reference');
        console.log('order_status:', order_status);
        console.log('search:', search);
        console.log('refData:', refData);
        
        if(search!='') {
            ref=refData;
            console.log('Setting ref to refData (no ordering) - search present');
        } else {
            ref=refData.orderBy('createdAt','desc');
            console.log('Setting ref to refData.orderBy(createdAt,desc) - no search');
        }
        console.log('Final initial ref:', ref);
    }
    database.collection('zone').where('publish','==',true).orderBy('name','asc').get().then(async function(snapshots) {
        console.log('Loading zones for orders:', snapshots.docs.length);
        snapshots.docs.forEach((listval) => {
            var data=listval.data();
            console.log('Zone found for orders:', data.name, 'ID:', data.id);
            $('.zone_selector').append($("<option></option>")
                .attr("value",data.id)
                .text(data.name));
        });
        
        // Enable the zone selector after zones are loaded
        $('.zone_selector').prop('disabled', false);
    }).catch(function(error) {
        console.error('Error loading zones for orders:', error);
    });
    $('.status_selector').select2({
        placeholder: '{{trans("lang.status")}}',  
        minimumResultsForSearch: Infinity,
        allowClear: true 
    });
    $('.zone_selector').select2({
        placeholder: '{{trans("lang.select_zone")}}',  
        minimumResultsForSearch: Infinity,
        allowClear: true 
    });
    $('.order_type_selector').select2({
        placeholder: '{{trans("lang.order_type")}}',  
        minimumResultsForSearch: Infinity,
        allowClear: true 
    });
    $('select').on("select2:unselecting", function(e) {
        var self = $(this);
        setTimeout(function() {
            self.select2('close');
        }, 0);
    });
    function setDate() {
        $('#daterange span').html('{{trans("lang.select_range")}}');
        $('#daterange').daterangepicker({
            autoUpdateInput: false, 
        }, function (start, end) {
            $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.filteredRecords').trigger('change'); 
        });
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            $('#daterange span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
            $('.filteredRecords').trigger('change');
        });
        $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
            $('#daterange span').html('{{trans("lang.select_range")}}');
            $('.filteredRecords').trigger('change'); 
        });
    }
    setDate(); 
    var initialRef=ref;
    
    // Store the original reference for filtering
    console.log('=== INITIAL REF SETUP ===');
    console.log('Initial Ref stored:', initialRef);
    $('.filteredRecords').change(async function() {
        var status=$('.status_selector').val();
        var zoneValue=$('.zone_selector').val();
        var orderType=$('.order_type_selector').val();
        var daterangepicker = $('#daterange').data('daterangepicker');
        
        // Reset refData to base collection or use current ref
        var refData = initialRef || ref || database.collection('restaurant_orders');
        
        console.log('=== FILTER CHANGE DEBUG ===');
        console.log('Selected Status:', status);
        console.log('Selected Zone:', zoneValue);
        console.log('Selected Order Type:', orderType);
        console.log('Initial Ref:', initialRef);
        console.log('Current Ref:', ref);
        
        // Apply zone filter - we need to filter by restaurant zoneId since orders don't have zoneId
        if(zoneValue && zoneValue !== '') {
            console.log('Filtering by zone:', zoneValue);
            // Since orders don't have zoneId, we need to filter by restaurant zoneId
            // We'll do this by getting all restaurants in the zone first, then filtering orders
            console.log('Zone filtering will be applied after fetching orders (since orders don\'t have zoneId)');
            // Store the zone filter for later use
            window.currentZoneFilter = zoneValue;
        } else {
            console.log('No zone filter applied');
            window.currentZoneFilter = null;
        }
        if(status && status !== 'All') {
            refData=refData.where('status','==',status);
            console.log('Applied Status Filter:', status);
        } else if(status === 'All') {
            console.log('All Status Selected - No Status Filter Applied');
        } else {
            console.log('No Status Selected - No Status Filter Applied');
        }
        if(orderType) {
            refData=(orderType=='takeaway')? refData.where('takeAway','==',true):refData.where('takeAway','==',false);
            console.log('Applied Order Type Filter:', orderType);
        }
        if ($('#daterange span').html() != '{{trans("lang.select_range")}}' && daterangepicker) {
            var from = moment(daterangepicker.startDate).toDate();
            var to = moment(daterangepicker.endDate).toDate();
            if (from && to) { 
                var fromDate = firebase.firestore.Timestamp.fromDate(new Date(from));
                refData = refData.where('createdAt', '>=', fromDate);
                var toDate = firebase.firestore.Timestamp.fromDate(new Date(to));
                refData =refData.where('createdAt', '<=', toDate);
                console.log('Applied Date Range Filter:', from, 'to', to);
            }
        }
        ref=refData;
        console.log('Final Ref for DataTable:', ref);
        $('#orderTable').DataTable().ajax.reload();
    });
    $(document).ready(function() {
        console.log('=== PAGE LOAD DEBUG ===');
        console.log('Document Ready - Initializing DataTable');
        console.log('Initial Ref:', ref);
        console.log('Vendor ID:', vendor_id);
        console.log('User ID:', userID);
        console.log('Driver ID:', driverID);
        console.log('Order Status:', orderStatus);
        
        // Test if there are any orders in the database at all
        database.collection('restaurant_orders').limit(1).get().then(function(snapshot) {
            console.log('=== DATABASE TEST ===');
            console.log('Total orders in database:', snapshot.size);
            console.log('Any orders exist:', !snapshot.empty);
            if (!snapshot.empty) {
                console.log('Sample order data:', snapshot.docs[0].data());
            }
        }).catch(function(error) {
            console.error('Error testing database:', error);
        });
        
        jQuery('#search').hide();
        $(document.body).on('click','.redirecttopage',function() {
            var url=$(this).attr('data-url');
            window.location.href=url;
        });
        jQuery("#data-table_processing").show();
        $(document).on('click', '.dt-button-collection .dt-button', function () {
            $('.dt-button-collection').hide();
            $('.dt-button-background').hide();
        });
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.dt-button-collection, .dt-buttons').length) {
                $('.dt-button-collection').hide();
                $('.dt-button-background').hide();
            }
        });
        var fieldConfig = {
            columns: [
                { key: 'id', header: "{{trans('lang.order_id')}}" },
                { key: 'driverName', header: "{{trans('lang.driver_plural')}}" },
                { key: 'client', header: "{{trans('lang.order_user_id')}}" },
                { key: 'status', header: "{{trans('lang.order_order_status_id')}}" },
                { key: 'orderType', header: "{{trans('lang.order_type')}}" },
                { key: 'amount', header: "{{trans('lang.amount')}}" },
                { key: 'createdAt', header: "{{trans('lang.created_at')}}" },
            ],
            fileName: "{{trans('lang.order_table')}}",
        };
        const table=$('#orderTable').DataTable({
            pageLength: 10, // Number of rows per page
            processing: false, // Show processing indicator
            serverSide: true, // Enable server-side processing
            responsive: true,
            ajax: async function(data,callback,settings) {
                console.log('=== DATATABLE AJAX DEBUG ===');
                console.log('DataTable Ajax Called');
                console.log('Current Ref:', ref);
                console.log('Search Value:', data.search.value);
                console.log('Start:', data.start, 'Length:', data.length);
                
                const start=data.start;
                const length=data.length;
                const searchValue=data.search.value.toLowerCase();
                const orderColumnIndex=data.order[0].column;
                const orderDirection=data.order[0].dir;
                if(getId!='') {
                    var orderableColumns=(checkDeletePermission)? ['','id','driverName','client','createdAt','amount','orderType','status','']:['id','drivers','client','createdAt','amount','orderType','status','']; // Ensure this matches the actual column names
                } else if(driverID) {
                    var orderableColumns=(checkDeletePermission)? ['','id','restaurants','client','createdAt','amount','orderType','status','']:['id','restaurants','client','createdAt','amount','orderType','status','']; // Ensure this matches the actual column names
                } else if(userID) {
                    var orderableColumns=(checkDeletePermission)? ['','id','restaurants','driverName','createdAt','amount','orderType','status','']:['id','restaurants','driver','createdAt','amount','orderType','status','']; // Ensure this matches the actual column names
                } else {
                    var orderableColumns=(checkDeletePermission)? ['','id','restaurants','driverName','client','createdAt','amount','orderType','status','']:['id','restaurants','driver','client','createdAt','amount','orderType','status','']; // Ensure this matches the actual column names
                }
                const orderByField=orderableColumns[orderColumnIndex]; // Adjust the index to match your table
                if(searchValue.length>=3||searchValue.length===0) {
                    $('#data-table_processing').show();
                }
                console.log('About to fetch data from Firestore with ref:', ref);
                console.log('Current refData for orders:', ref);
                await ref.get().then(async function(querySnapshot) {
                    console.log('Firestore Query Result:');
                    console.log('Query Snapshot Size:', querySnapshot.size);
                    console.log('Query Snapshot Empty:', querySnapshot.empty);
                    console.log('Query Snapshot Docs:', querySnapshot.docs.length);
                    
                    if(querySnapshot.empty) {
                        $('.order_count').text(0);
                        console.error("No data found in Firestore.");
                        console.log('Returning empty result to DataTable');
                        $('#data-table_processing').hide(); // Hide loader
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            filteredData: [],
                            data: [] // No data
                        });
                        return;
                    }
                    let records=[];
                    let filteredRecords=[];
                    console.log('Processing', querySnapshot.docs.length, 'documents from Firestore');
                    
                    await Promise.all(querySnapshot.docs.map(async (doc) => {
                        let childData=doc.data();
                        console.log('Order data:', childData.id, 'zoneId:', childData.zoneId);
                        
                        // Check if we need to filter by zone (since orders don't have zoneId)
                        if (window.currentZoneFilter) {
                            // Get restaurant zoneId to check if it matches the selected zone
                            let restaurantZoneId = null;
                            if (childData.vendor && childData.vendor.zoneId) {
                                restaurantZoneId = childData.vendor.zoneId;
                            } else if (childData.vendorID) {
                                // Fetch restaurant data to get zoneId
                                try {
                                    const restaurantDoc = await database.collection('vendors').doc(childData.vendorID).get();
                                    if (restaurantDoc.exists) {
                                        restaurantZoneId = restaurantDoc.data().zoneId;
                                    }
                                } catch (error) {
                                    console.error('Error fetching restaurant zone:', error);
                                }
                            }
                            
                            // Skip this order if it doesn't belong to the selected zone
                            if (restaurantZoneId !== window.currentZoneFilter) {
                                console.log('Skipping order', childData.id, 'from zone', restaurantZoneId, 'not matching', window.currentZoneFilter);
                                return; // Skip this order
                            }
                            console.log('Order', childData.id, 'matches zone filter');
                        }
                        
                        // Add null checks for vendor data and ensure vendor type is available
                        if(childData.hasOwnProperty('vendor') && childData.vendor && childData.vendor.title) {
                            childData.restaurants = childData.vendor.title;
                            // Ensure vendor type is available for routing
                            if (!childData.vendor.hasOwnProperty('vType') && childData.vendorID) {
                                try {
                                    const vendorDoc = await database.collection('vendors').doc(childData.vendorID).get();
                                    if (vendorDoc.exists) {
                                        const vendorData = vendorDoc.data();
                                        childData.vendor.vType = vendorData.vType || 'restaurant'; // Default to restaurant if not specified
                                        console.log('Loaded vendor type for order', childData.id, ':', childData.vendor.vType);
                                    }
                                } catch (error) {
                                    console.error('Error loading vendor type for order', childData.id, ':', error);
                                    childData.vendor.vType = 'restaurant'; // Default fallback
                                }
                            }
                        } else {
                            childData.restaurants = 'N/A'; // Default value if vendor data is missing
                            console.log('Warning: Missing vendor data for order:', doc.id);
                        }
                        
                        childData.driverName='';
                        if(childData.hasOwnProperty('driver')&&childData.driver!=null&&childData.driver!='') {
                            childData.driverName=childData.driver.firstName+' '+childData.driver.lastName;
                        }
                        
                        // Add null checks for author data
                        if(childData.hasOwnProperty('author') && childData.author && childData.author.firstName && childData.author.lastName) {
                            childData.client=childData.author.firstName+' '+childData.author.lastName;
                        } else {
                            childData.client = 'N/A'; // Default value if author data is missing
                            console.log('Warning: Missing author data for order:', doc.id);
                        }
                        if(childData.hasOwnProperty('takeAway')&&childData.takeAway) {
                            childData.orderType="{{trans('lang.order_takeaway')}}"
                        } else {
                            childData.orderType="{{trans('lang.order_delivery')}}";
                        }
                        
                        // --- OPTIMIZED AMOUNT ASSIGNMENT - Use order.toPayAmount if available ---
                        childData.amount = '';
                        try {
                            // First try to use toPayAmount from order data (faster)
                            if (childData.toPayAmount !== undefined && childData.toPayAmount !== null) {
                                let toPay = parseFloat(childData.toPayAmount);
                                if (!isNaN(toPay)) {
                                    if (currencyAtRight) {
                                        childData.amount = toPay.toFixed(decimal_degits) + currentCurrency;
                                    } else {
                                        childData.amount = currentCurrency + toPay.toFixed(decimal_degits);
                                    }
                                } else {
                                    childData.amount = await buildHTMLProductstotal(childData);
                                }
                            } else {
                                // Fallback to billing collection only if toPayAmount not available
                                const billingDoc = await database.collection('order_Billing').doc(childData.id).get();
                                if (billingDoc.exists && billingDoc.data().ToPay !== undefined) {
                                    let toPay = parseFloat(billingDoc.data().ToPay);
                                    if (!isNaN(toPay)) {
                                        if (currencyAtRight) {
                                            childData.amount = toPay.toFixed(decimal_degits) + currentCurrency;
                                        } else {
                                            childData.amount = currentCurrency + toPay.toFixed(decimal_degits);
                                        }
                                    } else {
                                        childData.amount = await buildHTMLProductstotal(childData);
                                    }
                                } else {
                                    childData.amount = await buildHTMLProductstotal(childData);
                                }
                            }
                        } catch (e) {
                            console.warn('Error getting order amount for', childData.id, e);
                            childData.amount = await buildHTMLProductstotal(childData);
                        }
                        
                        childData.id=doc.id; // Ensure the document ID is included in the data              
                        if(searchValue) {
                            var date='';
                            var time='';
                            if(childData.hasOwnProperty("createdAt")) {
                                try {
                                    date=childData.createdAt.toDate().toDateString();
                                    time=childData.createdAt.toDate().toLocaleTimeString('en-US');
                                } catch(err) {
                                }
                            }
                            var createdAt=date+' '+time;
                            if(
                                (childData.id&&childData.id.toLowerCase().toString().includes(searchValue))||
                                (childData.restaurants&&childData.restaurants.toLowerCase().toString().includes(searchValue))||
                                (createdAt&&createdAt.toString().toLowerCase().indexOf(searchValue)>-1)||
                                (childData.driverName&&childData.driverName.toLowerCase().toString().includes(searchValue))||
                                (childData.client&&childData.client.toLowerCase().toString().includes(searchValue))||
                                (childData.orderType&&childData.orderType.toLowerCase().toString().includes(searchValue))||
                                (childData.status&&childData.status.toLowerCase().toString().includes(searchValue))||
                                (childData.amount&&childData.amount.toString().includes(searchValue))
                            ) {
                                filteredRecords.push(childData);
                            }
                        } else {
                            filteredRecords.push(childData);
                        }
                    }));
                    filteredRecords.sort((a,b) => {
                        let aValue=a[orderByField]? a[orderByField].toString().toLowerCase():'';
                        let bValue=b[orderByField]? b[orderByField].toString().toLowerCase():'';
                        if(orderByField==='createdAt') {
                            try {
                                aValue=a[orderByField]? new Date(a[orderByField].toDate()).getTime():0;
                                bValue=b[orderByField]? new Date(b[orderByField].toDate()).getTime():0;
                            } catch(err) {
                            }
                        }
                        if(orderByField==='amount') {
                            aValue=a[orderByField].slice(1)? parseInt(a[orderByField].slice(1)):0;
                            bValue=b[orderByField].slice(1)? parseInt(b[orderByField].slice(1)):0;
                        }
                        if(orderDirection==='asc') {
                            return (aValue>bValue)? 1:-1;
                        } else {
                            return (aValue<bValue)? 1:-1;
                        }
                    });
                    const totalRecords=filteredRecords.length;
                    console.log('Total Records after filtering:', totalRecords);
                    console.log('Filtered Records:', filteredRecords);
                    $('.order_count').text(totalRecords);
                    const paginatedRecords=filteredRecords.slice(start,start+length);
                    await Promise.all(paginatedRecords.map(async (childData) => {
                        var getData=await buildHTML(childData);
                        records.push(getData);
                    }));
                    $('#data-table_processing').hide(); // Hide loader
                    callback({
                        draw: data.draw,
                        recordsTotal: totalRecords, // Total number of records in Firestore
                        recordsFiltered: totalRecords, // Number of records after filtering (if any)
                        filteredData: filteredRecords,
                        data: records // The actual data to display in the table
                    });
                }).catch(function(error) {
                    console.error("Error fetching data from Firestore:",error);
                    $('#data-table_processing').hide(); // Hide loader
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        filteredData: [],
                        data: [] // No data due to error
                    });
                });
            },
            order: (getId!=''||driverID||userID&&checkDeletePermission)? [[4,'desc']]:(getId!=''||driverID||userID)? ((checkDeletePermission)? [[4,'desc']]:[[3,'desc']]):((checkDeletePermission)? [[5,'desc']]:[[4,'desc']]),
            columnDefs: [
                {
                    targets: (getId!=''||driverID||userID&&checkDeletePermission)? 4:(getId!=''||driverID||userID)? ((checkDeletePermission)? 4:3):((checkDeletePermission)? 5:4),
                    type: 'date',
                    render: function(data) {
                        return data;
                    }
                },
                {orderable: false,targets: (getId!=''||driverID||userID&&checkDeletePermission)? [0,8]:(getId!=''||driverID||userID)? ((checkDeletePermission)? [0,8]:[7]):(checkDeletePermission)? [0,9]:[8]},
            ],
            "language": {
                "zeroRecords": "{{trans("lang.no_record_found")}}",
                "emptyTable": "{{trans("lang.no_record_found")}}",
                "processing": "" 
            },
            dom: 'lfrtipB',
            buttons: [
                {
                    extend: 'collection',
                    text: '<i class="mdi mdi-cloud-download"></i> Export as',
                    className: 'btn btn-info',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            action: function (e, dt, button, config) {
                                exportData(dt, 'excel',fieldConfig);
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'Export PDF',
                            action: function (e, dt, button, config) {
                                exportData(dt, 'pdf',fieldConfig);
                            }
                        },   
                        {
                            extend: 'csvHtml5',
                            text: 'Export CSV',
                            action: function (e, dt, button, config) {
                                exportData(dt, 'csv',fieldConfig);
                            }
                        }
                    ]
                }
            ],
            initComplete: function() {
                $(".dataTables_filter").append($(".dt-buttons").detach());
                $('.dataTables_filter input').attr('placeholder', 'Search here...').attr('autocomplete','new-password').val('');
                $('.dataTables_filter label').contents().filter(function() {
                    return this.nodeType === 3; 
                }).remove();
            }
        });
        function debounce(func,wait) {
            let timeout;
            const context=this;
            return function(...args) {
                clearTimeout(timeout);
                timeout=setTimeout(() => func.apply(context,args),wait);
            };
        }
        $('#search-input').on('input',debounce(function() {
            const searchValue=$(this).val();
            if(searchValue.length>=3) {
                $('#data-table_processing').show();
                table.search(searchValue).draw();
            } else if(searchValue.length===0) {
                $('#data-table_processing').show();
                table.search('').draw();
            }
        },300));
    });
    async function buildHTML(val) {
        var html=[];
        newdate='';
        var id=val.id;
        var vendorID=val.vendorID;
        var user_id=val.authorID;
        var route1='{{route("orders.edit", ":id")}}';
        route1=route1.replace(':id',id);
        var printRoute='{{route("vendors.orderprint", ":id")}}';
        printRoute=printRoute.replace(':id',id);
        <?php if ($id != '') { ?>
        route1=route1+'?eid={{$id}}';
        printRoute=printRoute+'?eid={{$id}}';
        <?php } ?>
        // Determine correct view route based on vendor type
        var route_view;
        console.log('Building route for order:', val.id, 'vendorID:', vendorID);
        console.log('Vendor data:', val.vendor);
        console.log('Vendor vType:', val.vendor ? val.vendor.vType : 'undefined');
        
        if(val.hasOwnProperty('vendor') && val.vendor.hasOwnProperty('vType') && val.vendor.vType === 'mart') {
            route_view='{{route("marts.view", ":id")}}';
            console.log('Using MART route for order:', val.id);
        } else {
            route_view='{{route("restaurants.view", ":id")}}';
            console.log('Using RESTAURANT route for order:', val.id);
        }
        route_view=route_view.replace(':id',vendorID);
        console.log('Final route:', route_view);
        var customer_view='{{route("users.view", ":id")}}';
        customer_view=customer_view.replace(':id',user_id);
        if(checkDeletePermission) {
            html.push('<td class="delete-all"><input type="checkbox" id="is_open_'+id+'" class="is_open" dataId="'+id+'"><label class="col-3 control-label"\n'+
                'for="is_open_'+id+'" ></label></td>');
        }
        html.push('<a href="'+route1+'" class="redirecttopage">'+val.id+'</a>');
        if(userID) {
            var title='';
            if(val.hasOwnProperty('vendor')&&val.vendor.title!=undefined) {
                title=val.vendor.title;
            }
            html.push('<a  href="'+route_view+'" >'+title+'</a>');
            if(val.hasOwnProperty("driver")&&val.driver!=null&&val.driver!='') {
                var driverId=val.driver.id;
                var diverRoute='{{route("drivers.view", ":id")}}';
                diverRoute=diverRoute.replace(':id',driverId);
                html.push('<a href="'+diverRoute+'" >'+val.driver.firstName+' '+val.driver.lastName+'</a>');
            } else {
                html.push('');
            }
        } else if(driverID) {
            if(val.hasOwnProperty("author")&&val.author!=null&&val.author!='') {
                var driverId=val.author.id;
                html.push('<a  href="'+customer_view+'" >'+val.author.firstName+' '+val.author.lastName+'</a>');
            } else {
                html.push('');
            }
            var title='';
            if(val.hasOwnProperty('vendor')&&val.vendor.title!=undefined) {
                title=val.vendor.title;
            }
            html.push('<a  href="'+route_view+'" >'+title+'</a>');
        } else if(getId!='') {
            if(val.hasOwnProperty("driver")&&val.driver!=null&&val.driver!='') {
                var driverId=val.driver.id;
                var diverRoute='{{route("drivers.view", ":id")}}';
                diverRoute=diverRoute.replace(':id',driverId);
                html.push('<a  href="'+diverRoute+'" >'+val.driver.firstName+' '+val.driver.lastName+'</a>');
            } else {
                html.push('');
            }
            if(val.hasOwnProperty("author")&&val.author!=null&&val.author!='') {
                var driverId=val.author.id;
                html.push('<a  href="'+customer_view+'">'+val.author.firstName+' '+val.author.lastName+'</a>');
            } else {
                html.push('');
            }
        } else {
            var title='';
            if(val.hasOwnProperty('vendor')&&val.vendor.title!=undefined&&val.vendor.title!='') {
                title=val.vendor.title;
            }
            html.push('<a  href="'+route_view+'" >'+title+'</a>');
            if(val.hasOwnProperty("driver")&&val.driver!=null&&val.driver!='') {
                var driverId=val.driver.id;
                var diverRoute='{{route("drivers.view", ":id")}}';
                diverRoute=diverRoute.replace(':id',driverId);
                html.push('<a  href="'+diverRoute+'">'+val.driver.firstName+' '+val.driver.lastName+'</a>');
            } else {
                html.push('');
            }
            if(val.hasOwnProperty("author")&&val.author!=null) {
                var driverId=val.author.id;
                html.push('<a  href="'+customer_view+'" class="redirecttopage">'+val.author.firstName+' '+val.author.lastName+'</a>');
            } else {
                html.push('');
            }
        }
        var date='';
        var time='';
        if(val.hasOwnProperty("createdAt")) {
            try {
                date=val.createdAt.toDate().toDateString();
                time=val.createdAt.toDate().toLocaleTimeString('en-US');
            } catch(err) {
            }
            html.push('<span class="dt-time">'+date+' '+time+'</span>');
        } else {
            html.push('');
        }
        html.push('<span class="text-green">'+val.amount+'</span>');
        if(val.hasOwnProperty('takeAway')&&val.takeAway) {
            html.push('{{trans("lang.order_takeaway")}}');
        } else {
            html.push('{{trans("lang.order_delivery")}}');
        }
        if(val.status=='Order Placed') {
            html.push('<span class="order_placed"><span>'+val.status+'</span></span>');
        } else if(val.status=='Order Accepted') {
            html.push('<span class="order_accepted"><span>'+val.status+'</span></span>');
        } else if(val.status=='Order Rejected') {
            html.push('<span class="order_rejected"><span>'+val.status+'</span></span>');
        } else if(val.status=='Driver Pending') {
            html.push('<span class="driver_pending"><span>'+val.status+'</span></span>');
        } else if(val.status=='Driver Rejected') {
            html.push('<span class="driver_rejected"><span>'+val.status+'</span></span>');
        } else if(val.status=='Order Shipped') {
            html.push('<span class="order_shipped"><span>'+val.status+'</span></span>');
        } else if(val.status=='In Transit') {
            html.push('<span class="in_transit"><span>'+val.status+'</span></span>');
        }
        else {
            html.push('<span class="order_completed"><span>'+val.status+'</span></span>');
        }
        var actionHtml='';
        actionHtml+='<span class="action-btn"><a href="'+printRoute+'"><i class="fa fa-print" style="font-size:20px;"></i></a><a href="'+route1+'"><i class="mdi mdi-lead-pencil" title="Edit"></i></a>';
        
        // Add manual driver assignment button for delivery orders without assigned drivers
        if(!val.takeAway && (!val.driver || !val.driver.id)) {
            actionHtml+='<a href="'+route1+'#manual_driver_assignment_section" title="Manual Assign Driver"><i class="fa fa-user-plus" style="color: #28a745;"></i></a>';
        }
        
        if(checkDeletePermission) {
            actionHtml+='<a id="'+val.id+'" class="delete-btn" name="order-delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a>';
        }
        actionHtml+='</span>';
        html.push(actionHtml);
        return html;
    }
    $("#is_active").click(function() {
        $("#orderTable .is_open").prop('checked',$(this).prop('checked'));
    });
    
    // Quick Driver Assignment Modal Functionality
    var currentOrderId = '';
    
    // Enhanced load available drivers for quick assignment
    async function loadQuickDrivers() {
        try {
            // Show loading state
            $('#quick_driver_selector').html('<option value="">{{ trans("lang.select_driver") }}</option><option value="" disabled>Loading drivers...</option>');
            
            // Call the Cloud Function to get available drivers
            const getDriversFunction = firebase.functions().httpsCallable('getAvailableDriversForOrder');
            const result = await getDriversFunction({
                orderId: currentOrderId || 'temp',
                zoneId: null // Get all drivers, can be filtered by zone later
            });
            
            if (result.data.success) {
                $('#quick_driver_selector').empty();
                $('#quick_driver_selector').append('<option value="">{{ trans("lang.select_driver") }}</option>');
                
                result.data.drivers.forEach((driverData) => {
                    var driverName = (driverData.firstName || '') + ' ' + (driverData.lastName || '');
                    var driverPhone = driverData.phoneNumber || '';
                    var walletAmount = driverData.wallet_amount || 0;
                    var isOnline = driverData.isOnline ? '🟢' : '🔴';
                    var displayText = `${isOnline} ${driverName} (${driverPhone}) - ₹${walletAmount}`;
                    
                    $('#quick_driver_selector').append($("<option></option>")
                        .attr("value", driverData.id)
                        .text(displayText));
                });
                
                console.log(`✅ Loaded ${result.data.total} available drivers for quick assignment`);
            } else {
                console.error('Failed to load drivers:', result.data);
                $('#quick_driver_selector').html('<option value="">{{ trans("lang.select_driver") }}</option><option value="" disabled>Error loading drivers</option>');
            }
            
        } catch (error) {
            console.error('Error loading available drivers:', error);
            $('#quick_driver_selector').html('<option value="">{{ trans("lang.select_driver") }}</option><option value="" disabled>Error loading drivers</option>');
            
            // Fallback to direct Firestore query
            try {
                const snapshots = await database.collection('users').where('role', '==', 'driver').where('isActive', '==', true).get();
                $('#quick_driver_selector').empty();
                $('#quick_driver_selector').append('<option value="">{{ trans("lang.select_driver") }}</option>');
                
                snapshots.docs.forEach((doc) => {
                    var driverData = doc.data();
                    var driverName = (driverData.firstName || '') + ' ' + (driverData.lastName || '');
                    var driverPhone = driverData.phoneNumber || '';
                    var displayText = driverName + ' (' + driverPhone + ')';
                    
                    $('#quick_driver_selector').append($("<option></option>")
                        .attr("value", driverData.id)
                        .text(displayText));
                });
            } catch (fallbackError) {
                console.error('Fallback driver loading also failed:', fallbackError);
            }
        }
    }
    
    // Handle quick driver assignment
    $('#quick_assign_driver_btn').click(async function() {
        var selectedDriverId = $('#quick_driver_selector').val();
        if (!selectedDriverId) {
            alert('{{ trans("lang.please_select_driver") }}');
            return;
        }
        
        if (confirm('{{ trans("lang.confirm_assign_driver") }}')) {
            await quickAssignDriverToOrder(currentOrderId, selectedDriverId);
        }
    });
    
    // Enhanced quick assign driver to order using Cloud Function
    async function quickAssignDriverToOrder(orderId, driverId) {
        try {
            // Show loading state
            $('#quick_assign_driver_btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Assigning...');
            
            // Call the Cloud Function for manual assignment
            const manualAssignFunction = firebase.functions().httpsCallable('manualAssignDriverToOrder');
            const result = await manualAssignFunction({
                orderId: orderId,
                driverId: driverId,
                assignedBy: '{{ auth()->user()->name ?? "Admin" }}',
                reason: 'Quick assignment from orders list'
            });
            
            if (result.data.success) {
                alert('{{ trans("lang.driver_assigned_successfully") }}');
                $('#quickDriverAssignmentModal').modal('hide');
                $('#orderTable').DataTable().ajax.reload();
            } else {
                alert('Failed to assign driver: ' + (result.data.message || 'Unknown error'));
            }
            
        } catch (error) {
            console.error('Error assigning driver:', error);
            
            // Handle specific error types
            let errorMessage = '{{ trans("lang.error_assigning_driver") }}';
            if (error.code === 'functions/unauthenticated') {
                errorMessage = 'Authentication required. Please log in again.';
            } else if (error.code === 'functions/not-found') {
                errorMessage = 'Order or driver not found.';
            } else if (error.code === 'functions/failed-precondition') {
                errorMessage = error.message || 'Order is not eligible for manual assignment.';
            } else if (error.code === 'functions/invalid-argument') {
                errorMessage = error.message || 'Invalid driver selected.';
            }
            
            alert(errorMessage);
        } finally {
            // Reset button state
            $('#quick_assign_driver_btn').prop('disabled', false).html('<i class="fa fa-user-plus"></i> {{ trans("lang.assign_driver") }}');
        }
    }
    
    // Initialize quick driver assignment
    loadQuickDrivers();
    
    // Test function to check zone data in orders
    window.testOrderZoneData = function() {
        console.log('Testing order zone data...');
        database.collection('restaurant_orders').limit(5).get().then(async function(snapshots) {
            console.log('Sample orders:');
            for (const doc of snapshots.docs) {
                const data = doc.data();
                let restaurantZoneId = 'N/A';
                
                if (data.vendor && data.vendor.zoneId) {
                    restaurantZoneId = data.vendor.zoneId;
                } else if (data.vendorID) {
                    try {
                        const restaurantDoc = await database.collection('vendors').doc(data.vendorID).get();
                        if (restaurantDoc.exists) {
                            restaurantZoneId = restaurantDoc.data().zoneId || 'No zoneId in restaurant';
                        }
                    } catch (error) {
                        restaurantZoneId = 'Error fetching restaurant';
                    }
                }
                
                console.log(`Order: ${data.id}, Order ZoneId: ${data.zoneId}, Restaurant ZoneId: ${restaurantZoneId}`);
            }
        });
    };
    
    // Test function to check if orders exist without filters
    window.testAllOrders = function() {
        console.log('Testing all orders...');
        database.collection('restaurant_orders').limit(10).get().then(function(snapshots) {
            console.log('Total orders found:', snapshots.docs.length);
            snapshots.docs.forEach(doc => {
                const data = doc.data();
                console.log(`Order: ${data.id}, Status: ${data.status}, ZoneId: ${data.zoneId}`);
            });
        });
    };
    
    // Handle quick assign button clicks
    $(document).on('click', 'a[href*="#manual_driver_assignment_section"]', function(e) {
        e.preventDefault();
        var orderId = $(this).closest('tr').find('a[href*="/orders/edit/"]').attr('href').split('/').pop();
        currentOrderId = orderId;
        $('#quickDriverAssignmentModal').modal('show');
    });
    $("#deleteAll").click(async function() {
        if($('#orderTable .is_open:checked').length) {
            if(confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                var selectedOrders = [];
                for (let i = 0; i < $('#orderTable .is_open:checked').length; i++) {
                    var dataId = $('#orderTable .is_open:checked').eq(i).attr('dataId');
                    try {
                        const orderDoc = await database.collection('restaurant_orders').doc(dataId).get();
                        if (orderDoc.exists) {
                            const orderData = orderDoc.data();
                            selectedOrders.push('Order #' + dataId + ' (Status: ' + (orderData.status || 'Unknown') + ')');
                        }
                    } catch (error) {
                        console.error('Error getting order info:', error);
                    }
                }
                $('#orderTable .is_open:checked').each(function() {
                    var dataId=$(this).attr('dataId');
                    database.collection('restaurant_orders').doc(dataId).delete();
                });
                console.log('✅ Bulk order deletion completed, now logging activity...');
                try {
                    if (typeof logActivity === 'function') {
                        await logActivity('orders', 'bulk_deleted', 'Bulk deleted orders: ' + selectedOrders.join(', '));
                    } else {
                        console.error('❌ logActivity function is not available');
                    }
                } catch (error) {
                    console.error('❌ Error calling logActivity:', error);
                }
                setTimeout(function() {
                    window.location.reload();
                },7000);
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });
    $(document).on("click","a[name='order-delete']",async function(e) {
        var id=this.id;
        var orderInfo = '';
        try {
            const orderDoc = await database.collection('restaurant_orders').doc(id).get();
            if (orderDoc.exists) {
                const orderData = orderDoc.data();
                orderInfo = 'Order #' + id + ' (Status: ' + (orderData.status || 'Unknown') + ')';
            }
        } catch (error) {
            console.error('Error getting order info:', error);
        }
        database.collection('restaurant_orders').doc(id).delete().then(async function(result) {
            console.log('✅ Order deleted successfully, now logging activity...');
            try {
                if (typeof logActivity === 'function') {
                    await logActivity('orders', 'deleted', 'Deleted ' + orderInfo);
                } else {
                    console.error('❌ logActivity function is not available');
                }
            } catch (error) {
                console.error('❌ Error calling logActivity:', error);
            }
            window.location.href='{{ url()->current() }}';
        });
    });
    async function getStoreNameFunction(vendorId) {
        var vendorName='';
        await database.collection('vendors').where('id','==',vendorId).get().then(async function(snapshots) {
            if(!snapshots.empty) {
                var vendorData=snapshots.docs[0].data();
                vendorName=vendorData.title;
                $('.orderTitle').html('{{trans("lang.order_plural")}} - '+vendorName);
                if(vendorData.dine_in_active==true) {
                    $(".dine_in_future").show();
                }
            }
        });
        return vendorName;
    }
    async function getUserNameFunction(userId) {
        var userName='';
        await database.collection('users').where('id','==',userId).get().then(async function(snapshots) {
            var user=snapshots.docs[0].data();
            userName=user.firstName+' '+user.lastName;
            $('.orderTitle').html('{{trans("lang.order_plural")}} - '+userName);
        });
        return userName;
    }
    function buildHTMLProductstotal(snapshotsProducts) {
        var adminCommission=snapshotsProducts.adminCommission;
        var adminCommissionType=snapshotsProducts.adminCommissionType;
        var discount=snapshotsProducts.discount;
        var couponCode=snapshotsProducts.couponCode;
        var extras=snapshotsProducts.extras;
        var extras_price=snapshotsProducts.extras_price;
        var rejectedByDrivers=snapshotsProducts.rejectedByDrivers;
        var takeAway=snapshotsProducts.takeAway;
        var tip_amount=snapshotsProducts.tip_amount;
        var status=snapshotsProducts.status;
        var products=snapshotsProducts.products;
        var deliveryCharge=snapshotsProducts.deliveryCharge;
        var totalProductPrice=0;
        var total_price=0;
        var specialDiscount=snapshotsProducts.specialDiscount;
        var intRegex=/^\d+$/;
        var floatRegex=/^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        if(products) {
            products.forEach((product) => {
                var val=product;
                var final_price='';
                if(val.discountPrice!=0&&val.discountPrice!=""&&val.discountPrice!=null&&!isNaN(val.discountPrice)) {
                    final_price=parseFloat(val.discountPrice);
                }
                else {
                    final_price=parseFloat(val.price);
                }
                if(final_price) {
                    price_item=parseFloat(final_price).toFixed(decimal_degits);
                    extras_price_item=0;
                    if(val.extras_price&&!isNaN(extras_price_item)&&!isNaN(val.quantity)) {
                        extras_price_item=(parseFloat(val.extras_price)*parseInt(val.quantity)).toFixed(decimal_degits);
                    }
                    if(!isNaN(price_item)&&!isNaN(val.quantity)) {
                        totalProductPrice=parseFloat(price_item)*parseInt(val.quantity);
                    }
                    var extras_price=0;
                    if(parseFloat(extras_price_item)!=NaN&&val.extras_price!=undefined) {
                        extras_price=extras_price_item;
                    }
                    totalProductPrice=parseFloat(extras_price)+parseFloat(totalProductPrice);
                    totalProductPrice=parseFloat(totalProductPrice).toFixed(decimal_degits);
                    if(!isNaN(totalProductPrice)) {
                        total_price+=parseFloat(totalProductPrice);
                    }
                }
            });
        }
        if(intRegex.test(discount)||floatRegex.test(discount)) {
            discount=parseFloat(discount).toFixed(decimal_degits);
            total_price-=parseFloat(discount);
            if(currencyAtRight) {
                discount_val=discount+""+currentCurrency;
            } else {
                discount_val=currentCurrency+""+discount;
            }
        }
        var special_discount=0;
        if(specialDiscount!=undefined) {
            special_discount=parseFloat(specialDiscount.special_discount).toFixed(decimal_degits);
            total_price=total_price-special_discount;
        }
        var total_item_price=total_price;
        var tax=0;
        taxlabel='';
        taxlabeltype='';
        if(snapshotsProducts.hasOwnProperty('taxSetting')&&snapshotsProducts.taxSetting.length>0) {
            var total_tax_amount=0;
            for(var i=0;i<snapshotsProducts.taxSetting.length;i++) {
                var data=snapshotsProducts.taxSetting[i];
                if(data.type&&data.tax) {
                    if(data.type=="percentage") {
                        tax=(data.tax*total_price)/100;
                        taxlabeltype="%";
                    } else {
                        tax=data.tax;
                        taxlabeltype="fix";
                    }
                    taxlabel=data.title;
                }
                total_tax_amount+=parseFloat(tax);
            }
            total_price=parseFloat(total_price)+parseFloat(total_tax_amount);
        }
        if((intRegex.test(deliveryCharge)||floatRegex.test(deliveryCharge))&&!isNaN(deliveryCharge)) {
            deliveryCharge=parseFloat(deliveryCharge).toFixed(decimal_degits);
            total_price+=parseFloat(deliveryCharge);
            if(currencyAtRight) {
                deliveryCharge_val=deliveryCharge+""+currentCurrency;
            } else {
                deliveryCharge_val=currentCurrency+""+deliveryCharge;
            }
        }
        if(intRegex.test(tip_amount)||floatRegex.test(tip_amount)&&!isNaN(tip_amount)) {
            tip_amount=parseFloat(tip_amount).toFixed(decimal_degits);
            total_price+=parseFloat(tip_amount);
            total_price=parseFloat(total_price).toFixed(decimal_degits);
        }
        if(currencyAtRight) {
            var total_price_val=parseFloat(total_price).toFixed(decimal_degits)+""+currentCurrency;
        } else {
            var total_price_val=currentCurrency+""+parseFloat(total_price).toFixed(decimal_degits);
        }
        return total_price_val;
    }
</script>
@endsection