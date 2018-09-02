$(document).ready( function() {

    $(function() {
        var defaultSelectors = $('#properties .resource-values div.default-selector');
        if (rdfDatatypes.indexOf('rdf:HTML') != -1) {
            $('<a>', {'class': 'add-value button o-icon-rdf-html', 'href': '#', 'data-type': 'rdf:HTML'})
                .text(Omeka.jsTranslate('Html'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:boolean') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-boolean', 'href': '#', 'data-type': 'xsd:boolean'})
                .text(Omeka.jsTranslate('True/False'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:integer') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-integer', 'href': '#', 'data-type': 'xsd:integer'})
                .text(Omeka.jsTranslate('Number'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:decimal') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-decimal', 'href': '#', 'data-type': 'xsd:decimal'})
                .text(Omeka.jsTranslate('Decimal'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:date') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-date', 'href': '#', 'data-type': 'xsd:date'})
                .text(Omeka.jsTranslate('Date'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:time') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-time', 'href': '#', 'data-type': 'xsd:time'})
                .text(Omeka.jsTranslate('Time'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:dateTime') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-date-time', 'href': '#', 'data-type': 'xsd:dateTime'})
                .text(Omeka.jsTranslate('Date Time'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gYear') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-year', 'href': '#', 'data-type': 'xsd:gYear'})
                .text(Omeka.jsTranslate('Year'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gYearMonth') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-year-month', 'href': '#', 'data-type': 'xsd:gYearMonth'})
                .text(Omeka.jsTranslate('Year Month'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gMonth') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-month', 'href': '#', 'data-type': 'xsd:gMonth'})
                .text(Omeka.jsTranslate('Month'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gMonthDay') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-month-day', 'href': '#', 'data-type': 'xsd:gMonthDay'})
                .text(Omeka.jsTranslate('Month Day'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gDay') != -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-day', 'href': '#', 'data-type': 'xsd:gDay'})
                .text(Omeka.jsTranslate('Day'))
                .appendTo(defaultSelectors);
            defaultSelectors.append("\n");
        }
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

    $('input.value.xsd-decimal').on('keyup', function(e) {
        regexCheck(this, 'xsd:decimal');
    });
    $('input.value.xsd-date-time').on('keyup', function(e) {
        regexCheck(this, 'xsd:dateTime');
    });
    $('input.value.xsd-g-year').on('keyup', function(e) {
        regexCheck(this, 'xsd:gYear');
    });
    $('input.value.xsd-g-year-month').on('keyup', function(e) {
        regexCheck(this, 'xsd:gYearMonth');
    });
    $('input.value.xsd-g-month-day').on('keyup', function(e) {
        regexCheck(this, 'xsd:gMonthDay');
    });
    $('input.value.xsd-g-month').on('keyup', function(e) {
        regexCheck(this, 'xsd:gMonth');
    });
    $('input.value.xsd-g-day').on('keyup', function(e) {
        regexCheck(this, 'xsd:gDay');
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
        } else if (datatype === 'xsd:gYear') {
            // @url https://www.w3.org/TR/xmlschema11-2/#nt-gYearRep
            regex = /^-?([1-9][0-9]{3,}|0[0-9]{3})(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/;
            message = 'Please enter a valid ISO 8601 year, with four digits.';
        } else if (datatype === 'xsd:gYearMonth') {
            // @url https://www.w3.org/TR/xmlschema11-2/#nt-gYearMonthRep
            regex = /^-?([1-9][0-9]{3,}|0[0-9]{3})-(0[1-9]|1[0-2])(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/;
            message = 'Please enter a valid ISO 8601 year, with four digits, followed by a "-" and a month with two digits.';
        } else if (datatype === 'xsd:gMonth') {
            // @url https://www.w3.org/TR/xmlschema11-2/#nt-gMonthRep
            regex = /^--(0[1-9]|1[0-2])(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/;
            message = 'Please enter a valid ISO 8601 month, begining with "--".';
        } else if (datatype === 'xsd:gMonthDay') {
            // @url https://www.w3.org/TR/xmlschema11-2/#nt-gMonthDayRep
            regex = /^--(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/;
            message = 'Please enter a valid ISO 8601 month and day, begining with "--".';
        } else if (datatype === 'xsd:gDay') {
            // @url https://www.w3.org/TR/xmlschema11-2/#nt-gDayRep
            regex = /^---(0[1-9]|[12][0-9]|3[01])(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/;
            message = 'Please enter a valid ISO 8601 day, begining with "---".';
        }

        if (!regex || val === '' || val.match(regex)) {
            element.setCustomValidity('');
        } else {
            element.setCustomValidity(Omeka.jsTranslate(message));
        }
    }

});
