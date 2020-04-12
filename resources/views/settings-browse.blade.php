@extends('layout.app')

@section('content')
<div class="row py-4">
  <div class="col-md-12">
    <a onclick="openNav()"><i class="fa fa-bars p-4"></i></a>
    <span class="text-center font-weight-bold text-dark maintitle">Settings</span>
  </div>
</div>
<form action="/setting-save" method="POST">
    {{csrf_field()}}
<div class="settings-panel">
  <div class="py-2 row">
    <div class="col-md-12">
        <span class="font-weight-bold">Email Settings</span>
        <div class="wrapper p-2"></div>
    </div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none" name="set-smtp" placeholder="SMTP host" id="smtp_host" value="<?php if(isset($settings['SMTP_host'])) echo $settings['SMTP_host']; ?>"/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none" name="set-email" placeholder="email address" id="email_addr" value="<?php if(isset($settings['email_address'])) echo $settings['email_address']; ?>"/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none" name="set-smtpuser" placeholder="SMTP username" id="smtp_user" value="<?php if(isset($settings['SMTP_username'])) echo $settings['SMTP_username']; ?>"/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none" name="set-smtppass" placeholder="SMTP Password" id="smtp_pass" value="<?php if(isset($settings['SMTP_password'])) echo $settings['SMTP_password']; ?>"/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  {{-- <div class="py-2 row">
    <div class="col-md-12">
        <span class="font-weight-bold">Google Calendar settings</span>
        <div class="wrapper p-2"></div>
    </div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none" name="set-gcalendar-address" placeholder="gmail address"/>
    <div class="stroke-line wrapper pb-5"></div>
  </div>
  <div class="px-4 py-2 row">
    <input class="wrapper border-none back-white outline-none" name="set-gcalendar-password" placeholder="gmail password"/>
    <div class="stroke-line wrapper pb-5"></div>
  </div> --}}
  <p style="display:none;" id="setting-alert"> Successfully Saved </p>
  <div class="px-4 py-2 row">
    <div class="col-md-12">
      <input class="text-center p-4 wrapper selectable-button-selected font120" style="color:white;" id="Setting_save" name="save" type="button" value="Save"/>
    </div>
  </div>
</div>
</form>
@endsection
