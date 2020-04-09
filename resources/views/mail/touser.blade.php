<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking</title>
</head>
<body>
    <table style="background-color: #eee; max-width: 350px;">
        <tr>
            <td style="text-align:center;">
                <p style="font-weight: bold;">Booking Confirmation</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px 15px;">
                <div style="background-color: white; border-radius: 15px; overflow:hidden; padding: 30px 10px;">
                    <div style="padding: 10px 20px;"><img src="{{url('images/Logo.png')}}" /></div>
                    <p>NEW BOOKING</p>
                    <p>Client name: {{$data['customer']}}</p>
                    <p>Date and time: {{$data['date']}}</p>
                    <p>Pickup address: {{$data['src-address']}}</p>
                    <p>Destination: {{$data['dst-address']}}</p>
                    <p>Duration: {{$data['duration']}}</p>
                    <p>Passengers: {{$data['passenger-count']}}</p>
                    <p>Passenger name: {{$data['passenger-name']}}</p>
                    <p>Passenger phone#: {{$data['passenger-phone']}}<</p>
                    <p>Vehicle:{{$vehicle['Type_make']}} {{$vehicle['Type_model']}} {{$vehicle['License_plate']}}</p>
                    <p>Price:120$</p>
                    <div style="text-align:center; padding-top: 20px;">
                        <span style="padding: 10px 30px; border-radius: 25px; background-color: rgb(82, 144, 226); font-weight: bold; width: 100%; cursor:pointer;"><a href="" style="color: white; text-decoration: none;">Go to dashboard</a></span>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
