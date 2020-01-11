jQuery(function ($) {
    $('.mrp-close').click(function() {
        $('.hello-elementor-child-register-popup').hide();
    });

    $('a[href="#hello-elementor-child-register-popup"]').click(function() {
        $('.hello-elementor-child-register-popup').show();

        return false;
    });
});