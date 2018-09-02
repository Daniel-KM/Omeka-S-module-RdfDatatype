(function($) {

    /**
     * Prepare the markup for the default data types.
     */
    $(document).on('o:prepare-value', function(e, type, value, valueObj, namePrefix) {
        // Prepare markup for some specific resource data types.
        if (type === 'rdf:HTML') {
            var thisValue = $(value);
            // Append the ckeditor.
            thisValue.find('.wyziwyg').each(function () {
                var editor = CKEDITOR.inline(this, {
                    on: {change: function() {
                        this.updateElement();
                    }},
                });
                $(this).data('ckeditorInstance', editor);
            })
        } else if (type === 'xsd:boolean') {
            var thisValue = $(value);
            var userInput = thisValue.find('.input-value');
            var valueInput = thisValue.find('input[data-value-key="@value"]');

            // Set existing values during initial load.
            var val = valueInput.val();
            val = (val === '1' || val === 'true') ? '1' : '0';
            userInput.prop('checked', val === '1');
            userInput.val(val);
            valueInput.val(val);

            // Synchronize the user input with the true but hidden value.
            userInput.on('change', function(e) {
                var val = $(this).is(':checked') ? '1' : '0';
                userInput.val(val);
                valueInput.val(val);
            });
        }
    });

    $(document).ready( function() {

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

        // Initial load.
        initRdfDatatypes();

    });

    /**
     * Prepare the rdf datatypes for the main resource template.
     *
     * There is no event in resource-form.js and common/resource-form-templates.phtml,
     * except the generic view.add.after and view.edit.after, so the default
     * form is completed dynamically during the initial load.
     */
    var initRdfDatatypes = function() {
        var defaultSelectorAndFields = $('.resource-values.field.template .add-values.default-selector, #properties .resource-values div.default-selector');
        appendRdfDatatypes(defaultSelectorAndFields);
    }

    /**
     * Append the configured rdf datatypes to a list of element.
     */
    var appendRdfDatatypes = function(selector) {
        if (rdfDatatypes.indexOf('rdf:HTML') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-rdf-html', 'href': '#', 'data-type': 'rdf:HTML'})
                .text(Omeka.jsTranslate('Html'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('rdf:XMLLiteral') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-rdf-xml-literal', 'href': '#', 'data-type': 'rdf:XMLLiteral'})
                .text(Omeka.jsTranslate('Xml'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:boolean') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-boolean', 'href': '#', 'data-type': 'xsd:boolean'})
                .text(Omeka.jsTranslate('True/False'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:integer') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-integer', 'href': '#', 'data-type': 'xsd:integer'})
                .text(Omeka.jsTranslate('Number'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:decimal') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-decimal', 'href': '#', 'data-type': 'xsd:decimal'})
                .text(Omeka.jsTranslate('Decimal'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:dateTime') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-date-time', 'href': '#', 'data-type': 'xsd:dateTime'})
                .text(Omeka.jsTranslate('Date Time'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:date') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-date', 'href': '#', 'data-type': 'xsd:date'})
                .text(Omeka.jsTranslate('Date'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:time') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-time', 'href': '#', 'data-type': 'xsd:time'})
                .text(Omeka.jsTranslate('Time'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gYear') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-year', 'href': '#', 'data-type': 'xsd:gYear'})
                .text(Omeka.jsTranslate('Year'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gYearMonth') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-year-month', 'href': '#', 'data-type': 'xsd:gYearMonth'})
                .text(Omeka.jsTranslate('Year Month'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gMonth') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-month', 'href': '#', 'data-type': 'xsd:gMonth'})
                .text(Omeka.jsTranslate('Month'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gMonthDay') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-month-day', 'href': '#', 'data-type': 'xsd:gMonthDay'})
                .text(Omeka.jsTranslate('Month Day'))
                .appendTo(selector);
            selector.append("\n");
        }
        if (rdfDatatypes.indexOf('xsd:gDay') !== -1) {
            $('<a>', {'class': 'add-value button o-icon-xsd-g-day', 'href': '#', 'data-type': 'xsd:gDay'})
                .text(Omeka.jsTranslate('Day'))
                .appendTo(selector);
            selector.append("\n");
        }
    };

    /**
     * Check user input against official regexes provided by the w3c.
     *
     * @param object element
     * @param string datatype
     */
    var regexCheck = function(element, datatype) {
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

})(jQuery);
