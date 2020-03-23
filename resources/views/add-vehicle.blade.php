@extends('layout.app')

@section('content')
<div class="row py-4">
  <div class="col-md-12">
    <a onclick="openNav()"><i class="fa fa-bars p-4"></i></a>
    <span class="text-center font-weight-bold text-dark maintitle">Vehicle</span>
  </div>
</div>
<form method="POST" action="/vehicle-add">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="<?php if(isset($id) == true) echo $id; ?>"/>
<div class="row p-4">
  <div class="col-md-12 border-radius-10">
    <div class="row p-2 back-white">
      <div class="col-md-12" style="padding-top: 50px;">
        <input class="wrapper border-none background-white outline-none" name="typemake" placeholder="Type make" value="<?php if(isset($vehicle->Type_make) == true) echo $vehicle->Type_make; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="typemodel" placeholder="Type model" value="<?php if(isset($vehicle->Type_model) == true) echo $vehicle->Type_model; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="license" placeholder="License plate" value="<?php if(isset($vehicle->License_plate) == true) echo $vehicle->License_plate; ?>" required />
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="price_hour" placeholder="" value="<?php if(isset($vehicle->Price_hour) == true) echo $vehicle->Price_hour; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="price_mile" placeholder="" value="<?php if(isset($vehicle->Price_mile) == true) echo $vehicle->Price_mile; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="price_base" placeholder="" value="<?php if(isset($vehicle->Price_base) == true)  echo $vehicle->Price_base; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="miles_included" placeholder="" value="<?php if(isset($vehicle->Miles_included) == true)  echo $vehicle->Miles_included; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="px-4 py-2 row back-white">
      <div class="col-md-12">
        <input class="text-center p-4 wrapper selectable-button-selected" style="color:white;" id="vehicle_save" name="save" type="submit" value="Save"/>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
