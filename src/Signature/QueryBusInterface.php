<?php


namespace Loxodonta\QueryBus\Signature;

use Loxodonta\QueryBus\Exception\QueryHandlerNotCallableException;
use Loxodonta\QueryBus\Exception\QueryHasNoHandlerException;

/**
 * Interface QueryBusInterface
 */
interface QueryBusInterface
{
    /**
     * @param QueryBusHandlerInterface $handler
     *
     * @return QueryBusInterface
     * @throws QueryHandlerNotCallableException
     */
    public function registerHandler(QueryBusHandlerInterface $handler): QueryBusInterface;

    /**
     * @param QueryBusMiddlewareInterface $middleware
     *
     * @return QueryBusInterface
     */
    public function registerMiddleware(QueryBusMiddlewareInterface $middleware): QueryBusInterface;

    /**
     * @param QueryInterface $query
     *
     * @return QueryResponseInterface
     * @throws QueryHasNoHandlerException
     */
    public function dispatch(QueryInterface $query): QueryResponseInterface;

    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasHandlerFor(string $className): bool;

    /**
     * @param QueryBusMiddlewareInterface $middleware
     *
     * @return bool
     */
    public function hasMiddleware(QueryBusMiddlewareInterface $middleware): bool;
}
