jQuery(document).ready(function ($) {

    $('div#reviews').closest('.product-section').attr('id', 'review_container');

    var source = $('div#sbsi_icon_div_front');
    var target = $('#review_container');

    $(target).prepend(source);

});