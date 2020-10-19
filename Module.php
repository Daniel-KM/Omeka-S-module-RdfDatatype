<?php
/**
 * RdfDatatype
 *
 * Implement the main W3C RDF datatypes (html, xml, boolean, integer, decimal
 * and date/time) in order to simplify user input and to give more semanticity
 * to values of resources.
 *
 * @copyright Daniel Berthereau, 2018
 * @license http://www.cecill.info/licences/Licence_CeCILL_V2.1-en.txt
 *
 * This software is governed by the CeCILL license under French law and abiding
 * by the rules of distribution of free software.  You can use, modify and/ or
 * redistribute the software under the terms of the CeCILL license as circulated
 * by CEA, CNRS and INRIA at the following URL "http://www.cecill.info".
 *
 * As a counterpart to the access to the source code and rights to copy, modify
 * and redistribute granted by the license, users are provided only with a
 * limited warranty and the software's author, the holder of the economic
 * rights, and the successive licensors have only limited liability.
 *
 * In this respect, the user's attention is drawn to the risks associated with
 * loading, using, modifying and/or developing or reproducing the software by
 * the user in light of its specific status of free software, that may mean that
 * it is complicated to manipulate, and that also therefore means that it is
 * reserved for developers and experienced professionals having in-depth
 * computer knowledge. Users are therefore encouraged to load and test the
 * software's suitability as regards their requirements in conditions enabling
 * the security of their systems and/or data to be ensured and, more generally,
 * to use and operate it in the same conditions as regards security.
 *
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL license and that you accept its terms.
 */
namespace RdfDatatype;

use Omeka\Module\AbstractModule;
use Omeka\Mvc\Controller\Plugin\Messenger;
use Omeka\Stdlib\Message;
use RdfDatatype\Form\ConfigForm;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;

class Module extends AbstractModule
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function install(ServiceLocatorInterface $serviceLocator)
    {
        $this->manageSettings($serviceLocator->get('Omeka\Settings'), 'install');
    }

    public function uninstall(ServiceLocatorInterface $serviceLocator)
    {
        $this->manageSettings($serviceLocator->get('Omeka\Settings'), 'uninstall');
    }

    public function upgrade($oldVersion, $newVersion, ServiceLocatorInterface $services)
    {
        if (version_compare($oldVersion, '3.0.4.1', '<')) {
            $message = new Message(
                'This module has been replaced by modules %1$sData Type RDF%3$s (html, xml, boolean) and %2$sNumeric Data Types%3$s (integer, date time). Install them for an automatic upgrade.', // @translate
                '<a href="https://gitlab.com/Daniel-KM/Omeka-S-module-DataTypeRdf" target="_blank">',
                '<a href="https://github.com/omeka-s-modules/NumericDataTypes" target="_blank">',
                '</a>'
            );
            $message->setEscapeHtml(false);
            $messenger = new Messenger();
            $messenger->addSuccess($message);

            $message = new Message(
                'Other data types (decimal and partial date/time) are converted into literal.' // @translate
            );
            $message->setEscapeHtml(false);
            $messenger->addWarning($message);
        }
    }

    protected function manageSettings($settings, $process, $key = 'config')
    {
        $config = require __DIR__ . '/config/module.config.php';
        $defaultSettings = $config[strtolower(__NAMESPACE__)][$key];
        foreach ($defaultSettings as $name => $value) {
            switch ($process) {
                case 'install':
                    $settings->set($name, $value);
                    break;
                case 'uninstall':
                    $settings->delete($name);
                    break;
            }
        }
    }

    public function attachListeners(SharedEventManagerInterface $sharedEventManager)
    {
        $controllers = [
            'Omeka\Controller\Admin\Item',
            'Omeka\Controller\Admin\ItemSet',
            'Omeka\Controller\Admin\Media',
        ];
        foreach ($controllers as $controller) {
            $sharedEventManager->attach(
                $controller,
                'view.add.after',
                [$this, 'prepareResourceForm']
            );
            $sharedEventManager->attach(
                $controller,
                'view.edit.after',
                [$this, 'prepareResourceForm']
            );
        }
    }

    public function getConfigForm(PhpRenderer $renderer)
    {
        $services = $this->getServiceLocator();
        $config = $services->get('Config');
        $settings = $services->get('Omeka\Settings');
        $form = $services->get('FormElementManager')->get(ConfigForm::class);

        $data = [];
        $defaultSettings = $config[strtolower(__NAMESPACE__)]['config'];
        foreach ($defaultSettings as $name => $value) {
            $data[$name] = $settings->get($name, $value);
        }

        $form->init();
        $form->setData($data);
        $html = $renderer->formCollection($form);
        $html .= '<p>'
            . $renderer->translate('Avoid overloading the user interface and use the resource templates as much as possible.') // @translate
            . '</p>';
        $html .= '<p>'
            . $renderer->translate('Note: the datatypes Gregorian Month, Month day and Day require a specific format (two or three dashes prepended) to be fully compliant with the standard.') // @translate
            . '</p>';
        return $html;
    }

    public function handleConfigForm(AbstractController $controller)
    {
        $services = $this->getServiceLocator();
        $config = $services->get('Config');
        $settings = $services->get('Omeka\Settings');
        $form = $services->get('FormElementManager')->get(ConfigForm::class);

        $params = $controller->getRequest()->getPost();

        $form->init();
        $form->setData($params);
        if (!$form->isValid()) {
            $controller->messenger()->addErrors($form->getMessages());
            return false;
        }

        $params = $form->getData();
        $defaultSettings = $config[strtolower(__NAMESPACE__)]['config'];
        $params = array_intersect_key($params, $defaultSettings);
        foreach ($params as $name => $value) {
            $settings->set($name, $value);
        }
    }

    /**
     * Prepare resource forms for rdf types.
     *
     * @param Event $event
     */
    public function prepareResourceForm(Event $event)
    {
        $view = $event->getTarget();
        $settings = $this->getServiceLocator()->get('Omeka\Settings');
        $rdfDatatypes = $settings->get('rdfdatatype_datatypes', []);
        $view->headScript()->appendScript('var rdfDatatypes = ' . json_encode($rdfDatatypes, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ';');
    }
}
