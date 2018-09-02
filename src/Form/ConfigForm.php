<?php
namespace RdfDatatype\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class ConfigForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'rdfdatatype_datatypes',
            'type' => Element\MultiCheckbox::class,
            'options' => [
                'label' => 'RDF datatypes to display', // @translate
                'info' => 'The selected datatypes will be automatically available in resource forms. All the datatypes are available via the resource templates.', // @translate
                'value_options' => [
                    'xsd:boolean' => 'Boolean', // @translate
                    'xsd:integer' => 'Integer', // @translate
                    'xsd:decimal' => 'Decimal', // @translate
                    'xsd:dateTime' => 'Date time', // @translate
                    'xsd:date' => 'Date', // @translate
                    'xsd:time' => 'Time', // @translate
                    'xsd:gDay' => 'Gregorian day', // @translate
                    'xsd:gMonth' => 'Gregorian month', // @translate
                    'xsd:gMonthDay' => 'Gregorian month and day', // @translate
                    'xsd:gYear' => 'Gregorian year', // @translate
                    'xsd:gYearMonth' => 'Gregorian year and month', // @translate
                ],
            ],
            'attributes' => [
                'id' => 'rdfdatatype_datatypes',
            ],
        ]);

        $inputFilter = $this->getInputFilter();
        $inputFilter->add([
            'name' => 'rdfdatatype_datatypes',
            'required' => false,
        ]);
    }
}
