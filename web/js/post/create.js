var PostCreate = PostCreate || {};

PostCreate = {
    submit: function() {
        if (!this.validate()) {
            return;
        }

        var data = $('#form-post').serializeArray();

        $.ajax({
            url    : '/post/create',
            method : 'post',
            data   : data
        })
        .done(function(data) {
            if (data.error) {
                Base.showAjaxResponseErrors(data);
            } else {
                window.location.href = '/';
            }
        });
    },

    validate: function () {
        var hasError = false;

        var errors = [];

        var requiredFields = [
            'title',
            'url',
            'tag'
        ];

        $(requiredFields).each(function(index, value){
            var field = $('#' + value);
            if (field.val().trim() == '') {
                errors.push(value);
            } else {
                field.removeClass('error');
            }
        });

        if (errors.length) {
            $(errors).each(function(index, value){
                $('#' + value).addClass('error');
            });

            hasError = true;
        }

        var tag  = $('#tag');
        var tags = tag.val().split(',');

        if (tags.length) {
            var regex = /^[\w-]+$/;

            var hasKeywordError = false;

            $(tags).each(function(index, value){
                value = value.trim();

                if (
                       !hasKeywordError
                    && !regex.test(value)
                ) {
                    hasKeywordError = true;
                    hasError        = true;

                    tag.addClass('error');
                }
            });

            if (!hasKeywordError) {
                tag.removeClass('error');
            }
        }

        if (hasError) {
            return false;
        }

        return true;
    }
}
