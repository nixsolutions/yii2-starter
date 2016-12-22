(function ($) {
    $('#cropImage').on('click', function () {
        var data = [];
        data [yii.getCsrfParam()] = yii.getCsrfToken();
        data['width'] =
        data['height']

    });

    $('#registration-form').on('beforeSubmit', function (e) {
        console.log($('#user-avatar').attr('src'));
        $('#avatar-field').val($('#user-avatar').attr('src'));
        return true;
    });

})(jQuery);