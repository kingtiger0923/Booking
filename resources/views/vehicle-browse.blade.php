@extends('layout.app')

@section('content')
<div class="row py-4">
  <div class="col-md-12">
    <a onclick="openNav()"><i class="fa fa-bars p-4"></i></a>
    <a href="/addvehicle" class="back-sky color-white"><i class="fa fa-plus p-3 float-right back-sky border-radius-30" style="margin: 15px 20px 0px 0px;"></i></a>
    <span class="text-center font-weight-bold text-dark maintitle">Vehicles</span>
  </div>
</div>

<div class="row py-2">
  <div class="col-md-12">
    <input class="wrapper border-radius-10 p-3 background-white outline-none" name="search" type="search" placeholder="Search" oninput="SearchForVehicles(this);"/>
  </div>
</div>
<div class="row">

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="col-md-12 py-2">
  @foreach ($vehicles as $vehicle)
  <div class="row p-4 vehicle_block" id="vehicle_{{$vehicle->id}}" vehicle_info="{{$vehicle->Type_make}} {{$vehicle->Type_model}} {{$vehicle->License_plate}}">
    <div class="col-md-12 back-white border-radius-10">
      <div class="row px-3 pt-3">
        <div class="col-md-12"><span style="line-height:150%" class="font120">{{$vehicle->Type_make}}</span><span onclick="deleteVehicle({{$vehicle->id}})" class="float-right font200 color-red">&times;</span></div>
      </div>
      <div class="row px-3">
        <div class="col-md-12"><span style="line-height:100%" class="font120">{{$vehicle->Type_model}}</span></div>
      </div>
      <div class="row px-3">
        <div class="col-md-12 py-2"><span style="line-height:100%" class="font80">{{$vehicle->License_plate}}</span></div>
      </div>
      <div class="row px-3 pb-2">
        <div class="col-md-4"><span style="line-height:150%; vertical-align:middle;">${{$vehicle->Price_hour}}/hr</span></div>
        <div class="col-md-4"><span style="line-height:150%; vertical-align:middle;">${{$vehicle->Price_mile}}/mi</span></div>
        <div class="col-md-4">
          <a href="/edit-vehicle/{{$vehicle->id}}"><div class="text-center wrapper selectable-button-selected px-3 py-1" style="color:white;" id="vehicle_edit" >Edit</div></a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
</div>
@endsection
