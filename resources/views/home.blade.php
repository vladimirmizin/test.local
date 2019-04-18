@extends('layouts.app')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.showbutton').on('click', function () {
                $(this).siblings("#showblock").toggle("slow");
            });
        });
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Комментарии</div>
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
                        @if($comments->count() > 0)
                            <ul style="list-style: none; padding: 0">
                                @foreach($comments as $comment)
                                    <li class="panel-body">
                                        <div class="form-group">
                                            <a name="comment{{$comment->id}}"></a>
                                            <div class="list-group-item" name="comment{{$comment->id}}">
                                                <div class=""><h1>Тема: {{ $comment->title }}</h1></div>
                                                <br>
                                                <div class=list-group-item"><h4>{{ $comment->body }}</h4>
                                                    @isset($comment->image)
                                                        <a href=" {{$comment->getStoragePath()}}" target="_blank"
                                                           style="font-style: italic">image</a>
                                                    @endif
                                                    <hr>
                                                    <p>created by: {{ $comment->author->name }}
                                                        , {{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                                    @if($comment->user_id == auth()->user()->id)
                                                        <a href="{!! route('destroy_comment', ['id' => $comment->id]); !!}">Удалить</a>
                                                        @if($comment->canBeModified($comment->user_id))
                                                            <a href="{!! route('edit_comment', ['id' => $comment->id]); !!}">Редактировать</a>
                                                        @endif
                                                    @endif
                                                </div>
                                                <button href="" class="showbutton"
                                                  >Оставить
                                                    комментарий</button>

                                                @php
                                                    $subCommentDisplayState = "none";
                                                @endphp
                                                @if($errors->has('sub_body' . $comment->id)|| request()->get('open') == $comment->id)
                                                    @php
                                                        $subCommentDisplayState = 'block';
                                                    @endphp
                                                @endif
                                                <div id="showblock" style="display: {{$subCommentDisplayState}}">
                                                    <form method="post"
                                                          action="{!! route('add_sub_comment'); !!}"
                                                          enctype="multipart/form-data">
                                                    <!--  <a name="comment{{$comment->id}}"></a> -->
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="parent_id"
                                                               value="{{ $comment->id }}">
                                                        <input type="hidden" name="author_id"
                                                               value="{{ $comment->user_id }}">
                                                        <input type="hidden" name="title" value="{{ $comment->title }}">
                                                        <br>
                                                        <p>Комментарий:<br>
                                                            <textarea
                                                                    class="form-control {{ old('parent_id') == $comment->id && $errors->has('sub_body' . $comment->id) ? ' is-invalid' : '' }}"
                                                                    name="{{('sub_body' . $comment->id)}}">
                                                            {!! old('sub_body' . $comment->id) !!}
                                                        </textarea>
                                                            @if (old('parent_id') == $comment->id && $errors->has('sub_body' . $comment->id))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('sub_body' . $comment->id) }}</strong>
                                                            </span>
                                                            @endif
                                                        </p>
                                                        <br>
                                                        <input type="file" name="image">
                                                        <button type="submit" class="btn btn-success"
                                                                style="cursor:pointer;">Добавить комментарий
                                                        </button>
                                                    </form>
                                                </div>
                                                <hr>
                                                @php
                                                    $latestComment = $comment->sub_comments->first();
                                                @endphp
                                                @if (!is_null($latestComment))
                                                    <div class="list-group-item">
                                                        <div class="">
                                                            <h4>{{ $latestComment->body }}</h4>
                                                        </div>
                                                        @isset($latestComment->image)
                                                            <a href="{{$latestComment->hasImage()}}" target="_blank">image</a>
                                                        @endif
                                                        <hr>
                                                        <p>created
                                                            by: {{ $latestComment->author->name }}
                                                            , {{ $latestComment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                                        @if($latestComment->user_id == auth()->user()->id)
                                                            <a href="{!! route('destroy_comment', ['id' => $latestComment->id]); !!}">Удалить</a>
                                                            @if($latestComment->canBeModified($latestComment->user_id))
                                                                <a href="{!! route('edit_comment', ['id' => $latestComment->id]); !!}">Редактировать</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endif
                                                @if($comment->sub_comments->count() > 1)
                                                    <a href=""
                                                       onclick="openbox('sub.{{$comment->id}}'); return false">Показать
                                                        все</a>
                                                    <div id="sub.{{$comment->id}}" style="display:none;">
                                                        <ul style="list-style: none; padding: 0">
                                                            @foreach($comment->sub_comments as $subComment)
                                                                @if($latestComment->id != $subComment->id)
                                                                    <div class="list-group-item">
                                                                        <div class="">
                                                                            <h4>{{ $subComment->body }}</h4>
                                                                        </div>
                                                                        @isset($subComment->image)
                                                                            <a href=" {{$subComment->hasImage()}}"
                                                                               target="_blank"
                                                                               style="font-style: italic">
                                                                                image</a>
                                                                        @endif
                                                                        <hr>
                                                                        <p>created
                                                                            by: {{ $subComment->author->name }}
                                                                            , {{ $subComment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                                                        @if($subComment->user_id == auth()->user()->id)
                                                                            <a href="{!! route('destroy_comment', ['id' => $subComment->id]); !!}">Удалить</a>
                                                                            @if($subComment->canBeModified($subComment->user_id))
                                                                                <a href="{!! route('edit_comment', ['id' => $subComment->id]); !!}">Редактировать</a>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
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
