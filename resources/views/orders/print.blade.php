@extends('layouts.app')
@section('content')
	<div class="page-wrapper">
    <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.print_order')}}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <?php if(isset($_GET['eid']) && $_GET['eid'] != ''){?>
                        <li class="breadcrumb-item"><a href= "{{route('restaurants.orders',$_GET['eid'])}}" >{{trans('lang.order_plural')}}</a></li>
                    <?php }else{ ?>
                        <li class="breadcrumb-item"><a href= "{!! route('orders') !!}" >{{trans('lang.order_plural')}}</a></li>
                    <?php } ?>
                    <li class="breadcrumb-item">{{trans('lang.print_order')}}</li>
                </ol>
            </div>
        </div>
<div class="container-fluid">        
<div class="card" id="printableArea" style="font-family: emoji;">
<div class="col-md-12">
<div class="print-top non-printable mt-3">
  <div class="text-right print-btn non-printable"><button type="button" class="fa fa-print non-printable" onclick="printDiv('printableArea')"></button></div> 
 </div>
<hr class="non-printable">
</div>
<div class="col-12">
<div class="text-center pt-4 mb-3">
<h2 style="line-height: 1"><label class="storeName"></label></h2>
<h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
<label class="storeAddress"></label>
</h5>
<h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
{{trans('lang.phone')}} :
<label class="storePhone"></label>
</h5>
</div>
<span class="dashed-line"></span>
<div class="row mt-3">
<div class="col-6">
<h5>{{trans('lang.order_id')}} : <label class="orderId"></label></h5>
</div>
<div class="col-6">
<h5 style="font-weight: lighter">
<label class="orderDate"></label>
</h5>
</div>
<div class="col-12">
<h5>
{{trans('lang.customer_name')}} :
<label class="customerName"></label> 
</h5>
<h5>
{{trans('lang.phone')}} :
<label class="customerPhone"></label> 
</h5>
<h5 class="text-break">
{{trans('lang.address')}} :
<label class="customerAddress"></label> 
</h5>
</div>
</div>
<h5 class="text-uppercase"></h5>
<span class="dashed-line"></span>
<table class="table table-bordered mt-3" style="width: 92%">
<thead>
<tr>
<th>{{trans('lang.item')}}</th>
<th>{{trans('lang.price')}}</th>
<th>{{trans('lang.qty')}}</th>
<th>{{trans('lang.extras')}}</th>
<th>{{trans('lang.total')}}</th>
</tr>
</thead>
<tbody id="order_products">
</tbody>
</table>
<span class="dashed-line"></span>
<div class="row justify-content-md-end mb-3" style="width: 97%">
<div class="col-md-7 col-lg-7">
<table class="order-summary-table" style="width:100%; font-size:16px; margin-bottom:0;">
  <tr style="background:#eaffea;">
    <td><b>Subtotal</b></td>
    <td style="text-align:right; color:green;"><b><span class="sub_total_val"></span></b></td>
  </tr>
  <tr><td colspan="2" style="font-size:13px; color:#888; margin-top:12px; height:18px;"></td></tr>
  <tr>
    <td>Discount</td>
    <td style="text-align:right; color:#e74c3c;"><span class="discount_val"></span></td>
  </tr>
  <tr>
    <td>Special Offer Discount</td>
    <td style="text-align:right; color:#e74c3c;"><span class="special_discount_val"></span></td>
  </tr>
  <tr><td colspan="2" style="font-size:13px; color:#888; margin-top:12px; height:18px;"></td></tr>
  <tr>
    <td>SGST (<span class="sgst_rate"></span>%)</td>
    <td style="text-align:right; color:#27ae60;">+<span class="sgst_val"></span></td>
  </tr>
  <tr>
    <td>GST (<span class="gst_rate"></span>%)</td>
    <td style="text-align:right; color:#27ae60;">+<span class="gst_val"></span></td>
  </tr>
  <tr><td colspan="2" style="font-size:13px; color:#888; margin-top:12px; height:18px;"></td></tr>
  <tr>
    <td>Delivery Charge</td>
    <td style="text-align:right; color:#2980b9;">+<span class="delivery_charge_val"></span></td>
  </tr>
  <tr><td colspan="2" style="font-size:13px; color:#888; margin-top:12px; height:18px;"></td></tr>
  <tr>
    <td>Tip Amount</td>
    <td style="text-align:right; color:#2980b9;">+<span class="tip_amount_val"></span></td>
  </tr>
  <tr><td colspan="2"><hr></td></tr>
  <tr style="font-size:20px;">
    <td><b>Total Amount</b></td>
    <td style="text-align:right; color:#2c3e50;"><b><span class="total_amount_val"></span></b></td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:12px; color:#888;">
      Admin Commission (<span class="admin_commission_rate"></span>) <span style="color:red;"><span style="margin:right;" class="admin_commission_val"></span></span>
    </td>
  </tr>
