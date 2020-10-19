<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Api\Representation\ValueRepresentation;
use Omeka\DataType\AbstractDataType;
use Omeka\Entity\Value;
use Zend\View\Renderer\PhpRenderer;

abstract class AbstractRdfDatatype extends AbstractDataType
{
    public function getOptgroupLabel()
    {
        return 'RDF Datatype'; // @translate
    }

    public function prepareForm(PhpRenderer $view)
    {
        $assetUrl = $view->plugin('assetUrl');
        $view->headLink()->appendStylesheet($assetUrl('css/rdf-datatype.css', 'RdfDatatype'));
        $view->headScript()->appendFile($assetUrl('js/rdf-datatype.js', 'RdfDatatype'), 'text/javascript', ['defer' => 'defer']);
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $value->setValue(trim($valueObject['@value']));
        // Set defaults.
        $value->setLang(null);
        $value->setUri(null);
        $value->setValueResource(null);
    }

    public function render(PhpRenderer $view, ValueRepresentation $value)
    {
        return $value->value();
    }

    public function getJsonLd(ValueRepresentation $value)
    {
        return [
            '@value' => $value->value(),
        ];
    }
}
