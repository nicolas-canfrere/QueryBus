<?php


namespace Loxodonta\QueryBus\Tests\Fake;


use Loxodonta\QueryBus\Signature\QueryBusMiddlewareInterface;

class AnotherMiddleware implements QueryBusMiddlewareInterface
{
    /**
     * @var Spy
     */
    private $spy;

    /**
     * SimpleMiddleware constructor.
     *
     * @param Spy $spy
     */
    public function __construct(Spy $spy)
    {
        $this->spy = $spy;
    }
    /**
     * @inheritDoc
     */
    public function dispatch($query, callable $next)
    {
        $this->spy->report();
        $result = $next($query);
        $this->spy->report();
        return $result;
    }
}
