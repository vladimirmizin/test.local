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
                                       name="title" value="{!! old('title') !!}">
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                            <p>Комментарий:<br>
                                <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}"
                                          name="body">{!! old('body') !!}

                            </textarea>
                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                             </span>
                                @endif
                            </p>
                            <br>
                            <button type="submit" class="btn btn-success" style="cursor:pointer;">Добавить комментарий
                            </button>
                        </form>
                        <hr>
                        @if(isset($comments))
                            <ul style="list-style: none; padding: 0">
                                @foreach($comments as $comment)
                                    <li class="panel-body">
                                        <div class="form-group">
                                            <div class="list-group-item">
                                                <div class=""><h1>Тема: {{ $comment->title }}</h1></div>
                                                <br>
                                                <div class=list-group-item"><h4>{{ $comment->body }}</h4>
                                                    <hr>
                                                    <p>created by: {{ $comment->author->name }}
                                                        , {{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                                    @if($comment->user_id == auth()->user()->id)
                                                        <a href="{!! route('destroy_comment', ['id' => $comment->id]); !!}">Удалить</a>
                                                        <a href="{!! route('edit_comment', ['id' => $comment->id]); !!}">Редактировать</a>
                                                    @endif
                                                </div>
                                                <form method="post"
                                                      action="{!! route('add_sub_comment', ['parent_id' => $comment->id, 'title' => $comment->title]); !!}">
                                                    {!! csrf_field() !!}
                                                    <br>
                                                    <p>Комментарий:<br>
                                                        <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" name="body">
                                                            {!! old('body') !!}
                                                        </textarea>
                                                        @if ($errors->has('body'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('body') }}</strong>
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <br>
                                                    <button type="submit" class="btn btn-success"
                                                            style="cursor:pointer;">Добавить комментарий
                                                    </button>
                                                    <hr>
                                                    @if(isset($subComments))
                                                        <ul style="list-style: none; padding: 0">
                                                            @foreach($subComments as $subComment)
                                                                @if(($subComment->parent_id == $comment->id))
                                                                    <li class="panel-body">
                                                                        <div class="form-group">
                                                                            <div class="list-group-item">
                                                                                <div class=""><h4>{{ $subComment->body }}</h4>
                                                                                </div>
                                                                                <hr>
                                                                                <p>created
                                                                                    by: {{ $subComment->author->name }}
                                                                                    , {{ $subComment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                                                                @if($subComment->user_id == auth()->user()->id)
                                                                                    <a href="{!! route('destroy_comment', ['id' => $subComment->id]); !!}">Удалить</a>
                                                                                    <a href="{!! route('edit_comment', ['id' => $subComment->id]); !!}">Редактировать</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
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
