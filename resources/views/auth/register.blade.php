@extends('layouts.app')

@section('content')
<script>
    $(document).ready(function () {
        $('#country_id').change(function () {
            var country_id = $(this).val();
            if (country_id == '0') {
                $('#region_id').html('<option>- выберите регион -</option>');
                $('#region_id').attr('disabled', true);
                $('#city_id').html('<option>- выберите город -</option>');
                $('#city_id').attr('disabled', true);
                return(false);
            }
            $('#region_id').attr('disabled', true);
            $('#region_id').html('<option>загрузка...</option>');

            var url = 'get_regions.php';

            $.get(
                url,
                "country_id=" + country_id,
                function (result) {
                    if (result.type == 'error') {
                        alert('error');
                        return(false);
                    }
                    else {

                        var options = '';

                        $(result.regions).each(function() {

                            options += '<option value="' + $(this).attr('region_id') + '">' + $(this).attr('name') + '</option>';
                        });

                        $('#region_id').html('<option value="0">- выберите регион -</option>'+options);
                        $('#region_id').attr('disabled', false);
                        $('#city_id').html('<option>- выберите город -</option>');
                        $('#city_id').attr('disabled', true);
                    }
                },
                "json"
            );
        });


        $('#region_id').change(function () {
            var region_id = $('#region_id :selected').val();
            if (region_id == '0') {
                $('#city_id').html('<option>- выберите город -</option>');
                $('#city_id').attr('disabled', true);
                return(false);
            }
            $('#city_id').attr('disabled', true);
            $('#city_id').html('<option>загрузка...</option>');
            var url = 'get_city.php';
            $.get(
                url,
                "region_id=" + region_id,

                function (result) {
                    if (result.type == 'error') {
                        alert('error');
                        return(false);
                    }
                    else {
                        var options = '';
                        $(result.citys).each(function() {
                            options += '<option value="' + $(this).attr('city_id') + '">' + $(this).attr('name') + '</option>';
                        });

                        $('#city_id').html('<option>- выберите город -</option>'+options);
                        $('#city_id').attr('disabled', false);
                    }
                },
                "json"
            );
        });
    });
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <form action="#" method="get">
                            Страна:<br />
                            <select name="country_id" id="country_id" class="StyleSelectBox">
                                <option value="0">- выберите страну -</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->country}}</option>
                                @endforeach
                            </select></td><td>
                                Регион:<br />
                                <select name="region_id" id="region_id" disabled="disabled" class="StyleSelectBox">
                                    <option value="0">- выберите регион -</option>
                                </select></td><td>
                                Город:<br />
                                <select name="city_id" id="city_id" disabled="disabled" class="StyleSelectBox">
                                    <option value="0">- выберите город -</option>
                                </select>
                        </form>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
