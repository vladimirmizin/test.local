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
                                <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                       name="title">
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                            <p>Комментарий:<br>
                                <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}"
                                          name="body" >{!! old('body') !!}

                            </textarea>
                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                             </span>
                                @endif
                            </p>
                            <br>
                            <button type="submit" class="btn btn-success" style="cursor:pointer;">Добавить комментарий</button>
                        </form>
                        <hr>
                        @if(isset($comments))
                            <ul style="list-style: none; padding: 0">
                                @foreach($comments as $comment)
                                    <li class="panel-body">
                                        <div class="form-group">
                                            <div class="list-group-item">
                                                <div class="col-md-4"><h3>{{ $comment->title }}</h3></div>
                                                <hr>
                                                <div class="col-md-12">{{ $comment->body }}</p>
                                                </div>
                                                <p>created by: {{ $comment->author->name }}
                                                    , {{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                                @if($comment->user_id == auth()->user()->id)
                                                    <a href="{!! route('destroy_comment', ['id' => $comment->id]); !!}">Удалить</a>
                                                    <a href="{!! route('edit_comment', ['id' => $comment->id]); !!}">Редактировать</a>
                                                @endif
                                                <form method="post" action="{!! route('add_comment') !!}">
                                                    {!! csrf_field() !!}
                                                    <p>Комментарий:<br>
                                                        <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}"
                                                                  name="body" >{!! old('body') !!}
                                                        </textarea>
                                                        @if ($errors->has('body'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('body') }}</strong>
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <br>
                                                    <button type="submit" class="btn btn-success" style="cursor:pointer;">Добавить комментарий</button>
                                                </form>
                                            </div>
                                        </div>
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
