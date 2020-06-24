<?php


namespace Loxodonta\QueryBus\Tests\Fake;


use Loxodonta\QueryBus\Signature\QueryBusMiddlewareInterface;

class SimpleMiddleware implements QueryBusMiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function dispatch($query, callable $next)
    {
        $query->var = sprintf('%s modified', $query->var);

        return $next($query);
    }
}
