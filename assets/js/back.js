jQuery(document).ready(function ($) {

    // add additional icon input
    $('#sbsi_add_icon').click(function (e) {
        e.preventDefault();

        var sbsiHtml = '<span><label for="sbsi_icon">Select icon</label><input id="sbsi_icon" name="sbsi_icon" type="file"><a href="javascript:void(0);" class="sbsi_remove" title="Remove">-</a></span>';
        $('.sbsi_icon_div').append(sbsiHtml);
    });

    // remove additional icon
    $(document).on("click", "a.sbsi_remove" , function() {
        $(this).parent().remove();
    });
});