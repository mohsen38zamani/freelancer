<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
<h2>Welcome to the site.
    <br/>
    Dear {{$user_profileid['name'] . ' ' . $user_profileid['family']}}.</h2>
<br/>
Your registered email-id is {{$user_profileid['user']['email']}} , Please click on the below link to verify your email account
<br/>
<a href="{{url('user/mail_verify', $user_profileid->verify_user->token)}}">Verify Email</a>
</body>
</html>
