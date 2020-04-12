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
        <input class="wrapper border-none background-white outline-none" name="phonenumber" placeholder="Type phone number" value="<?php if(isset($customer->phone) == true) echo $customer->phone; ?>" oninput="PhoneNumberInput(this);" minlength="10" maxlength="10" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="homeaddress" id="home_address" onfocus="geolocate();" placeholder="Type home address" value="<?php if(isset($customer->home_address) == true) echo $customer->home_address; ?>" required/>
        <div class="stroke-line wrapper pb-3"></div>
      </div>
    </div>
    <div class="row p-2 back-white">
      <div class="col-md-12">
        <input class="wrapper border-none background-white outline-none" name="officeaddress" id="office_address" onfocus="geolocate();" placeholder="Type office address" value="<?php if(isset($customer->office_address) == true)  echo $customer->office_address; ?>" required/>
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
<script type="text/javascript" charset="utf-8">
    // Google Place AutoComplete
    var placeSearch, autocomplete, autocomplete2;
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('home_address'), {types: ['geocode']});

        autocomplete2 = new google.maps.places.Autocomplete(
            document.getElementById('office_address'), {types: ['geocode']});
    }
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({center: geolocation, radius: position.coords.accuracy});
            //autocomplete.setBounds(circle.getBounds());
            //autocomplete2.setBounds(circle.getBounds());
            });
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATQgdZ12KKj6Kty5bJS90dnB9BUNEYnYg&sensor=true&libraries=places&callback=initAutocomplete" async defer></script>
@endsection
