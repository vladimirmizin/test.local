@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Комментарии</div>

                <div class="card-body">
                    <form method="post" action="{!! route('add_comment') !!}">
                        {!! csrf_field() !!}
                        <p>Тема<br>
                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title">
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        <p>Комментарий:<br>
                            <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" name="body">{!! old('body') !!}
                            </textarea>
                        </p>
                        @if ($errors->has('body'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                </span>
                        @endif
                        <br>
                        <button type="submit" class="btn btn-success" style="cursor:pointer;">Добавить комментарий</button>
                    </form>
                    <hr>
                    @if($comments)
                        <ul style="list-style: none; padding: 0">
                            @foreach($comments as $comment)
                                <li class="panel-body">
                                    <div class="form-group">
                                        <div class="list-group-item">
                                            <h3>{{ $comment->title }}</h3>
                                            <hr>
                                            <p>{{ $comment->body }}</p>
                                        </div>
                                        <p>created by: {{ $comment->author->name }}, {{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
