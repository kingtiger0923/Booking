@extends('layout.app')
<?php
    //dd($event);
?>
@section('content')
<div class="row py-4">
  <div class="col-md-12">
    <a onclick="backToBooking();"><i class="fa fa-arrow-left p-4"></i></a>
    <span class="text-center font-weight-bold text-dark maintitle">Customers</span>
  </div>
</div>
{{-- Summary --}}
<div class="px-4 row">
  <div class="col-md-12">
    <span class="font-weight-bold">Summary</span>
    <div class="wrapper p-2"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['customer']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['src-address']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['dst-address']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['date']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
{{-- Price --}}
<div class="px-4 row pt-5">
  <div class="col-md-12">
    <span class="font-weight-bold">Price: $<?php if( $data['price_t'] == "Manu" ) echo $data['manu_price']; else if($data['price_t'] == "Calc") echo $data['calc_price']; ?></span>
    <div class="wrapper p-2"></div>
  </div>
</div>

<div class="px-4 row pt-2">
  <div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <input type="checkbox" onclick="return false;" name="sendemail" <?php if($sendOkay == true) echo 'checked'; ?> style="width: 20px; height:20px;"/>
            <span style="padding: 0px 0px 0px 10px; vertical-align: super; font-size: 13px;">email booking details to the customer</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="checkbox" onclick="return false;" name="savecalendar" checked style="width: 20px; height:20px;"/>
            <span style="padding: 0px 0px 0px 10px; vertical-align: super; font-size: 13px;">saved in Google Calendar <a target="_blank" href="{{$event->htmlLink}}">see</a></span>
        </div>
    </div>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 py-5 row">
  <div class="col-md-12 text-center">
    <span class="text-center p-4 wrapper selectable-button-selected" style="padding: 15px 100px!important;" id="confirm" name="confirm"><a href="/" style="color: white; text-decoration: none; font-size: 16px;">Confirm</a></span>
  </div>
</div>
@endsection
