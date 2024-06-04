<?php

namespace App\DTO;

class TradeContext
{
    public $request;
    public $user;
    public $cryptocurrencySetting;
    public $coinWalletAttribute;
    public $marketWalletAttribute;
    public $coinUsingAttribute;
    public $marketUsingAttribute;
    public $coinAvailableAttribute;
    public $marketAvailableAttribute;

    public function __construct($request, $user, $cryptocurrencySetting)
    {
        $this->request = $request;
        $this->user = $user;
        $this->cryptocurrencySetting = $cryptocurrencySetting;
        $this->coinWalletAttribute = strtolower($request['coin']) . '_wallet';
        $this->marketWalletAttribute = strtolower($request['market']) . '_wallet';
        $this->coinUsingAttribute = strtolower($request['coin']) . '_using';
        $this->marketUsingAttribute = strtolower($request['market']) . '_using';
        $this->coinAvailableAttribute = strtolower($request['coin']) . '_available';
        $this->marketAvailableAttribute = strtolower($request['market']) . '_available';
    }
}
