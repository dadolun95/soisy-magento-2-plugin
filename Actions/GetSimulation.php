<?php
namespace Soisy\PaymentMethod\Actions;

use Soisy\PaymentMethod\Helper\Settings;
use Soisy\PaymentMethod\Log\Logger;

class GetSimulation
{
    public $settings;
    public $logger;

    public function __construct(
        Settings $settings,
        Logger $logger
    ) {
        $this->settings = $settings;
        $this->logger = $logger;
    }

    /**
     * Return default widget generated remotely by Soisy API
     * @param $amount
     * @return string
     */
    public function getDefaultWidgetSimulation($amount)
    {
        $html = '<soisy-loan-quote ' .
            'shop-id="' . $this->settings->getShopId(true) . '" ' .
            'amount="' . $amount . '" ' .
            'instalments="' . $this->settings->getPromotionalRates() . '" ' .
            'zero-interest-rate="' . $this->settings->getZeroInterestRate() . '"></soisy-loan-quote>' .
            '<script src="https://cdn.soisy.it/loan-quote-widget.js" async defer></script>';
        return $html;
    }

    public function execute(float $amount)
    {
        if (!$this->settings->isActive() || !$this->settings->showSimulation()) {
            return false;
        }

        if ($amount < $this->settings->getMinAmount()) {
            return false;
        }

        /*
         * DEFAULT WIDGET SIMULATION
         * */
        return $this->getDefaultWidgetSimulation($amount);

    }
}
