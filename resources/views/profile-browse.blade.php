@extends('layout.app')

@section('content')
<div class="row py-4">
  <div class="col-md-12">
    <a onclick="openNav()"><i class="fa fa-bars p-4"></i></a>
    <span class="text-center font-weight-bold text-dark maintitle">Profile</span>
  </div>
</div>

<form action="/update-profile" method="POST" id="profile_form">
    {{ csrf_field() }}
<div class="settings-panel">
  <div class="row text-center">
    <div class="col-md-12">
        <img class="position-relative p-2 back-white" src="{{URL::to('/images')}}/Logo.png" style="margin-top: -80px; width: 204px; height: 80px;"/>
    </div>
  </div>
  <div class="px-4 py-2 pt-5 row">
    <input class="wrapper border-none back-white outline-none font-weight-bold" name="pro-name" placeholder="User Name" value="<?php if(isset($profile->name)) echo $profile->name; ?>" required/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none font-weight-bold" name="pro-email" placeholder="email address" value="<?php if(isset($profile->email)) echo $profile->email; ?>" readonly/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none font-weight-bold" name="pro-phone" placeholder="Phone Number" value="<?php if(isset($profile->phone)) echo $profile->phone; ?>" type="tel" pattern="\d{3}[\-]\d{3}[\-]\d{4}" value="" required/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none font-weight-bold" name="change-password" placeholder="new password"/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none font-weight-bold" name="change-password-repeat" placeholder="repeat new password"/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <div class="col-md-12">
      <input class="text-center p-4 wrapper selectable-button-selected font120" style="color:white;" id="save" name="save" type="submit" value="Save"/>
    </div>
  </div>
</div>
</form>
@endsection
