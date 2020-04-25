jQuery(document).ready(function ($) {

    // setup form
    $('#sbsi_product_icons').append('<form id="sbsi_icon_form" action="" enctype="multipart/form-data"></form>');
    $('#sbsi_icon_form').append($('#sbsi_icon_div'));
    $('#sbsi_icon_form').append($('#sbsi_btn_cont'));

    // add additional icon input
    $('#sbsi_add_icon').click(function (e) {
        e.preventDefault();

        var random = Math.floor(Math.random() * 10000);

        var sbsiHtml = '<span><label for="sbsi_icon_'+random+'">Select icon</label><input id="sbsi_icon_'+random+'" name="sbsi_icon_'+random+'" type="file"><a href="javascript:void(0);" class="sbsi_remove" title="Remove">x</a></span>';
        $('#sbsi_icon_div').append(sbsiHtml);
    });

    // remove additional icon
    $(document).on("click", "a.sbsi_remove", function () {
        $(this).parent().remove();
    });

    // submit icon form
    $('form#sbsi_icon_form').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('action', 'saveIconsAjax');

        $.ajax({
            type: "post",
            url: ajaxurl,
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(response);
            }
        }); 
    });
});