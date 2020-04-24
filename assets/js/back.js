jQuery(document).ready(function ($) {
    var iconNumber = 2;
    $('#sbsi_add_icon').click(function (e) {
        e.preventDefault();
        iconNumber++;
        console.log(iconNumber);
    });
});