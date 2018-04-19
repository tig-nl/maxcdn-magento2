<?php
/**
 *
 *          ..::..
 *     ..::::::::::::..
 *   ::'''''':''::'''''::
 *   ::..  ..:  :  ....::
 *   ::::  :::  :  :   ::
 *   ::::  :::  :  ''' ::
 *   ::::..:::..::.....::
 *     ''::::::::::::''
 *          ''::''
 *
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Creative Commons License.
 * It is available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to servicedesk@tig.nl so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact servicedesk@tig.nl for more information.
 *
 * @copyright   Copyright (c) Total Internet Group B.V. https://tig.nl/copyright
 * @license     http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 */

namespace TIG\MaxCDN\Block\Adminhtml\Config\Support;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Module\ModuleResource;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Tab extends Template implements RendererInterface
{
    const MODULE_NAME = 'TIG_MaxCDN';

    protected $_template = 'TIG_MaxCDN::config/support/tab.phtml';

    /**
     * @var ModuleResource
     */
    private $moduleContext;

    public function __construct(
        Template\Context $context,
        ModuleResource $moduleResource,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleContext = $moduleResource;
    }

    /**
     * {@inheritdoc}
     */
    public function render(AbstractElement $element)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->setElement($element);
        return $this->toHtml();
    }

    /**
     * Retrieve the version number from the database.
     *
     * @return bool|false|string
     */
    public function getVersionNumber()
    {
        $version = $this->moduleContext->getDbVersion(static::MODULE_NAME);
        return $version;
    }
}