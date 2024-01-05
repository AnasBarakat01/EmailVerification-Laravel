<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
</head>
<body>
    
    <img src="\images\recieveEmail.jpg" width="250" height="250">
<h3>
    <p>We have sent an activitation link to your email address <i>{{$email}}</i></p>
    <p>Click it to verify your account</p>
    <p>didn't recieve an email ??
        @php
            $activitationLink = '/'.'resendVerificationEmail/'.$email.'/'.$activitationCode;
        @endphp
    </p>

    <form action={{ $activitationLink }} method="GET" >
    <input type="button" id="myButton" 
            value="Resend" onclick="doSomething()">
    </form>
    <script>
        function doSomething () {
          // Disable the button
          document.getElementById("myButton").disabled = true;
  
        }
    </script>
</h3>
</body>
</html>