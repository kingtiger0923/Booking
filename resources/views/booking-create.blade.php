@extends('layout.app')

@php
    $today = new DateTime();
    $tomorrow = new DateTime(); $tomorrow->modify('+1 day');
    $date3 = new DateTime(); $date3->modify('+2 day');
    $date4 = new DateTime(); $date4->modify('+3 day');
    $date5 = new DateTime(); $date5->modify('+4 day');
@endphp
@section('content')
{{-- Modal for Customer Select --}}
<div id="myModal" class="modal">
    <form action="/uploadEvidence" id="uploadform" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
    <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h2 style="padding: 5px;">Select a Customer</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                @foreach ($customers as $one)
                <div class="customer-field" onclick="CustomerSelected({{$one->id}}, '{{$one->firstname}} {{$one->lastname}}', '{{$one->home_address}}', '{{$one->office_address}}');">
                    <div class="row">
                        <div class="col-md-6">{{$one->firstname}} {{$one->lastname}}</div>
                        <div class="col-md-6">{{$one->email}}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" charset="utf-8" >
      var modal = document.getElementById("myModal");
      var span = document.getElementsByClassName("close")[0];
      span.onclick = function() {
        modal.style.display = "none";
      }
      window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
      }

      function showPopup() {
        modal.style.display = "block";
      }
</script>
{{-- Title --}}
<div class="row py-4">
  <div class="col-md-12">
    <a onclick="openNav()"><i class="fa fa-bars p-4"></i></a>
    <span class="text-center font-weight-bold text-dark maintitle">Create a booking</span>
  </div>
</div>
{{-- Customer Line Input --}}
<div class="px-4 row">
  <div class="col-md-12">
    <span class="font-weight-bold">Customer</span>
    <div class="wrapper p-2"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-12 autocomplete">
    <input class="border-none background-white-50 outline-none customInputWidth" id="customer" name="customer" placeholder="Type name" onchange="CustomerNameChanged(this);" required />
    <label for="customer">
      <span onclick="showPopup();"><i class="fa fa-user"></i></span>
    </label>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
{{-- Date Select --}}
<div class="px-4 row">
  <div class="col-md-12">
    <div class="wrapper p-2"></div>
    <span class="font-weight-bold">Date and Time</span>
    <div class="py-3" id="date_selector">
      <div class="wrapper py-3 pl-2 font80 calendar-day calendar-day-selected">Today, <?php echo $today->format('F, d, Y'); ?></div>
      <div class="wrapper py-3 pl-2 font80 calendar-day">Tomorrow, <?php echo $tomorrow->format('F, d, Y'); ?></div>
      <div class="wrapper py-3 pl-2 font80 calendar-day"><?php echo $date3->format('l, F, d, Y'); ?></div>
      <div class="wrapper py-3 pl-2 font80 calendar-day"><?php echo $date4->format('l, F, d, Y'); ?></div>
      <div class="wrapper py-3 pl-2 font80 calendar-day"><?php echo $date5->format('l, F, d, Y'); ?></div>

      <label class="control-label font80 py-2">Select another date</label>
      <div class='input-group date' id='datetimepicker1'>
        <input type='date' class="form-control" id="other_date" value="<?php echo $today->format('Y-m-d'); ?>" onchange="DateChanged();" />
        <span class="input-group-addon">
          <label for="other_date"><span class="glyphicon glyphicon-calendar"></span></label>
        </span>
      </div>
    </div>
  </div>
