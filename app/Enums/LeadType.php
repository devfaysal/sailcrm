<?php
namespace App\Enums;

enum LeadType: string
{
    case Farmer = 'Farmer';
    case Retailer = 'Retailer';
    case Dealer = 'Dealer';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
