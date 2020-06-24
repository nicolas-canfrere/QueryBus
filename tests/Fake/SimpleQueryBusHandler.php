<?php


namespace Loxodonta\QueryBus\Tests\Fake;


use Loxodonta\QueryBus\Signature\QueryBusHandlerInterface;

class SimpleQueryBusHandler implements QueryBusHandlerInterface
{
    public function __invoke(SimpleQuery $query)
    {
        return $this->listenTo();
    }
    /**
     * @inheritDoc
     */
    public function listenTo(): string
    {
        return SimpleQuery::class;
    }
}
