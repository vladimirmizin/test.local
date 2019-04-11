@extends('layouts.app')

@section('content')
    <script>
        $(document).ready(function () {
            $('#country_id').change(function () {
                var country_id = $(this).val();
                var url = '/get-regions';
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        country_id: country_id
                    },
                    success: function (result) {
                        var regions = result.regions;
                        var regionsSelect = $('#region_id');
                        regionsSelect.html('')
                            .prop('disabled', false);

                        regionsSelect.append('<option value="0">Не выбрано</option>');
                        $.each(regions, function (key, value) {
                            regionsSelect.append('<option value="' + value.id + '">' + value.region + '</option>');
                        });
                    },
                });

                $('#region_id').trigger('change');
            });

            $('#region_id').change(function () {
                var region_id = $(this).val();
                var url = '/get-cities';
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        region_id: region_id
                    },
                    success: function (result) {
                        var cities = result.cities;
                        var citiesSelect = $('#city_id');
                        citiesSelect.html('')
                            .prop('disabled', false);
                        citiesSelect.append('<option value="0">Не выбрано</option>');
                        $.each(cities, function (key, value) {
                            citiesSelect.append('<option value="' + value.id + '">' + value.city + '</option>');
                        });
                    },
                });
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
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="conry" class="col-md-4 col-form-label text-md-right">Страна</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="country_id" id="country_id"
                                            class="StyleSelectBox">
                                        <option value="0">- выберите страну -</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->country}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="region" class="col-md-4 col-form-label text-md-right">Область</label>
                                <div class="col-md-6">
                                    <select class="form-control StyleSelectBox" name="region_id" id="region_id">
                                        <option value="0">- выберите область -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city"
                                       class="col-md-4 col-form-label text-md-right">Город</label>
                                <div class="col-md-6">
                                    <select class="form-control StyleSelectBox" name="city_id" id="city_id">
                                        <option value="0">- выберите город -</option>
                                    </select>
                                </div>
                            </div>
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
