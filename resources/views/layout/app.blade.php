<html>
  <head>
    <title>Online Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('/css/style.css')}}">
    <link rel="stylesheet" href="{{url('/css/custom.css')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" rel="stylesheet">
  </head>
  <body>
    <div class="container background-white-50 b-1-dark h5" id="mydiv" style="margin-top: 0px; margin-bottom: 0px;">
      <div id="mySidenav" class="sidenav">
        <div class="innerSidenav" id="innerSidenav">
        <span class="menutitle">Menu</span>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div><img class="wrapper p-5 back-white my-4" src="{{URL::to('/images')}}/Logo.png"/></div>
        <a href="/home" class="font140"><i class="fa fa-book color-sky pr-3 font140 py-1 minwidth50"></i><span class="font80">Create a booking</span></a>
        <a href="/customers" class="font140"><i class="fa fa-folder color-sky pr-3 font140 py-1 minwidth50"></i><span class="font80">Customers</span></a>
        <a href="/vehicles" class="font140"><i class="fa fa-car color-sky pr-3 font140 py-1 minwidth50"></i><span class="font80">Vehicles</span></a>
        <a href="/profile" class="font140"><i class="fa fa-eye color-sky pr-3 font140 py-1 minwidth50"></i><span class="font80">Profile</span></a>
        <a href="/settings" class="font140"><i class="fa fa-cog color-sky pr-3 font140 py-1 minwidth50"></i><span class="font80">Settings</span></a>
        <a href="/logout" class="font140"><i class="fa fa-power-off color-sky pr-3 font140 py-1 minwidth50"></i><span class="font80">Log Out</span></a>
        </div>
      </div>
      @yield('content')
    </div>

    {{-- <script src="{{url('js/jquery.min.js')}}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="{{url('js/bootstrap.min.js')}}"></script>
    <script src="{{url('js/custom.js')}}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script> --}}
  </body>
</html>
