@extends('layouts.app')
@section('content')
    <script type="text/javascript">
        function openbox(id) {
            display = document.getElementById(id).style.display;
            if (display == 'none') {
                document.getElementById(id).style.display = 'block';
            } else {
                document.getElementById(id).style.display = 'none';
            }
        }
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Комментарии</div><script type="text/javascript"> $(document).ready(function(){ alert(jQuery.fn.jquery); }); </script>
                    <div class="card-body">
                        <form method="post" action="{!! route('add_comment') !!}" enctype="multipart/form-data">
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
                            <input type="file" name="image">
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
                                                    @isset($comment->image)
                                                        <p style="font-style: italic">file:
                                                            storage/public/{{$comment->image}}</p>
                                                    @endif
                                                    <hr>
                                                    <p>created by: {{ $comment->author->name }}
                                                        , {{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                                    @if($comment->user_id == auth()->user()->id)
                                                        <a href="{!! route('destroy_comment', ['id' => $comment->id]); !!}">Удалить</a>
                                                        @if($comment->canBeModifies())
                                                            <a href="{!! route('edit_comment', ['id' => $comment->id]); !!}">Редактировать</a>
                                                        @endif
                                                    @endif
                                                </div>
                                                <a href=""
                                                   onclick="openbox('{{$comment->id}}'); return false">Показать</a>
                                                <form method="post" id="{{$comment->id}}" style="display:none;"
                                                      action="{!! route('add_sub_comment', ['parent_id' => $comment->id, 'title' => $comment->title]); !!}"
                                                      enctype="multipart/form-data"
                                                >
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <br>
                                                    <p>Комментарий:<br>
                                                        <textarea
                                                                class="form-control {{ old('parent_id') == $comment->id && $errors->has('sub_body') ? ' is-invalid' : '' }}"
                                                                name="sub_body">
                                                            {!! old('sub_body') !!}
                                                        </textarea>
                                                        @if (old('parent_id') == $comment->id && $errors->has('sub_body'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('sub_body') }}</strong>
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <br>
                                                    <input type="file" name="image">
                                                    <button type="submit" class="btn btn-success"
                                                            style="cursor:pointer;">Добавить комментарий
                                                    </button>
                                                </form>
                                                <hr>
                                                @if(isset($subComments))
                                                    <ul style="list-style: none; padding: 0">
                                                        @foreach($subComments as $subComment)
                                                            @if(($subComment->parent_id == $comment->id))
                                                                <li class="panel-body">
                                                                    <div class="form-group">
                                                                        <div class="list-group-item">
                                                                            <div class="">
                                                                                <h4>{{ $subComment->body }}</h4>
                                                                            </div>
                                                                            @isset($subComment->image)
                                                                                <p style="font-style: italic">file:
                                                                                    storage/public/{{$subComment->image}}</p>
                                                                            @endif
                                                                            <hr>
                                                                            <p>created
                                                                                by: {{ $subComment->author->name }}
                                                                                , {{ $subComment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                                                            @if($subComment->user_id == auth()->user()->id)
                                                                                <a href="{!! route('destroy_comment', ['id' => $subComment->id]); !!}">Удалить</a>
                                                                                @if($subComment->canBeModifies())
                                                                                    <a href="{!! route('edit_comment', ['id' => $subComment->id]); !!}">Редактировать</a>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
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
