(function ($) {
    $('#userForm').on('beforeSubmit', function (e) {
        $('#avatar-field').val($('#user-avatar').attr('src'));
        return true;
    });
    $('#deleteAvatar').on('click', function(){
        $('#user-avatar').attr('src', '');
    });
})(jQuery);