<?php


namespace Loxodonta\QueryBus\Signature;


interface QueryBusMiddlewareInterface
{
    /**
     * @param $query
     *
     * @param callable $next
     *
     * @return mixed
     */
    public function dispatch($query, callable $next);
}