</table>
</div>
</div>
<span class="dashed-line"></span>
<h5 class="text-center pt-3">
{{trans('lang.thank_you')}}
</h5>
<span class="dashed-line"></span>
</div>
</div>
</div>
 @endsection
@section('style')
<style type="text/css">
    .dashed-line {
      display: block;          /* Make the span behave like a block element */
      width: 100%;             /* Make it span the full width of the page */
      border-bottom: 2px dashed black; /* Create the dotted line */
      margin: 20px 0;          /* Optional: add some space above and below the line */
    }
 #printableArea *{
            color: black !important;
        }
        @media  print {
            @page { size: portrait; }
            .non-printable {
                display: none;
            }
            .printable {
                display: block;
                font-family: emoji !important;
            }
            #printableArea{width:400px ;}
            body {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                font-family: emoji !important;
            }
        }
</style>
<style type="text/css" media="print">
  @page { size: portrait; }
  @page  {
      size: auto;
      /* auto is the initial value */
      margin: 2px;
      /* this affects the margin in the printer settings */
      font-family: emoji !important;
  }
</style>
@section('scripts')
<script>
var adminCommission=0;
var id_rendom = "<?php echo uniqid();?>";
var id = "<?php echo $id;?>";
var driverId='';
var fcmToken='';
var old_order_status='';
var payment_shared=false;
var deliveryChargeVal = 0;
var tip_amount_val = 0;
var tip_amount=0;
var total_price=0;
var total_item_price = 0;
var total_addon_price = 0;
var vendorname='';
var place_image = '';
var database = firebase.firestore();
var ref = database.collection('restaurant_orders').where("id","==",id);
var currentCurrency = '';
var currencyAtRight = false;
var decimal_degits = 0;
var refCurrency = database.collection('currencies').where('isActive', '==' , true);
refCurrency.get().then( async function(snapshots){  
    var currencyData = snapshots.docs[0].data();
    currentCurrency = currencyData.symbol;
    currencyAtRight = currencyData.symbolAtRight;
    if (currencyData.decimal_degits) {
       decimal_degits = currencyData.decimal_degits;
    }
}); 
ref.get().then( async function(snapshots){
    var order = snapshots.docs[0].data();
    $(".customerName").text(order.author.firstName+" "+order.author.lastName);
    $(".orderId").text(id);
    var date =  order.createdAt.toDate().toDateString();
    var time = order.createdAt.toDate().toLocaleTimeString('en-US');
    $(".orderDate").text(date + " "+time);
    var billingAddressstring = '';
    if (order.address.hasOwnProperty('address')) {
      billingAddressstring = billingAddressstring + order.address.address;
    }
    if (order.address.hasOwnProperty('locality')) {
      billingAddressstring = billingAddressstring +","+ order.address.locality;
    }
    if (order.address.hasOwnProperty('landmark')) {
      billingAddressstring = billingAddressstring + " " + order.address.landmark;
    }
   $(".customerAddress").text(billingAddressstring);  
    if(order.author.hasOwnProperty('phoneNumber')){ 
      $(".customerPhone").text(shortEditNumber(order.author.phoneNumber));
    }
    else
    {
      $(".customerPhone").text("");
    }
    if(order.address.hasOwnProperty('country')){
      $("#billing_country").text(order.address.country); 
    }
    if(order.address.hasOwnProperty('email')){
      $("#billing_email").html('<a href="mailto:'+order.address.email+'">'+shortEmail(order.address.email)+'</a>'); 
    }
    else
    {
      $("#billing_email").html("");
    }
    if (order.createdAt) {
        var date1 = order.createdAt.toDate().toDateString();
        var date = new Date(date1);
        var dd = String(date.getDate()).padStart(2, '0');
        var mm = String(date.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = date.getFullYear();
        var createdAt_val = yyyy + '-' + mm + '-' + dd;
        var time = order.createdAt.toDate().toLocaleTimeString('en-US');
      $('#createdAt').text(createdAt_val+' '+time);
    }
    if (order.payment_method) {
      if (order.payment_method == 'cod') {
        $('#payment_method').text('{{trans("lang.cash_on_delivery")}}');
      } else if(order.payment_method == 'paypal') {
        $('#payment_method').text('{{trans("lang.paypal")}}');
      }else{
        $('#payment_method').text(order.payment_method);
      }
    }
    if(order.hasOwnProperty('takeAway') && order.takeAway){
      $('#driver_pending').hide();
      $('#driver_rejected').hide();
      $('#order_shipped').hide();
      $('#in_transit').hide();
      $('#order_type').text('{{trans("lang.order_takeaway")}}');
      $('.payment_method').hide();
      orderTakeAwayOption = true;
    }else{
      $('#order_type').text('{{trans("lang.order_delivery")}}');
      $('.payment_method').show();
    }
    if ((order.driver!='' && order.driver!=undefined ) && (order.takeAway) ) {
      $('#driver_carName').text(order.driver.carName);
      $('#driver_carNumber').text(order.driver.carNumber);
      $('#driver_email').html('<a href="mailto:'+order.driver.email+'">'+shortEmail(order.driver.email)+'</a>');
      $('#driver_firstName').text(order.driver.firstName);
      $('#driver_lastName').text(order.driver.lastName);
      $('#driver_phone').text(shortEditNumber(order.driver.phoneNumber));
    }else{
      $('.order_edit-genrl').removeClass('col-md-4').addClass('col-md-6');
      $('.order_addre-edit').removeClass('col-md-4').addClass('col-md-6');
      $('.driver_details_hide').empty();
    }
    if (order.driverID != '' && order.driverID != undefined) {
        driverId = order.driverID;
    }
    if (order.vendor && order.vendor.author != '' && order.vendor.author != undefined) {
        vendorAuthor = order.vendor.author;
    }
    fcmToken=order.author.fcmToken;
    vendorname=order.vendor.title;
    fcmTokenVendor = order.vendor.fcmToken;
    customername = order.author.firstName;
    vendorId = order.vendor.id;
    old_order_status=order.status;
    if(order.payment_shared!=undefined){
        payment_shared = order.payment_shared;
    }
    append_procucts_list = document.getElementById('order_products');
    append_procucts_list.innerHTML='';
    var productsListHTML=buildHTMLProductsList(order.products);
    var productstotalHTML=buildHTMLProductstotal(order);
     if(productsListHTML!=''){
        append_procucts_list.innerHTML=productsListHTML;
     }
    orderPreviousStatus = order.status;
    if (order.hasOwnProperty('payment_method')) {
        orderPaymentMethod = order.payment_method;
    }
    $("#order_status option[value='"+order.status+"']").attr("selected","selected");
    if(order.status=="Order Rejected" || order.status=="Driver Rejected"){
      $("#order_status").prop("disabled", true);
    }
    var price = 0;
    if (order.vendorID) {
      var vendor = database.collection('vendors').where("id","==",order.vendorID);
      vendor.get().then( async function(snapshotsnew){
        if (snapshotsnew.hasData !=''){
        var vendordata = snapshotsnew.docs[0].data();
          if (vendordata.id) {
              var route_view =  '{{route("restaurants.view",":id")}}';
                route_view = route_view.replace(':id', vendordata.id);
              $('#resturant-view').attr('data-url',route_view);  
          }
          if (vendordata.photo!=null && vendordata.photo!="") {
              $('.resturant-img').attr('src',vendordata.photo);  
          }else{
              $('.resturant-img').attr('src',place_image); 
          }
          if (vendordata.title!="" && vendordata.title!=null) {
              $('.storeName').html(vendordata.title);  
          }
          if (vendordata.phonenumber!="" && vendordata.phonenumber!=null) {
              $('.storePhone').text(shortEditNumber(vendordata.phonenumber));  
          }
          else
          {
            $('.storePhone').text("");
          }
          if (vendordata.location!="" && vendordata.location!=null) {
              $('.storeAddress').text(vendordata.location);  
          }
        }
      });
    }
    fillPrintOrderSummary(order);
    jQuery("#data-table_processing").hide();
  })
  function buildHTMLProductsList(snapshotsProducts){
      var html='';
      var alldata=[];
      var number= [];
      var totalProductPrice=0;
      snapshotsProducts.forEach((product) => {
          var val=product;
              html=html+'<tr>';
              var extra_html='';
              if(product.extras!=undefined && product.extras!='' && product.extras.length>0){
                extra_html=extra_html + '<span>';
                var extra_count=1;
                try{
                product.extras.forEach((extra) => {
                  if(extra_count > 1){
                    extra_html=extra_html + ',' + extra;
                    }else{
                    extra_html=extra_html + extra;
                    }
                  extra_count++;
                })
              }catch(error){
              }
                extra_html=extra_html + '</span>';
              }
              html=html+'<td class="order-product"><div class="order-product-box">';
              if(val.photo != '' && val.photo !=  null){
                html=html +'<img onerror="this.onerror=null;this.src=\'' + place_image + '\'" class="img-circle img-size-32 mr-2" style="width:60px;height:60px;" src="'+val.photo+'" alt="image">';  
              }else{
                html=html +'<img class="img-circle img-size-32 mr-2" style="width:60px;height:60px;" src="'+place_image+'" alt="image">';
              }
              html=html+'</div><div class="orders-tracking"><h6>'+val.name+'</h6><div class="orders-tracking-item-details">';
              if(extra_count > 1 || product.size){
              }
              if(extra_count >1){
                  html=html+'<div class="extra"><span>{{trans("lang.extras")}} :</span><span class="ext-item">'+extra_html+'</span></div>';
              }
              if(product.size){
                  html=html+'<div class="type"><span>{{trans("lang.type")}} :</span><span class="ext-size">'+product.size+'</span></div>';
              }
              if (product.variant_info) {
                  html += '<div class="variant-info">';
                  html += '<ul>';
                  $.each(product.variant_info.variant_options, function (label, value) {
                      html += '<li class="variant"><span class="label">' + label + '</span><span class="value">' + value + '</span></li>';
                  });
                  html += '</ul>';
                  html += '</div>';
              }
              price_item=parseFloat(val.discountPrice).toFixed(decimal_degits);  
              totalProductPrice =  parseFloat(val.discountPrice) * parseInt(val.quantity);
              var extras_price=0;
              if(product.extras!=undefined && product.extras!='' && product.extras.length>0){
                extras_price_item=(parseFloat(val.extras_price)*parseInt(val.quantity)).toFixed(2);
                if(parseFloat(extras_price_item)!=NaN && val.extras_price!=undefined){
                    extras_price=extras_price_item;
                }
                totalProductPrice =parseFloat(extras_price) + parseFloat(totalProductPrice);
              }
              totalProductPrice=parseFloat(totalProductPrice).toFixed(decimal_degits);
              if(currencyAtRight){
                  price_val = parseFloat(price_item).toFixed(decimal_degits) + "" + currentCurrency;
                  extras_price_val = parseFloat(extras_price).toFixed(decimal_degits) + "" + currentCurrency;
                  totalProductPrice_val = parseFloat(totalProductPrice).toFixed(decimal_degits) + "" + currentCurrency;
              }else{
                  price_val = currentCurrency + "" + parseFloat(price_item).toFixed(decimal_degits);
                          extras_price_val = currentCurrency + "" + parseFloat(extras_price).toFixed(decimal_degits);
                          totalProductPrice_val = currentCurrency + "" + parseFloat(totalProductPrice).toFixed(decimal_degits);
              }
              html=html+'</div></div></td>';
              html=html+'<td>'+price_val+'</td><td>'+val.quantity+'</td><td> + '+extras_price_val+'</td><td>  '+totalProductPrice_val+'</td>'; 
              html=html+'</tr>';
              total_price +=parseFloat(totalProductPrice);  
              total_addon_price += parseFloat(extras_price); 
              total_item_price += parseFloat(price_item);                
        });
        totalProductPrice=0;
        if (currencyAtRight) {
          total_item_price = parseFloat(total_item_price).toFixed(decimal_degits) + "" + currentCurrency;
          total_addon_price = parseFloat(total_addon_price).toFixed(decimal_degits) + "" + currentCurrency;
          $('.total_price').text(parseFloat(total_price).toFixed(decimal_degits) + "" + currentCurrency);
        } else {
          total_item_price = currentCurrency + "" + parseFloat(total_item_price).toFixed(decimal_degits);
          total_addon_price = currentCurrency + "" + parseFloat(total_addon_price).toFixed(decimal_degits);
          $('.total_price').text(currentCurrency + "" + parseFloat(total_price).toFixed(decimal_degits));
        }
        $('.total_item_price').text(total_item_price);
        $('.total_addon_price').text(total_addon_price);
        return html;      
}
// --- PATCH: Sync print total logic with edit page ---
function buildHTMLProductstotal(snapshotsProducts){
    var html='';
    var alldata=[];
    var number= [];
    var adminCommission = snapshotsProducts.adminCommission;
    var adminCommissionType = snapshotsProducts.adminCommissionType;
    var discount = snapshotsProducts.discount;
    var couponCode = snapshotsProducts.couponCode;
    var extras = snapshotsProducts.extras;
    var extras_price = snapshotsProducts.extras_price;
    var rejectedByDrivers = snapshotsProducts.rejectedByDrivers;
    var takeAway = snapshotsProducts.takeAway;
    var tip_amount = snapshotsProducts.tip_amount;
    var notes = snapshotsProducts.notes;
    var tax_amount = snapshotsProducts.vendor.tax_amount;
    var status = snapshotsProducts.status;
    var products = snapshotsProducts.products;
    var deliveryCharge = snapshotsProducts.deliveryCharge;
    var specialDiscount = snapshotsProducts.specialDiscount;
    var intRegex = /^\d+$/;
    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
    var baseDeliveryCharge = 23; // default, override with settings if available
    var gstRate = 18;
    var sgstRate = 5;
    var subtotal = 0;
    var decimal_degits = 2;
    var currencyAtRight = false;
    var currentCurrency = '₹';
    if(typeof currencyAtRightSetting !== 'undefined') currencyAtRight = currencyAtRightSetting;
    if(typeof currentCurrencySetting !== 'undefined') currentCurrency = currentCurrencySetting;
    if(products) {
        products.forEach((product) => {
            var price = (product.discountPrice && parseFloat(product.discountPrice) > 0)
                ? parseFloat(product.discountPrice)
                : parseFloat(product.price);
            subtotal += price * (parseInt(product.quantity) || 1);
        });
    }
    var sgst = subtotal * (sgstRate / 100); // 5% of subtotal only
    var gst = 0;
    if (parseFloat(deliveryCharge) > 0) {
        gst = parseFloat(deliveryCharge) * (gstRate / 100); // 18% of delivery charge
    } else {
        gst = baseDeliveryCharge * (gstRate / 100); // 18% of base if delivery free
    }
    // Calculate total price (subtotal + delivery + tips + extras)
    var total_price = subtotal;
    if(intRegex.test(extras_price) || floatRegex.test(extras_price)) {
        total_price += parseFloat(extras_price);
    }
    var priceWithCommision = total_price;
    if(intRegex.test(discount) || floatRegex.test(discount)) {
        discount = parseFloat(discount).toFixed(decimal_degits);
        total_price -= parseFloat(discount);
    }
    if(specialDiscount && specialDiscount.special_discount) {
        var special_discount = parseFloat(specialDiscount.special_discount).toFixed(decimal_degits);
        total_price -= parseFloat(special_discount);
    }
    var total_tax_amount = sgst + gst;
    total_price = parseFloat(total_price) + parseFloat(total_tax_amount);
    var totalAmount = total_price;
    if(intRegex.test(deliveryCharge) || floatRegex.test(deliveryCharge)) {
        deliveryCharge = parseFloat(deliveryCharge).toFixed(decimal_degits);
        totalAmount += parseFloat(deliveryCharge);
    }
    if(intRegex.test(tip_amount) || floatRegex.test(tip_amount)) {
        tip_amount = parseFloat(tip_amount).toFixed(decimal_degits);
        totalAmount += parseFloat(tip_amount);
    }
    html += '<tr><td class="label">Items Price :</td><td>' + subtotal.toFixed(decimal_degits) + currentCurrency + '</td></tr>';
    html += '<tr><td class="label">Addon Cost :</td><td>' + (extras_price ? parseFloat(extras_price).toFixed(decimal_degits) : '0.00') + currentCurrency + '</td></tr>';
    html += '<tr><td class="label">Subtotal :</td><td>' + subtotal.toFixed(decimal_degits) + currentCurrency + '</td></tr>';
    if(intRegex.test(discount) || floatRegex.test(discount)) {
        var discount_val = currencyAtRight ? discount + currentCurrency : currentCurrency + discount;
        html += '<tr><td class="label">Discount :</td><td>-'+discount_val+'</td></tr>';
    }
    if(specialDiscount && specialDiscount.special_discount) {
        var special_discount_val = currencyAtRight ? parseFloat(specialDiscount.special_discount).toFixed(decimal_degits) + currentCurrency : currentCurrency + parseFloat(specialDiscount.special_discount).toFixed(decimal_degits);
        html += '<tr><td class="label">Special Offer Discount :</td><td>-'+special_discount_val+'</td></tr>';
    }
    html += '<tr><td class="label">GST (18%) :</td><td>₹ '+gst.toFixed(decimal_degits)+'</td></tr>';
    html += '<tr><td class="label">SGST (5%) :</td><td>₹ '+sgst.toFixed(decimal_degits)+'</td></tr>';
    if(intRegex.test(tip_amount) || floatRegex.test(tip_amount)) {
        html += '<tr><td class="label">DM Tips :</td><td>+ '+tip_amount+currentCurrency+'</td></tr>';
    }
    if(intRegex.test(deliveryCharge) || floatRegex.test(deliveryCharge)) {
        html += '<tr><td class="label">Delivery Fee :</td><td>+ '+deliveryCharge+currentCurrency+'</td></tr>';
    }
    html += '<tr><td class="label"><b>Total :</b></td><td><b>'+currentCurrency+parseFloat(totalAmount).toFixed(decimal_degits)+'</b></td></tr>';
    // Admin Commission (optional, for reference)
    var adminCommHtml = "";
    var adminCommission_val = 0;
    var basePrice = 0;
    if(adminCommissionType=="Percent") {
        basePrice = (priceWithCommision/(1+(parseFloat(adminCommission)/100)));
        adminCommission = parseFloat(priceWithCommision-basePrice);
        adminCommHtml = "("+adminCommissionType+"%)";
    } else {
        basePrice = priceWithCommision-adminCommission;
        adminCommission = parseFloat(priceWithCommision-basePrice);
    }
    if(currencyAtRight) {
        adminCommission_val = parseFloat(adminCommission).toFixed(decimal_degits)+""+currentCurrency;
    } else {
        adminCommission_val = currentCurrency+""+parseFloat(adminCommission).toFixed(decimal_degits);
    }
    if(adminCommission) {
        html += '<tr><td class="label"><small>Admin Commission '+adminCommHtml+'</small></td><td style="color:red"><small>( '+adminCommission_val+' )</small></td></tr>';
    }
    if(notes) {
        html += '<tr><td class="label">Notes</td><td class="adminCommission_val">'+notes+'</td></tr>';
    }
    return html;
}
// --- END PATCH ---
function printDiv(divName) {
  var css = '@page { size: portrait; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');
style.type = 'text/css';
style.media = 'print';
if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}
head.appendChild(style);
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
// --- Fill values dynamically using the same logic as edit.blade.php ---
function fillPrintOrderSummary(order) {
  // Reference: buildHTMLProductstotal from edit.blade.php
  var intRegex = /^\d+$/;
  var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
  var baseDeliveryCharge = 23;
  var gstRate = 18;
  var sgstRate = 5;
  var subtotal = 0;
  var decimal_degits = window.decimal_degits || 2;
  var currencyAtRight = window.currencyAtRight || false;
  var currentCurrency = window.currentCurrency || '₹';
  var products = order.products;
  if(products) {
    products.forEach(function(product) {
      var price = (product.discountPrice && parseFloat(product.discountPrice) > 0)
        ? parseFloat(product.discountPrice)
        : parseFloat(product.price);
      subtotal += price * (parseInt(product.quantity) || 1);
    });
  }
  var sgst = subtotal * (sgstRate / 100);
  var gst = 0;
  var deliveryCharge = order.deliveryCharge;
  if (parseFloat(deliveryCharge) > 0) {
    gst = parseFloat(deliveryCharge) * (gstRate / 100);
  } else {
    gst = baseDeliveryCharge * (gstRate / 100);
  }
  var total_price = subtotal;
  if(intRegex.test(order.extras_price) || floatRegex.test(order.extras_price)) {
    total_price += parseFloat(order.extras_price);
  }
  var priceWithCommision = total_price;
  var discount = order.discount;
  if(intRegex.test(discount) || floatRegex.test(discount)) {
    discount = parseFloat(discount).toFixed(decimal_degits);
    total_price -= parseFloat(discount);
  }
  var specialDiscount = order.specialDiscount;
  var special_discount = 0;
  if(specialDiscount && specialDiscount.special_discount) {
    special_discount = parseFloat(specialDiscount.special_discount).toFixed(decimal_degits);
    total_price -= parseFloat(special_discount);
  }
  var total_tax_amount = sgst + gst;
  total_price = parseFloat(total_price) + parseFloat(total_tax_amount);
  var totalAmount = total_price;
  if(intRegex.test(deliveryCharge) || floatRegex.test(deliveryCharge)) {
    deliveryCharge = parseFloat(deliveryCharge).toFixed(decimal_degits);
    totalAmount += parseFloat(deliveryCharge);
  }
  var tip_amount = order.tip_amount;
  if(intRegex.test(tip_amount) || floatRegex.test(tip_amount)) {
    tip_amount = parseFloat(tip_amount).toFixed(decimal_degits);
    totalAmount += parseFloat(tip_amount);
  }
  // Format helpers
  function fmt(val) {
    return currencyAtRight ? (val + currentCurrency) : (currentCurrency + val);
  }
  // Fill values
  document.querySelector('.sub_total_val').textContent = fmt(parseFloat(subtotal).toFixed(decimal_degits));
  document.querySelector('.discount_val').textContent = '-'+fmt(discount || '0.00');
  document.querySelector('.special_discount_val').textContent = '-'+fmt(special_discount || '0.00');
  document.querySelector('.sgst_rate').textContent = sgstRate;
  document.querySelector('.sgst_val').textContent = sgst.toFixed(decimal_degits);
  document.querySelector('.gst_rate').textContent = gstRate;
  document.querySelector('.gst_val').textContent = gst.toFixed(decimal_degits);
  document.querySelector('.delivery_charge_val').textContent = fmt(deliveryCharge || '0.00');
  document.querySelector('.tip_amount_val').textContent = fmt(tip_amount || '0.00');
  document.querySelector('.total_amount_val').textContent = fmt(parseFloat(totalAmount).toFixed(decimal_degits));
  // Admin Commission
  var adminCommission = order.adminCommission;
  var adminCommissionType = order.adminCommissionType;
  var adminCommHtml = '';
  var adminCommission_val = 0;
  var basePrice = 0;
  if(adminCommissionType=="Percent") {
    basePrice = (priceWithCommision/(1+(parseFloat(adminCommission)/100)));
    adminCommission = parseFloat(priceWithCommision-basePrice);
    adminCommHtml = "("+adminCommission+"%)";
  } else {
    basePrice = priceWithCommision-adminCommission;
    adminCommission = parseFloat(priceWithCommision-basePrice);
  }
  adminCommission_val = fmt(parseFloat(adminCommission).toFixed(decimal_degits));
  document.querySelector('.admin_commission_rate').textContent = adminCommissionType=="Percent" ? order.adminCommission+"%" : '';
  document.querySelector('.admin_commission_val').textContent = '( '+adminCommission_val+' )';
}
// Usage: after fetching order data, call fillPrintOrderSummary(order)
</script>
@endsection