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

namespace TIG\MaxCDN\Observer;

use TIG\MaxCDN\Model\Connection;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class PurgeAll extends Connection implements ObserverInterface {

    protected $_connection;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager,
        Connection $_connection
    )
    {
        $this->_connection = $_connection;
        parent::__construct(
            $this->scopeConfig = $scopeConfig,
            $this->messageManager = $messageManager
        );
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $purgedZones = $this->purgeAllZones();

        foreach ($purgedZones as $zone => $errorCode) {
            $messages[$zone] = $this->generateMessage($zone, $errorCode);
        }

        return $messages;
    }

    public function purgeAllZones() {
        $api = $this->_connection->getConnection();

        $zones = json_decode($api->get('/zones.json'))->data->zones;

        foreach ($zones as $zone) {
            $status[$zone->id] = $this->purgeZone($zone);
        }

        return $status;
    }

    public function purgeZone($zone) {
        $api = $this->_connection->getConnection();

        $zoneId = $zone->id;

        try {
            $status = $api->delete('/zones/pull.json/' . $zoneId . '/cache');
        } catch (\Exception $e) {
            $status = $e;
        }

        return $status;
    }

    public function generateMessage($zone, $errorCode) {
        $code = (int)json_decode($errorCode)->code;

        if ($code !== 200) {
            return $this->messageManager->addErrorMessage(__('MaxCDN Pull Zone [ID: ' . $zone . '] not purged. Error code:') . ' ' . $code);
        }

        return $this->messageManager->addSuccessMessage(__('MaxCDN Pull Zone [ID: ' . $zone . '] purged successfully.'));
    }
}
