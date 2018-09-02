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

});
