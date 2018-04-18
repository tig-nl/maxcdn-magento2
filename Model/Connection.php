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

namespace TIG\MaxCDN\Model;

use MaxCDN;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Message\ManagerInterface;

class Connection {

    const CONFIG_PATH = 'tig_max_cdn';

    /** @var ScopeConfigInterface $scopeConfig */
    public $scopeConfig;

    /** @var ManagerInterface $messageManager */
    public $messageManager;

    /**
     * Connection constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->messageManager = $messageManager;
    }

    /**
     * @return MaxCDN
     */
    public function getConnection() {
        $companyAlias = $this->getConfigValue('general', 'cdn_company_alias');
        $consumerKey = $this->getConfigValue('general', 'cdn_consumer_key');
        $consumerSecret = $this->getConfigValue('general', 'cdn_consumer_secret');

        return new MaxCDN($companyAlias, $consumerKey, $consumerSecret);
    }

    /**
     * @param $group string
     * @param $field string
     * @return mixed
     */
    public function getConfigValue($group, $field) {
        $scope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $configValue = $this->scopeConfig->getValue(self::CONFIG_PATH . '/' . $group . '/' . $field, $scope);

        return $configValue;
    }
}