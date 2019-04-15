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