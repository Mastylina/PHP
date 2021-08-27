$( document ).ready(function() {
    var Key = 'b006e3c5-15e2-48dc-ae86-f4504cf645a7';
    $('#ajax_form').submit(function (e) {
        e.preventDefault();
        var adress = $(this).find($('#input_adress')).val();
        $.ajax({
            url: "https://geocode-maps.yandex.ru/1.x/?apikey=" + Key +"&format=json&geocode=" + adress,
            success: function (response) {
                var adress = response.response.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.text;
                $('#adress').html(
                    adress
                );
                var points = response.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos;
                $('#point').html(
                    points
                );
                $.ajax({
                    url: "https://geocode-maps.yandex.ru/1.x/?apikey=" + Key +"&format=json&kind=metro&geocode=" + points,
                    success: function (resp) {
                        var metro = resp.response.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.text;
                        var metroPoint = resp.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos;
                        $('#metro').html(
                            metro+'; '+metroPoint
                        );
                    }
                });
            }
        })
    });
});