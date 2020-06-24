<?php

namespace Loxodonta\QueryBus;

use Loxodonta\QueryBus\Exception\QueryHandlerNotCallableException;
use Loxodonta\QueryBus\Exception\QueryHasNoHandlerException;
use Loxodonta\QueryBus\Signature\QueryBusHandlerInterface;
use Loxodonta\QueryBus\Signature\QueryBusInterface;
use Loxodonta\QueryBus\Signature\QueryBusMiddlewareInterface;

/**
 * Class QueryBus
 */
class QueryBus implements QueryBusInterface
{
    protected array $handlers = [];

    protected array $middlewares = [];

    /**
     * @inheritDoc
     */
    public function registerHandler(QueryBusHandlerInterface $handler): QueryBusInterface
    {
        if (!is_callable($handler)) {
            throw new QueryHandlerNotCallableException(
                sprintf('%s is not callable', get_class($handler))
            );
        }
        $this->handlers[$handler->listenTo()] = $handler;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function registerMiddleware(QueryBusMiddlewareInterface $middleware): QueryBusInterface
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dispatch($query)
    {
        $key = get_class($query);
        if ($this->hasHandlerFor($key)) {

            $current = array_pop($this->middlewares);
            if (is_null($current)) {
                return $this->handlers[$key]($query);
            }

            return $current->dispatch($query, [$this, 'dispatch']);
        }

        throw new QueryHasNoHandlerException(
            sprintf('%s command has no handler', $key)
        );
    }

    /**
     * @inheritDoc
     */
    public function hasHandlerFor(string $className): bool
    {
        return !empty($this->handlers[$className]);
    }

    /**
     * @inheritDoc
     */
    public function hasMiddleware(QueryBusMiddlewareInterface $middleware): bool
    {
        return in_array($middleware, $this->middlewares, true);
    }
}
