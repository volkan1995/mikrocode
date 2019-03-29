// preloader
$(window).load(function () {
    $('.preloader').fadeOut(1000); // set duration in brackets    
});

$(function () {
    new WOW().init();
    $('.templatemo-nav').singlePageNav({
        offset: 70
    });

    /* Hide mobile menu after clicking on a link
     -----------------------------------------------*/
    $('.navbar-collapse a').click(function () {
        $(".navbar-collapse").collapse('hide');
    });


    var gonderTF = true;
    $(document).on('submit', '.oto_form', function (e) {
        if (gonderTF === true) {
            var post_array = {};
            gonderTF = false;
            var gonderFRM = $(this);
            var gonderURL = gonderFRM.attr("action");
            var gonderRSLT = gonderFRM.data("result");
            var gonderRST = gonderFRM.data("reset");
            var gonderBTN = gonderFRM.find("input[type=submit]:first-child");
            var gonderVAL = gonderBTN.val();
            gonderBTN.val("Bekleyiniz...");
            gonderFRM.find('input[confirm]').each(function () {
                var uyusmayan = gonderFRM.find('input[name=' + $(this).attr('confirm') + ']');
                if (uyusmayan.val() != $(this).val()) {
                    uyusmayan.css({"border": "1px solid orange", "padding-left": "7px"});
                    $(this).css({"border": "1px solid orange", "padding-left": "7px"});
                    alert("Alanlar uyuşmuyor");
                    return false;
                }
            });
            gonderFRM.find('input[type=checkbox]').each(function () {
                var this_cbn = $(this).attr('name');
                if (typeof this_cbn != 'undefined') {
                    if ($(this).prop('checked')) {
                        post_array[this_cbn] = 1;
                    } else {
                        post_array[this_cbn] = 0;
                    }
                }
            });
            $.post(gonderURL, (gonderFRM.serialize() + '&' + $.param(post_array)),
                    function (data) {
                        $(gonderRSLT).html(data);
                        gonderBTN.val(gonderVAL);
                        setTimeout(function () {
                            gonderTF = true;
                        }, 1000);
                        if (gonderRST == "true" || gonderRST == true) {
                            gonderFRM[0].reset();
                        }
                    }
            );
            post_array = {};
        }
        return false;
    });

})