@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Редактировать комментарий</div>
                    <div class="card-body">
                        <form method="post" action="">
                            {!! csrf_field() !!}
                            <p>Тема<br>
                                <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                       name="title" value="{{ old('title', $comment->title) }}">
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            <p>Комментарий:<br>
                                <textarea class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}"
                                          name="body">{{ old('body', $comment->body) }}
                                </textarea>
                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </p>
                            <br>
                            <button type="submit" class="btn btn-success" style="cursor:pointer;">Сохранить</button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
