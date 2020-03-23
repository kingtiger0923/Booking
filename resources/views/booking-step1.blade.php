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
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['customer-name']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['src-address']}}, {{$data['dst-address']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="<?php if($data['dst-address-t'] == ) ?>" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none wrapper" name="customer" placeholder="Not Specified" value="{{$data['form-data-customer-name']}}" readonly/>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
@endsection
