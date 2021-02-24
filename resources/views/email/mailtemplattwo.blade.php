<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    
    <h1>This is your Email address</h1>
    <p>{{ $details['email'] }}</p>
    <p><a href="{{url('verify/'.$details['token'])}}">Click Here</a> To Verify Your mail</p>
   
    <p>Thank you</p>
</body>
</html>