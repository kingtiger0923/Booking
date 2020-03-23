@extends('layout.app')

@section('content')
<div class="row py-4">
  <div class="col-md-12">
    <a onclick="openNav()"><i class="fa fa-bars p-4"></i></a>
    <span class="text-center font-weight-bold text-dark maintitle">Customers</span>
  </div>
</div>
<form method="POST" action="/customer-add">
    {{ csrf_field() }}
<div class="row p-4">
  <div class="col-md-12 border-radius-10">
    <div class="row p-2 back-white">
      <div class="col-md-12" style="padding-top: 50px;">
        <input class="wrapper border-none background-white outline-none" name="firstname" placeholder="Type first name" value="<?php if(isset($customer->firstname) == true) echo $customer->firstname; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="lastname" placeholder="Type last name" value="<?php if(isset($customer->lastname) == true) echo $customer->lastname; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="email" placeholder="Type email" value="<?php if(isset($customer->email) == true) echo $customer->email; ?>" required <?php if(isset($customer->email) == true) echo 'readonly'; ?>/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="phonenumber" placeholder="Type phone number" value="<?php if(isset($customer->phone) == true) echo $customer->phone; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="homeaddress" placeholder="Type home address" value="<?php if(isset($customer->home_address) == true) echo $customer->home_address; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="officeaddress" placeholder="Type office address" value="<?php if(isset($customer->office_address) == true)  echo $customer->office_address; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="px-4 py-2 row back-white">
      <div class="col-md-12">
        <input class="text-center p-4 wrapper selectable-button-selected" style="color:white;" id="customer_save" name="save" type="submit" value="Save"/>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
