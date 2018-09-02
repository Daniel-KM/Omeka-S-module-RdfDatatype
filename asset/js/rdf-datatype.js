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
        // Use a quick js check (for any number) and the official regex provided by the w3c.
        // @url https://www.w3.org/TR/xmlschema11-2/#decimal
        var val = this.value.trim();
        if (val === ''
            || ($.isNumeric(val) && val.match(/^(\+|-)?([0-9]+(\.[0-9]*)?|\.[0-9]+)$/))
        ) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity(Omeka.jsTranslate('Please enter a valid decimal number.'));
        }
    });

});
