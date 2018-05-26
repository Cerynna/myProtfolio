window.addEventListener('wheel', function (e) {
    if (e.target.className != "img-fluid img-prod") {
        let postionBottom = $('html').height();
        if (e.deltaY < 0 && $(document).scrollTop() === 0) {
            $(document).scrollTop(postionBottom)
            $('nav ul').fadeOut(1);
            $("header").fadeTo(1000, 1, function () {
                // Animation complete.
            });
        }
        if (e.deltaY > 0 && $(document).scrollTop() >= (postionBottom - 1500)) {
            $(document).scrollTop(0)
        }
    }


});

$(document).ready(function () {
    $(document).scroll(function () {
        /* if ((document.documentElement.clientHeight + $(document).scrollTop()) >= document.body.offsetHeight) {
             $(document).scrollTop(0);
         }*/
        /*            if ($(document).scrollTop() >= (document.documentElement.clientHeight / 2)) {
                        $('.scrollToBottom').hide();
                    }*/
        let articles = $('article').toArray();
        let hauteurTotal = $('header').height() + $('nav').height() + 200;
        articles.forEach(function (oneArticle) {
            hauteurTotal = hauteurTotal + $(oneArticle).height()
        });

        if ($(document).scrollTop() >= hauteurTotal) {
            $('nav ul').fadeOut(1000);
        }
        if ($(document).scrollTop() <= hauteurTotal) {
            $('nav ul').fadeIn(500);
            $('header').fadeIn(500);
        }
    });

    $('nav').hover(function () {
        $('nav ul').fadeIn(100);
    });

    setTimeout(function () {
        $('.button').fadeIn(1000).delay(10000).fadeOut(1000)
        setInterval(function () {
            $('.button').fadeIn(1000).delay(10000).fadeOut(1000)
        }, 60000)
    }, 5000);


    $('[data-toggle="popover"]').popover();
});
$('header').fadeTo(1000, 1, function () {
    // Animation complete.
});
$('nav').fadeTo(1000, 1, function () {
    // Animation complete.
});

function validateEmail(email) {
    let re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    return re.test(email);
}
