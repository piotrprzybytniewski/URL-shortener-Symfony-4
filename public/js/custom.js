$(document).ready(function () {

    function is_valid_url(url) {
        return /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url);
    }

    $('.url-form form').submit(function (e) {
        $url = $(this).find('#url_originalUrl').val();
        console.log($url);
        if (!is_valid_url($url)) {
            e.preventDefault();
            if (!$(this).find('.form-info').length)
                $(this).append('<p class="form-info">Wrong URL!</p>');
        }
    });

    $(document).on('click', '.copyToClipboard', function () {
        $(this).attr('data-tooltip', 'Copied!');
        setTimeout(function () {
            $('.copyToClipboard').removeAttr('data-tooltip');
        }, 1300);

        let href = $(this).prev().attr('href');
        let $temp = document.createElement("textarea");
        $temp.value = href;
        document.body.appendChild($temp);
        $temp.select();
        document.execCommand('copy');
        $temp.remove();
        console.log(href);
    });


    $('#open-links').submit(function (e) {
        e.preventDefault();
        if (!$('.blink-message').length) {
            $(this).after("<p class='blink-message blink'>If all the URLs haven't been opened, it means that your browser doesn't" +
                "<br> Possible that at the top of the browser window you can permit this setting!"
                + " allow you to open pop-up windows. <br> You can change your browser settings or open addresses one by one :(</p>");

            setTimeout(function(){
                $('.blink-message').removeClass('blink');
            }, 11000);
        }

        $('.url-list-item').each(function () {
            let url = $(this).find('.url-to-redirect');
            let href = url.attr('href');
            window.open(href);
        });
        return false;
    });


});