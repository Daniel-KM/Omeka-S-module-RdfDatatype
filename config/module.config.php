<?php
namespace RdfDatatype;

return [
    'data_types' => [
        'invokables' => [
            'xsd:boolean' => DataType\XsdBoolean::class,
            'xsd:date' => DataType\XsdDate::class,
            'xsd:dateTime' => DataType\XsdDateTime::class,
            'xsd:decimal' => DataType\XsdDecimal::class,
            'xsd:gDay' => DataType\XsdGDay::class,
            'xsd:gMonth' => DataType\XsdGMonth::class,
            'xsd:gMonthDay' => DataType\XsdGMonthDay::class,
            'xsd:gYear' => DataType\XsdGYear::class,
            'xsd:gYearMonth' => DataType\XsdGYearMonth::class,
            'xsd:integer' => DataType\XsdInteger::class,
            'xsd:time' => DataType\XsdTime::class,
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => dirname(__DIR__) . '/language',
                'pattern' => '%s.mo',
                'text_domain' => null,
            ],
        ],
    ],
    'js_translate_strings' => [
        'Date', // @translate
        'Date Time', // @translate
        'Day', // @translate
        'Decimal', // @translate
        'Month', // @translate
        'Month Day', // @translate
        'Number', // @translate
        'Please enter a valid decimal number.', // @translate
        'Please enter a valid ISO 8601 full date time, with or without time zone offset.', // @translate
        'Please enter a valid ISO 8601 day, begining with "---".', // @translate
        'Please enter a valid ISO 8601 month, begining with "--".', // @translate
        'Please enter a valid ISO 8601 month and day, begining with "--".', // @translate
        'Please enter a valid ISO 8601 year, with four digits.', // @translate
        'Please enter a valid ISO 8601 year, with four digits, followed by a "-" and a month with two digits.', // @translate
        'Time', // @translate
        'True/False', // @translate
        'Year', // @translate
        'Year Month', // @translate
    ],
];
