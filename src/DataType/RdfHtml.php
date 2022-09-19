<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Api\Representation\ValueRepresentation;
use Omeka\Entity\Value;
use Omeka\Stdlib\HtmlPurifier;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @link https://www.w3.org/TR/rdf11-concepts/#section-html
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

        $translate = $view->plugin('translate');
        $html = $view->hyperlink('', '#', ['class' => 'value-language o-icon-language', 'title' => $translate('Set language')]);
        $html .= '<input class="value-language" type="text" data-value-key="@language" aria-label="' . $translate('Language') . '">';
        $html .= $view->formTextarea($element);
        return $html;
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
        // explicitly in the HTML literal. Nevertheless, it can be saved for
        // Omeka purposes.
        // TODO Manage the language for html.
        if (isset($valueObject['@language'])) {
            $value->setLang($valueObject['@language']);
        } else {
            $value->setLang(null);
        }
        $value->setUri(null);
        $value->setValueResource(null);
    }

    public function getJsonLd(ValueRepresentation $value)
    {
        $jsonLd = ['@value' => $value->value()];
        $lang = $value->lang();
        if ($lang) {
            $jsonLd['@language'] = $lang;
        }
        return $jsonLd;
    }
}
