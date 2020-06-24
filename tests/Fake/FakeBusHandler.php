<?php

namespace Loxodonta\QueryBus\Tests\Fake;

use Loxodonta\QueryBus\Signature\QueryBusHandlerInterface;

class FakeBusHandler implements QueryBusHandlerInterface
{
    public function __invoke()
    {

    }
    /**
     * @inheritDoc
     */
    public function listenTo(): string
    {
        return 'Query\Class\Name';
    }
}
