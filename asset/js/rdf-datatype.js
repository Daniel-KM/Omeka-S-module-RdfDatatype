$(document).ready( function() {

    $(function() {
        var defaultSelectors = $('#properties .resource-values div.default-selector');
        $('<a>', {'class': 'add-value button o-icon-xsd-boolean', 'href': '#', 'data-type': 'xsd:boolean',})
            .text(Omeka.jsTranslate('True/False'))
            .appendTo(defaultSelectors);
        defaultSelectors.append("\n");
        $('<a>', {'class': 'add-value button o-icon-xsd-integer', 'href': '#', 'data-type': 'xsd:integer',})
            .text(Omeka.jsTranslate('Number'))
            .appendTo(defaultSelectors);
        defaultSelectors.append("\n");
        $('<a>', {'class': 'add-value button o-icon-xsd-decimal', 'href': '#', 'data-type': 'xsd:decimal',})
            .text(Omeka.jsTranslate('Decimal'))
            .appendTo(defaultSelectors);
        defaultSelectors.append("\n");
        $('<a>', {'class': 'add-value button o-icon-xsd-date', 'href': '#', 'data-type': 'xsd:date',})
            .text(Omeka.jsTranslate('Date'))
            .appendTo(defaultSelectors);
        defaultSelectors.append("\n");
        $('<a>', {'class': 'add-value button o-icon-xsd-time', 'href': '#', 'data-type': 'xsd:time',})
            .text(Omeka.jsTranslate('Time'))
            .appendTo(defaultSelectors);
        defaultSelectors.append("\n");
        $('<a>', {'class': 'add-value button o-icon-xsd-date-time', 'href': '#', 'data-type': 'xsd:dateTime',})
            .text(Omeka.jsTranslate('Date Time'))
            .appendTo(defaultSelectors);
        defaultSelectors.append("\n");
    });

    $(document).on('o:prepare-value', function(e, type, value) {
        if (type === 'xsd:boolean') {
            var thisValue = $(value);
            var userInput = thisValue.find('.input-value');
            var valueInput = thisValue.find('input[data-value-key="@value"]');

            // Set existing values during initial load.
            var val = valueInput.val();
            if (val === '1' || val === 'true') {
                userInput.prop('checked', true);
                userInput.val('1');
                valueInput.val('1');
            } else {
                userInput.prop('checked', false);
                userInput.val('0');
                valueInput.val('0');
            }

            // Synchronize the user input with the true but hidden value.
            userInput.on('change', function(e) {
                if ($(this).is(':checked')) {
                    userInput.val('1');
                    valueInput.val('1');
                } else {
                    userInput.val('0');
                    valueInput.val('0');
                }
            });
        }
    });

    $('input.value.xsd-date-time').on('keyup', function(e) {
        regexCheck(this, 'xsd:dateTime');
    });
    $('input.value.xsd-decimal').on('keyup', function(e) {
        regexCheck(this, 'xsd:decimal');
    });

    /**
     * Check user input against official regexes provided by the w3c.
     *
     * @param object element
     * @param string datatype
     */
    function regexCheck(element, datatype)
    {
        var regex, message;
        var val = element.value.trim();
        if (datatype === 'xsd:decimal') {
            // @url https://www.w3.org/TR/xmlschema11-2/#decimal
            regex = /^(\+|-)?([0-9]+(\.[0-9]*)?|\.[0-9]+)$/;
            message = 'Please enter a valid decimal number.';
        } else if (datatype === 'xsd:dateTime') {
            // @url https://www.w3.org/TR/xmlschema11-2/#nt-dateTimeRep
            regex = /^-?([1-9][0-9]{3,}|0[0-9]{3})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9](\.[0-9]+)?|(24:00:00(\.0+)?))(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/;
            message = 'Please enter a valid ISO 8601 full date time, with or without time zone offset.';
        }

        if (!regex || val === '' || val.match(regex)) {
            element.setCustomValidity('');
        } else {
            element.setCustomValidity(Omeka.jsTranslate(message));
        }
    }

});
