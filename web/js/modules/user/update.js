(function ($) {
    $('#userForm').on('beforeSubmit', function (e) {
        $('#avatar-field').val($('#user-avatar').attr('src'));
        return true;
    });
})(jQuery);