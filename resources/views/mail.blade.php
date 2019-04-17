<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>HTML письмо</title>
    <meta name="description" content="HTML письмо"/>
</head>
<div style="background-color:white">
    <div style="width:700px;margin:0px auto;border:1px solid black">
        <div style="margin-top:40px;width:700px;text-align:center;font-family:verdana,tahoma,arial;font-size:30px;color:#e30613;font-weight:bold;">
            <p>Уважаемый {{$parentComment->author->name}}</p>
        </div>
    </div>
    <div style="width:700px;margin:0px auto;border:1px solid black">
        <div style="margin-top:30px; width:700px;text-align:center;font-family:verdana,tahoma,arial;font-size:18px;color:#000000;font-weight:bold;">
           <p>На ваш комментарий: <br> {{$parentComment->body}} <br> от {{$parentComment->created_at}} ответил:</p>
            <br>
            <p>{{$subComment->author->name}},{{$subComment->author->email}},"{{$subComment->body}}" </p>
            <br>
            <a href="{!! route('home',['open' => $parentComment->id]) .'#comment'.$parentComment->id!!}">Ответить</a>
        </div>
        <div style="margin-top:15px;width:700px;text-align:center;font-family:verdana,tahoma,arial;font-size:30px;color:#898989;font-weight:bold;">
            <b style="font-size:22px;">С уважениеам, администрация test.ru</b>
        </div>
    </div>
</div>
</div>
</html>