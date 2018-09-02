<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Omeka\Stdlib\HtmlPurifier;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @url https://www.w3.org/TR/rdf11-concepts/#section-html
 */
class RdfHtml extends AbstractRdfDatatype
{
    /**
     * @var HtmlPurifier
     */
    protected $htmlPurifier;

    public function __construct(HtmlPurifier $htmlPurifier)
    {
        $this->htmlPurifier = $htmlPurifier;
    }

    public function getName()
    {
        return 'rdf:HTML';
    }

    public function getLabel()
    {
        return 'Html';
    }

    public function form(PhpRenderer $view)
    {
        // CKEditor is not enabled for item sets neither medias (the helper
        // avoids to reload it for items).
        $view->ckEditor();
        $element = new Element\Textarea('rdf-html');
        $element->setAttributes([
            'class' => 'value to-require rdf-html wyziwyg',
            'data-value-key' => '@value',
            'placeholder' => '<p>input <em>your</em> <strong>html</strong> content</p>', // @translate
        ]);
        return $view->formTextarea($element);
    }

    public function isValid(array $valueObject)
    {
        return isset($valueObject['@value'])
            && $this->htmlPurifier->purify(trim($valueObject['@value'])) !== '';
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $val = $this->htmlPurifier->purify(trim($valueObject['@value']));
        $value->setValue($val);
        // Set defaults.
        // According to the recommandation, the language must be included
        // explicitly in the HTML literal.
        // TODO Manage the language for html.
        $value->setLang(null);
        $value->setUri(null);
        $value->setValueResource(null);
    }
}
