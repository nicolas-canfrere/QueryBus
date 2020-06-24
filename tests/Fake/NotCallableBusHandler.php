<?php

namespace Loxodonta\QueryBus\Tests\Fake;

use Loxodonta\QueryBus\Signature\QueryBusHandlerInterface;

class NotCallableBusHandler implements QueryBusHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function listenTo(): string
    {
        return 'queryName';
    }
}
