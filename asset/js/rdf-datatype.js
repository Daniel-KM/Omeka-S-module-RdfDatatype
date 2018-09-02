(function($, window, document) {
    $(function() {
        var defaultSelectors = $('#properties .resource-values div.default-selector');
        var buttons = $('<a data-type="xsd:integer" class="add-value button o-icon-xsd-integer"></a>').prop('href', '#').html(Omeka.jsTranslate('Number'));
        defaultSelectors.append(buttons);
    });
}(window.jQuery, window, document));