</div>
{{-- Time Select --}}
<div class="px-4" id="time_selector">
    <div class="px-4 row">
        <div class="col-md-5">
            <?php
            for($i = 0; $i < 4; $i++) {
                echo '<div class="row">';
                for($j = 0; $j < 3; $j++) {
                    $time = ($i * 3) + $j + 1;
                    $string = str_pad( $time, 2, '0', STR_PAD_LEFT);
                    echo '<div class="col-md-4 px-0 py-2 text-center"><div class="px-2"><div class="py-4 time-cell ';
                    if( $i == 0 && $j == 0 ) {
                        echo 'time-cell-selected';
                    }
                    echo '">'.$string.'</div></div></div>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="col-md-2" style="align-self:center;">
            <div class="row">
            <div class="col-md-12 px-0 py-2 text-center"><div class="px-2"><div class="py-4 timetype-cell timetype-selected">am</div></div></div>
            </div>
            <div class="row">
            <div class="col-md-12 px-0 py-2 text-center"><div class="px-2"><div class="py-4 timetype-cell">pm</div></div></div>
            </div>
        </div>
        <div class="col-md-5">
            <?php
            for($i = 0; $i < 4; $i++) {
                echo '<div class="row">';
                for($j = 0; $j < 3; $j++) {
                    $time = ($i * 3) + $j;
                    $string = str_pad( $time * 5, 2, '0', STR_PAD_LEFT);
                    echo '<div class="col-md-4 px-0 py-2 text-center"><div class="px-2"><div class="py-4 minute-cell ';
                    if( $i == 0 && $j == 0 ) {
                        echo 'minute-selected';
                    }
                    echo '">'.$string.'</div></div></div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
{{-- Ride Details --}}
<div class="p-4 row">
  <div class="col-md-12">
    <span class="font-weight-bold">Ride Details</span>
    <div class="wrapper p-2"></div>
  </div>
</div>
<div class="px-4 row">
  <div class="col-md-6">
    <input class="text-center p-4 wrapper ride-button ride-selected" id="ride_transfer" name="ride_transfer" type="button" value="Transfer"/>
  </div>
  <div class="col-md-6">
    <input class="text-center p-4 wrapper ride-button" id="ride_hourly" name="ride_hourly" type="button" value="Hourly"/>
  </div>
</div>
{{-- Source Address Pick --}}
<div class="px-4 pt-5 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none customInputWidth" id="src-address" name="address" placeholder="Pick up address" onchange="SourceAddressChanged(this);" onfocus="geolocate();"/>
    <label for="address">
      <span><i class="fa fa-map-marker"></i></span>
    </label>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-5 py-3 row">
  <div class="col-md-3 px-1">
    <input class="text-center p-2 wrapper src-address" id="start_home" name="start_home" type="button" value="Home"/>
  </div>
  <div class="col-md-3 px-1">
    <input class="text-center p-2 wrapper src-address" id="start_office" name="start_office" type="button" value="Office"/>
  </div>
  <div class="col-md-3 px-1">
    <input class="text-center p-2 wrapper src-address" id="start_dfw" name="start_dfw" type="button" value="DFW"/>
  </div>
  <div class="col-md-3 px-1">
    <input class="text-center p-2 wrapper src-address" id="start_dal" name="start_dal" type="button" value="DAL"/>
  </div>
</div>
{{-- Destination Address Pick --}}
<div class="px-4 pt-5 row">
  <div class="col-md-12">
    <input class="border-none background-white-50 outline-none customInputWidth" id="dst-address" name="address" placeholder="Destination address" onchange="DestAddressChanged(this);" onfocus="geolocate();"/>
    <label for="address">
      <span><i class="fa fa-map-marker"></i></span>
    </label>
    <div class="wrapper p-2"></div>
    <div class="stroke-line wrapper"></div>
  </div>
</div>
<div class="px-5 py-3 row">
  <div class="col-md-3 px-1">
    <input class="text-center p-2 wrapper dst-address" id="dest_home" name="dest_home" type="button" value="Home"/>
  </div>
  <div class="col-md-3 px-1">
    <input class="text-center p-2 wrapper dst-address" id="dest_office" name="dest_office" type="button" value="Office"/>
  </div>
  <div class="col-md-3 px-1">
    <input class="text-center p-2 wrapper dst-address" id="dest_dfw" name="dest_dfw" type="button" value="DFW"/>
  </div>
  <div class="col-md-3 px-1">
    <input class="text-center p-2 wrapper dst-address" id="dest_dal" name="dest_dal" type="button" value="DAL"/>
  </div>
</div>
{{-- Duration Set --}}
<div class="px-4 pt-4 row duration_box" style="display:none;">
  <div class="col-md-4 py-3">
    <span class="font-weight-bold">Duration</span>
  </div>
  <div class="col-md-8">
    <div class="row">
        <div class="col-md-3 text-right p-3"><i class="fa fa-minus" onclick="DurationMinus();"></i></div>
        <div class="col-md-6 text-center">
            <input class="border-none p-3 background-white outline-none customInputWidth text-center" type="number" min="0" max="999" name="duration" value="0" id="duration" onchange="DurationChanged(this);"/>
        </div>
        <div class="col-md-3 text-left p-3"><i class="fa fa-plus" onclick="DurationPlus();"></i></div>
    </div>
  </div>
</div>
{{-- Vehicle Selector --}}
<div class="px-4 pt-5 row">
  <div class="col-md-12">
    <span class="font-weight-bold">Vehicles</span>
    <div class="wrapper p-2"></div>
  </div>
</div>
<div class="px-5 pt-3 row">
  <div class="col-md-12">
      <?php for($i = 0; $i < count($vehicles); $i ++ ) {?>
        @if ($i % 3 == 0) <div class="row"> @endif
          <div class="col-md-4 p-2">
              {{-- One Vehicle --}}
              <div class="vehicle-cell <?php if($i == 0) echo 'vehicle-selected'; ?>" idinfo="{{$vehicles[$i]->id}}">
                <div class="row py-2"><div class="col-md-12">{{$vehicles[$i]->Type_make}}</div></div>
                <div class="row py-2"><div class="col-md-12">{{$vehicles[$i]->Type_model}}</div></div>
                <div class="row py-2">
                    <div class="col-md-6 font70 p-0 pl-4 text-center">${{$vehicles[$i]->Price_hour}}/h</div>
                    <div class="col-md-6 font70 p-0 pr-4 text-center">${{$vehicles[$i]->Price_mile}}/mi</div>
                </div>
                <div class="row py-3"><div class="col-md-12 font70">{{$vehicles[$i]->License_plate}}</div></div>
              </div>
              {{-- End Vehicle --}}
          </div>
        @if ($i % 3 == 2 || $i == (count($vehicles) - 1)) </div>@endif
      <?php } ?>
  </div>
</div>
{{-- Passengers --}}
<div class="px-4 pt-5 row">
  <div class="col-md-12">
    <span class="font-weight-bold">Passengers</span>
    <div class="wrapper p-2"></div>
  </div>
</div>
<div class="px-4 pt-3 row">
  <div class="col-md-8">
    <div class="row">
        <div class="col-md-3 text-right p-3"><i class="fa fa-minus" onclick="PassengerMinus();"></i></div>
        <div class="col-md-6 text-center">
            <input class="border-none p-3 background-white outline-none customInputWidth text-center" type="number" min="1" max="999" name="passenger" value="1" id="passenger" onchange="PassengerChanged(this);"/>
        </div>
        <div class="col-md-3 text-left p-3"><i class="fa fa-plus" onclick="PassengerPlus();"></i></div>
    </div>
  </div>
</div>
<div class="row px-5 pt-5">
    <input class="wrapper border-none background-white-50 outline-none" name="passenger_name" placeholder="Passenger's name" oninput="PassengerNameChanged(this);"/>
    <div class="stroke-line wrapper pb-5"></div>
</div>
<div class="row px-5 pt-3">
    <input class="wrapper border-none background-white-50 outline-none" name="passenger_phone" placeholder="Passenger's phone#" oninput="PassengerPhoneChanged(this);" minlength="10" maxlength="10"/>
    <div class="stroke-line wrapper pb-5"></div>
</div>
{{-- Next --}}
<form action="/confirm-step1" method="POST" id="bookingForm">
    {{ csrf_field() }}
    <input type="hidden" name="customer-name" id="form-data-customer-name" required/>
    <input type="hidden" name="date"   id="form-data-date" value="{{$today->format('Y-m-d')}}" required/>
    <input type="hidden" name="hour"   id="form-data-hour" value="01" required/>
    <input type="hidden" name="time-t" id="form-data-time-t" value="am" required/>
    <input type="hidden" name="minute" id="form-data-minute" value="00" required/>
    <input type="hidden" name="ride"   id="form-data-ride" value="Transfer" required/>
    <input type="hidden" name="src-address" id="form-data-src-address" value="" required/>
    <input type="hidden" name="src-address-t" id="form-data-src-address-t" value="Home" required/>
    <input type="hidden" name="dst-address" id="form-data-dst-address" value="" required/>
    <input type="hidden" name="dst-address-t" id="form-data-dst-address-t" value="Home" required/>
    <input type="hidden" name="duration" id="form-data-duration" value="0" required/>
    <input type="hidden" name="vehicle"  id="form-data-vehicle" value="<?php if(count($vehicles)) echo $vehicles[0]->id; ?>" required/>
    <input type="hidden" name="passenger-count" id="form-data-passenger-count" value="1" required/>
    <input type="hidden" name="passenger-name" id="form-data-passenger-name" value="" />
    <input type="hidden" name="passenger-phone" id="form-data-passenger-phone" value="" />
    <div id="VariationAlert">
        Complete The Form Please!
    </div>
<div class="px-4 py-5 row">
  <div class="col-md-12">
    <input class="text-center p-4 wrapper selectable-button-selected" style="color:white;" id="next_step" name="next" type="submit" value="Next"/>
  </div>
</div>
</form>
<script type="text/javascript" charset="utf-8">
    var CustomerData = <?php echo json_encode($customers); ?>;
    var CustomerNameArr = [];
    for( var i = 0; i < CustomerData.length; i ++ )
        CustomerNameArr.push(CustomerData[i].firstname + ' ' + CustomerData[i].lastname);
    // Google Place AutoComplete
    var placeSearch, autocomplete, autocomplete2;
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('src-address'), {types: ['geocode']});
        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete2 = new google.maps.places.Autocomplete(
            document.getElementById('dst-address'), {types: ['geocode']});
        autocomplete2.setFields(['address_components', 'geometry', 'icon', 'name']);
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
