<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class GiftsService
{

public $gifts = ['flowers', 'money', 'car', 'cake', 'boot', 'lollipop', 'house', 'concert ticket' ];

public function __construct(LoggerInterface $logger){
$logger->info('Gift were randomized!');
    shuffle($this->gifts);
}

}