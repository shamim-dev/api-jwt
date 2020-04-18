Hi <strong> {{$name}}!</strong>,
<p>
    Your are one step away to create tizaara acount. To complete registration please verify email via clicking this link
    <a href="{{url('/api/account/verify-token/'.$id.'/'.$verificationToken)}}">{{$verificationToken}}</a>.

    <br><br><br>
    Thanks for being with us. <br>
    Tizaara.com

    {{--{{$body}}--}}
</p>
