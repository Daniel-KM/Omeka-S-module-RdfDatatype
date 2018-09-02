<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @url https://www.w3.org/TR/rdf11-concepts/#section-XMLLiteral
 */
class RdfXmlLiteral extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'rdf:XMLLiteral';
    }

    public function getLabel()
    {
        return 'Xml';
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\Textarea('rdf-xml-literal');
        $element->setAttributes([
            'class' => 'value to-require rdf-xml-literal',
            'data-value-key' => '@value',
            'placeholder' => '<oai_dcterms:dcterms>
    <dcterms:title>Resource Description Framework (RDF)</dcterms:title>
</oai_dcterms:dcterms>',
        ]);
        return $view->formTextarea($element);
    }

    public function isValid(array $valueObject)
    {
        return isset($valueObject['@value']);
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $value->setValue(trim($valueObject['@value']));
        // Set defaults.
        // According to the recommandation, the language must be included
        // explicitly in the XML literal.
        // TODO Manage the language for xml.
        $value->setLang(null);
        $value->setUri(null);
        $value->setValueResource(null);
    }
}
