@extends('layouts.app')
@section('content')
<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">{{ trans('lang.deliveryCharge')}}</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
        <li class="breadcrumb-item active">{{ trans('lang.deliveryCharge')}}</li>
      </ol>
    </div>
  </div>
  <div class="card-body">
    <div class="error_top"></div>
    <div class="row restaurant_payout_create">
      <div class="restaurant_payout_create-inner">
        <fieldset>
          <legend>{{trans('lang.deliveryCharge')}}</legend>
          <div class="form-check width-100">
            <input type="checkbox" class="form-check-inline" id="vendor_can_modify">
            <label class="col-5 control-label" for="vendor_can_modify">{{ trans('lang.vendor_can_modify')}}</label>
          </div>
          <div class="form-group row width-100">
            <label class="col-4 control-label">Base Delivery Charge</label>
            <div class="col-7">
              <input type="number" class="form-control" id="base_delivery_charge">
            </div>
          </div>
          <div class="form-group row width-100">
            <label class="col-4 control-label">Free Delivery Distance (km)</label>
            <div class="col-7">
              <input type="number" class="form-control" id="free_delivery_distance_km ">
            </div>
          </div>
          <div class="form-group row width-100">
            <label class="col-4 control-label">Item Total Threshold</label>
            <div class="col-7">
              <input type="number" class="form-control" id="item_total_threshold">
            </div>
          </div>
          <div class="form-group row width-100">
            <label class="col-4 control-label">Per KM Charge Above Free Distance</label>
            <div class="col-7">
              <input type="number" class="form-control" id="per_km_charge_above_free_distance">
            </div>
          </div>
          <input type="hidden" id="distanceType">
        </fieldset>
      </div>
    </div>
    <div class="form-group col-12 text-center">
      <button type="button" class="btn btn-primary edit-setting-btn"><i class="fa fa-save"></i>
        {{trans('lang.save')}}</button>
      <a href="{{url('/dashboard')}}" class="btn btn-default"><i class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
    </div>
  </div>
  @endsection
  @section('scripts')
  <script>
    var database=firebase.firestore();
    var ref_deliverycharge=database.collection('settings').doc("DeliveryCharge");
    $(document).ready(function() {
      jQuery("#data-table_processing").show();
      ref_deliverycharge.get().then(async function(snapshots_charge) {
        var deliveryChargeSettings=snapshots_charge.data();
        if(deliveryChargeSettings==undefined) {
          database.collection('settings').doc('DeliveryCharge').set({
            'vendor_can_modify': false,
            'base_delivery_charge': 23,
            'free_delivery_distance_km': 7,
            'item_total_threshold': 299,
            'per_km_charge_above_free_distance': 8
          });
        }
        jQuery("#data-table_processing").hide();
        try {
          if(deliveryChargeSettings.vendor_can_modify) {
            $("#vendor_can_modify").prop('checked',true);
          }
          $("#base_delivery_charge").val(deliveryChargeSettings.base_delivery_charge || 23);
          $("#free_delivery_distance_km").val(deliveryChargeSettings.free_delivery_distance_km || 7);
          $("#item_total_threshold").val(deliveryChargeSettings.item_total_threshold || 299);
          $("#per_km_charge_above_free_distance").val(deliveryChargeSettings.per_km_charge_above_free_distance || 8);
        } catch(error) {
        }
      });
      $(".edit-setting-btn").click(function() {
        var checkboxValue=$("#vendor_can_modify").is(":checked");
        var base_delivery_charge=$("#base_delivery_charge").val();
        var free_delivery_distance_km=$("#free_delivery_distance_km").val();
        var item_total_threshold=$("#item_total_threshold").val();
        var per_km_charge_above_free_distance=$("#per_km_charge_above_free_distance").val();

        if(base_delivery_charge=='') {
          $(".error_top").show();
          $(".error_top").html("");
          $(".error_top").append("<p>Please enter Base Delivery Charge</p>");
          window.scrollTo(0,0);
        } else if(free_delivery_distance_km=='') {
          $(".error_top").show();
          $(".error_top").html("");
          $(".error_top").append("<p>Please enter Free Delivery Distance</p>");
          window.scrollTo(0,0);
        } else if(item_total_threshold=='') {
          $(".error_top").show();
          $(".error_top").html("");
          $(".error_top").append("<p>Please enter Item Total Threshold</p>");
          window.scrollTo(0,0);
        } else if(per_km_charge_above_free_distance=='') {
          $(".error_top").show();
          $(".error_top").html("");
          $(".error_top").append("<p>Please enter Per KM Charge Above Free Distance</p>");
          window.scrollTo(0,0);
        } else {
          database.collection('settings').doc("DeliveryCharge").update({
            'vendor_can_modify': checkboxValue,
            'base_delivery_charge': parseInt(base_delivery_charge),
            'free_delivery_distance_km': parseInt(free_delivery_distance_km),
            'item_total_threshold': parseInt(item_total_threshold),
            'per_km_charge_above_free_distance': parseInt(per_km_charge_above_free_distance)
          }).then(function(result) {
            window.location.href='{{ url("settings/app/deliveryCharge")}}';
          });
        }
      })
    })
  </script>
  @endsection
