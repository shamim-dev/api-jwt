Dear <strong> {{$name}}!</strong>,
<p>
   We have got a password reset request from your account. To change your password clicking this link
    <a href="{{url('/api/account/password-reset/'.$id.'/'.$verificationToken)}}">{{$verificationToken}}</a>.

    <br><br><br>
    Thanks for being with us. <br>
    Tizaara.com

    {{--{{$body}}--}}
</p>
