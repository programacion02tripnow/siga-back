<?php

namespace App\Strategies;

class ReservationDetailContext
{
private $strategy;

public function __construct(ReservationDetailStrategy $strategy)
{
    $this->strategy = $strategy;
}

public function execute_strategy($reservation_detail){
    return $this->strategy->execute($reservation_detail);
}
}
