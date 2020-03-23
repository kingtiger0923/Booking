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
  </head>
  <body>
  <div class="container background-white-50 b-1-dark h3 mt-0" id="mydiv">
    <div  class="p-4 p-md-5 pt-5">
    <div class="row">
      <h1 class="text-center wrapper font-weight-bold text-dark">Sign in</h1>
    </div>
    <div class="row">
      <img class="wrapper p-logo" src="{{URL::to('/images')}}/Logo.png"/>
    </div>
    <form action="{{ url('auth/login') }}" method="post">
      {{ csrf_field() }}
      @if ($errors->any())
        <div class="row error_msg">
        {{$errors->first()}}
        </div>
      @endif

      <div class="row">
      <input class="wrapper border-none background-white-50 outline-none" name="email" placeholder="email"/>
      <div class="stroke-line wrapper pb-5"></div>
      </div>

      <div class="row">
      <input class="wrapper border-none background-white-50 outline-none" name="password" type="password" placeholder="password"/>
      <div class="stroke-line wrapper pb-5"></div>
      </div>

      <div class="row">
      <a href="#" class="text-right text-primary wrapper normalfont">Forgot Password?</a>
      </div>

      <div class="row">
      <input class="resolution-12 normalfont" type="checkbox" id="remember" name="remember" value="remember"/>
      <label for="remember" class="normalfont">&nbsp;&nbsp;Remember Me</label>
      </div>

      <div class="row">
      <button type="submit" class="border-radius-50 wrapper border-none p-4 text-white font-weight-bold mt-5">Sign in</button>
      </div>
    </form>
    </div>
  </div>

  <script src="{{url('js/jquery.min.js')}}"></script>
  <script src="{{url('js/bootstrap.min.js')}}"></script>
  <script src="{{url('js/custom.js')}}"></script>
  </body>
</html>
