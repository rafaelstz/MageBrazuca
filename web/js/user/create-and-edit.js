var UserCreateAndEdit = UserCreateAndEdit || {};

UserCreateAndEdit = {
    submit: function(isUpdate) {
        if (!this.validate(isUpdate)) {
            return;
        }

        var data = new FormData();

        var fields = {
            'firstname'                    : 'firstname',
            'lastname'                     : 'lastname',
            'username'                     : 'username',
            'password'                     : 'password',
            'email'                        : 'email',
            'gender'                       : 'gender',
            'about'                        : 'about',
            'company'                      : 'company',
            'is-available-to-hiring'       : 'is_available_to_hiring',
            'location'                     : 'location',
            'location-city-short-value'    : 'location_city_short',
            'location-city-long-value'     : 'location_city_long',
            'location-state-short-value'   : 'location_state_short',
            'location-state-long-value'    : 'location_state_long',
            'location-country-short-value' : 'location_country_short',
            'location-country-long-value'  : 'location_country_long',
            'contact-website'              : 'contact_website',
            'contact-twitter'              : 'contact_twitter',
            'contact-linkedin'             : 'contact_linkedin',
            'contact-certification'        : 'contact_certification',
            'contact-github'               : 'contact_github',
            'contact-stackoverflow'        : 'contact_stackoverflow'
        };

        for (var key in fields) {
            data.append(
                fields[key],
                $('#' + key).val()
            );
        }

        data.append('picture', $('#picture')[0].files[0]);

        if (!isUpdate) {
            var url = '/user/create';
        } else {
            var url = '/user/edit';
        }

        $.ajax({
            url    : url,
            method : 'post',
            data   : data,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            if (data.error) {
                Base.showAjaxResponseErrors(data);
            } else {
                window.location.href = '/';
            }
        });
    },

    addGoogleMapsAutoComplete: function() {
        var input = $('#location').get(0);

        var autocomplete = new google.maps.places.Autocomplete((input), {
            types: ['(cities)']
        });

        var obj = this;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();

            obj.updateFieldBasedOnPlaceType(
                place,
                '#location-city-short-value',
                '#location-city-long-value',
                '#location-state-short-value',
                '#location-state-long-value',
                '#location-country-short-value',
                '#location-country-long-value'
            );
        });
    },

    updateFieldBasedOnPlaceType: function (
        place,
        cityShortId,
        cityLongId,
        stateShortId,
        stateLongId,
        countryShortId,
        countryLongId
    ) {
        $(place.address_components).each(function() {
            var type = this.types[0];

            if (type == 'locality') {
                $(cityShortId).val(this.short_name);
                $(cityLongId).val(this.long_name);
            } else if (type == 'administrative_area_level_1') {
                $(stateShortId).val(this.short_name);
                $(stateLongId).val(this.long_name);
            } else if (type == 'country') {
                $(countryShortId).val(this.short_name);
                $(countryLongId).val(this.long_name);
            }
        });
    },

    validate: function (isUpdate) {
        var hasError = false;

        var errors = [];

        var requiredFields = [
            'firstname',
            'lastname',
            'username',
            'email',
            'gender'
        ];

        if (!isUpdate) {
            requiredFields.push('password');
        }

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

        var location      = $('#location');
        var locationValue = $('#location-city-short-value');

        if (
               !location.val().trim()
            || !locationValue.val().trim()
        ) {
            location.addClass('error');
            hasError = true;
        } else {
            location.removeClass('error');
        }

        if (hasError) {
            return false;
        }

        return true;
    }
}
