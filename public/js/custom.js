$(document).ready(function () {

    function is_valid_url(url) {
        return /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url);
    }

    $('.form form').submit(function (e) {
        $url = $(this).find('#url_originalUrl').val();
        console.log($url);
        if(!is_valid_url($url)) {
            e.preventDefault();
            if(!$(this).find('.form-info').length)
            $(this).append('<p class="form-info">Wrong URL!</p>');
        }
    })

});