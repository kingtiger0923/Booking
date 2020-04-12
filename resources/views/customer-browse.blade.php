@extends('layout.app')

@section('content')
<div class="row py-4">
  <div class="col-md-12">
    <a onclick="openNav()"><i class="fa fa-bars p-4"></i></a>
    <a href="/addcustomer" class="back-sky color-white" style="z-index:10;"><i class="fa fa-plus p-3 float-right back-sky border-radius-30" style="margin: 15px 20px 0px 0px;"></i></a>
    <span class="text-center font-weight-bold text-dark maintitlecustomer">Customers</span>
  </div>
</div>

<div class="row py-2">
  <div class="col-md-12">
    <input class="wrapper border-radius-10 p-3 background-white outline-none" name="search" type="search" placeholder="Search" oninput="SearchForCustomers(this);"/>
  </div>
</div>
<div class="row">

<div class="col-md-12 py-2">
  @foreach ($customers as $customer)
  <div class="row p-4 customer_block" id="customer_{{$customer->id}}" cus_name="{{$customer->firstname}} {{$customer->lastname}}">
    <div class="col-md-12 back-white border-radius-10">
      <div class="row px-3 py-2">
        <div class="col-md-12 py-2"><span style="line-height:100%" class="font120">{{$customer->firstname}} {{$customer->lastname}}</span><span onclick="deleteCustomer({{$customer->id}})" class="float-right font200 color-red">&times;</span></div>
      </div>
      <div class="row px-3 py-2">
        <div class="col-md-12 back-white py-2">
          <span><a href="tel:{{$customer->phone}}"><i class="fa fa-phone-square font200 color-sky px-2"></i></a></span>
          <span><a href="sms:{{$customer->phone}}"><i class="fas fa-sms font200 color-sky px-2"></i></a></span>
          <span><a href="mailto:{{$customer->email}}"><i class="fas fa-envelope-open-text font200 color-sky px-2"></i></a></span>
        </div>
      </div>
      <div class="row px-3 py-2">
        <div class="col-md-8 py-2"><span style="line-height:100%; vertical-align:middle;">{{$customer->home_address}}</span></div>
        <div class="col-md-4 py-2">
          {{-- <input class="text-center wrapper selectable-button-selected" style="color:white;" id="customer_edit" name="Edit" type="button" value="Edit"/> --}}
          <a href="/edit-customer/{{$customer->id}}"><div class="text-center wrapper selectable-button-selected px-3 py-1" style="color:white;" id="customer_edit" >Edit</div></a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
</div>
@endsection
