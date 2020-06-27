<?php


namespace Loxodonta\QueryBus\Tests\Fake;


use Loxodonta\QueryBus\Signature\QueryBusHandlerInterface;
use Loxodonta\QueryBus\QueryResponse;

class SimpleQueryBusHandler implements QueryBusHandlerInterface
{
    public function __invoke(SimpleQuery $query)
    {
        return new QueryResponse($this->listenTo());
    }
    /**
     * @inheritDoc
     */
    public function listenTo(): string
    {
        return SimpleQuery::class;
    }
}
