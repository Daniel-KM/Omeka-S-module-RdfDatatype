<?php
namespace RdfDatatype\Service\DataType;

use Interop\Container\ContainerInterface;
use RdfDatatype\DataType\RdfHtml;
use Zend\ServiceManager\Factory\FactoryInterface;

class RdfHtmlFactory implements FactoryInterface
{
    /**
     * Create the service for RdfHtml datatype.
     *
     * @return RdfHtml
     */
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new RdfHtml($services->get('Omeka\HtmlPurifier'));
    }
}
