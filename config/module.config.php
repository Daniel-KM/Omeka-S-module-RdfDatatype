<?php
namespace RdfDatatype;

return [
    'data_types' => [
        'invokables' => [
            'xsd:boolean' => DataType\XsdBoolean::class,
            'xsd:integer' => DataType\XsdInteger::class,
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
        'Number', // @translate
        'True/False', // @translate
    ],
];
