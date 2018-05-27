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
    $('.myFlash .close').hover(function () {
        $(".myFlash").fadeOut(100);
        $(".myFlash .message").removeClass("valid error wtf").html("");
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

function checkForm(data = null) {
    /*console.log("CHECK");*/

    let email = $('#email').val();
    let message = $('#message').val();
    if (data !== null) {
        email = data[2].value;
        message = data[3].value;
    }

    let button = $('.submitContact');
    let errors = [];
    let verif = false;
    if (email.length >= 5) {
        if (validateEmail(email)) {
            verif = true;
        } else {
            errors.push("Ton email n'est pas valide");
            verif = false;
        }
    } else {
        errors.push("Il te faut remplir ton email");
        verif = false;
    }
    if (message.length >= 5) {
        verif = true;
    } else {
        if (errors.length > 0) {
            errors.push("et ton message n'est pas rempli");
        } else {
            errors.push("Il te faut remplir ton Message");
        }


        verif = false;
    }


    if (verif === true) {
        button.removeClass("disabled").popover('disable');
    }
    else {
        let test = errors.join(" ");
        button.addClass("disabled").popover('enable');
        button.attr('data-content', test + ".");
    }
    return verif;

}

function addFlash(type, text) {
    $(".myFlash .message").addClass(type).html(text);
    $(".myFlash").fadeIn(600);
    setTimeout(function () {
        $(".myFlash").fadeOut(600);
        $(".myFlash .message").removeClass(type).html("");
    }, 3000)
    if(type !== "wtf"){
        resetContact();
    }

}

function resetContact() {
    $('#firstName').val("");
    $('#lastName').val("");
    $('#email').val("");
    $('#message').val("");
}

function ajaxContact(data) {
    if (checkForm(data)) {

        $.ajax({
            type: 'POST',
            data: {
                data: data
            },
            url: "ajax/contact",
            dataType: 'json',
            timeout: 2000,
            success: function (response) {

                if (typeof response.error !== "undefined") {
                    addFlash('error', response.error.text)
                }
                if (typeof response.wtf !== "undefined") {
                    addFlash('wtf', response.wtf.text)
                }
                if (typeof response.valid !== "undefined") {
                    addFlash('valid', response.valid.text)
                }


            },
            error: function () {

            }
        })


    }

}