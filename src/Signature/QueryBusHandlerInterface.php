<?php


namespace Loxodonta\QueryBus\Signature;


interface QueryBusHandlerInterface
{
    /**
     * @return string
     */
    public function listenTo(): string;
}
