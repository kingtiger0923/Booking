@extends('layout.app')

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
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$customer['firstname']}} {{$customer['lastname']}}" readonly/>
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
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$date}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
{{-- Passenger --}}
<div class="px-4 row pt-5">
  <div class="col-md-12">
    <span class="font-weight-bold">Passenger ({{$data['passenger-count']}})</span>
    <div class="wrapper p-2"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['passenger-name']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['passenger-phone']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
{{-- Price --}}
<div class="px-4 row pt-5">
  <div class="col-md-12">
    <span class="font-weight-bold">Price</span>
    <div class="wrapper p-2"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <input type="radio" name="price_t" value="Calc" style="width: 20px; height:20px;" checked/>
            <span style="padding: 0px 0px 0px 10px; vertical-align: super; font-size: 13px;">Calculated Price</span>
        </div>
        <div class="col-md-6">
            <span>$</span>
            <input  class="border-none outline-none customInputWidth background-white" type="number" name="calc_price" value="{{$Calc_Price}}" readonly/>
        </div>
    </div>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 row pt-2">
  <div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <input type="radio" name="price_t" value="Manu" style="width: 20px; height:20px;"/>
            <span style="padding: 0px 0px 0px 10px; vertical-align: super; font-size: 13px;">Manual Price</span>
        </div>
        <div class="col-md-6">
            <span>$</span>
            <input  class="border-none background-white outline-none customInputWidth" type="number" name="manu_price" value="0"/>
        </div>
    </div>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
@endsection
