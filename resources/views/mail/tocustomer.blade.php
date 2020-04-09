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
                    <p>Dear, {{$data['customer']}}</p>
                    <p>Your booking is confirmed for {{$data['date']}} from {{$data['src-address']}} to {{$data['dst-address']}}. There will be {{$data['passenger-count']}} passengers and our main contact is {{$data['passenger-name']}}.</p>
                    <p>Thank you for riding with us.</p>
                    <p>Sincerely</p>
                    <p>JE Private Drivers</p>
                    <div style="text-align:center; padding-top: 20px;">
                        <span style="padding: 10px 30px; border-radius: 25px; background-color: rgb(82, 144, 226); font-weight: bold; width: 100%; cursor:pointer;"><a href="" style="color: white; text-decoration: none;">Click to call us</a></span>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
