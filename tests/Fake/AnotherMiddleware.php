<?php


namespace Loxodonta\QueryBus\Tests\Fake;


use Loxodonta\QueryBus\Signature\QueryBusMiddlewareInterface;

class AnotherMiddleware implements QueryBusMiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function dispatch($query, callable $next)
    {
        $query->var = sprintf('%s and modified again', $query->var);
        $result = $next($query);
        $query->var = $query->var . ' and again';
        return $result;
    }
}
