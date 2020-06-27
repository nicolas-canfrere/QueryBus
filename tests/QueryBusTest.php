<?php


namespace Loxodonta\QueryBus\Tests;


use Loxodonta\QueryBus\Tests\Fake\Spy;
use Loxodonta\QueryBus\Exception\QueryHandlerNotCallableException;
use Loxodonta\QueryBus\Exception\QueryHasNoHandlerException;
use Loxodonta\QueryBus\QueryBus;
use Loxodonta\QueryBus\Signature\QueryBusInterface;
use Loxodonta\QueryBus\Signature\QueryBusMiddlewareInterface;
use Loxodonta\QueryBus\Tests\Fake\AnotherMiddleware;
use Loxodonta\QueryBus\Tests\Fake\FakeBusHandler;
use Loxodonta\QueryBus\Tests\Fake\NotCallableBusHandler;
use Loxodonta\QueryBus\Tests\Fake\SimpleMiddleware;
use Loxodonta\QueryBus\Tests\Fake\SimpleQuery;
use Loxodonta\QueryBus\Tests\Fake\SimpleQueryBusHandler;
use PHPUnit\Framework\TestCase;

class QueryBusTest extends TestCase
{
    /**
     * @test
     */
    public function itImplementsQueryBusInterface()
    {
        $qb = new QueryBus();

        $this->assertInstanceOf(QueryBusInterface::class, $qb);
    }

    /**
     * @test
     */
    public function itCanRegisterHandlers()
    {
        $qb = new QueryBus();
        $handler = new FakeBusHandler();

        $this->assertFalse($qb->hasHandlerFor($handler->listenTo()));

        $qb->registerHandler($handler);

        $this->assertTrue($qb->hasHandlerFor($handler->listenTo()));
    }

    /**
     * @test
     */
    public function itMustThrowExceptionIfHandlerIsNotCallable()
    {
        $qb = new QueryBus();
        $handler = new NotCallableBusHandler();

        $this->expectException(QueryHandlerNotCallableException::class);
        $qb->registerHandler($handler);
    }

    /**
     * @test
     */
    public function itCanDispatchCommand()
    {
        $qb = new QueryBus();
        $handler = new SimpleQueryBusHandler();
        $qb->registerHandler($handler);

        $this->assertTrue($qb->hasHandlerFor(SimpleQuery::class));

        $result = $qb->dispatch(new SimpleQuery());

        $this->assertEquals(SimpleQuery::class, $result->getValue());
    }

    /**
     * @test
     */
    public function itMustThrowExceptionIfThereIsNoHandlerForCommand()
    {
        $qb = new QueryBus();

        $this->expectException(QueryHasNoHandlerException::class);
        $qb->dispatch(new SimpleQuery());
    }

    /**
     * @test
     */
    public function itCanRegisterMiddleware()
    {
        $mw = $this->createMock(QueryBusMiddlewareInterface::class);

        $qb = new QueryBus();
        $qb->registerMiddleware($mw);

        $this->assertTrue($qb->hasMiddleware($mw));
    }

    /**
     * @test
     */
    public function withOneMiddleware()
    {
        $qb = new QueryBus();
        $spy = $this->mockMiddlewareSpy();
        $spy->expects($this->atLeastOnce())->method('report');
        $mw = new SimpleMiddleware($spy);
        $handler = new SimpleQueryBusHandler();

        $qb->registerMiddleware($mw);
        $qb->registerHandler($handler);

        $query = new SimpleQuery();

        $result = $qb->dispatch($query);

        $this->assertEquals(SimpleQuery::class, $result->getValue());
    }

    /**
     * @test
     */
    public function withMultipleMiddlewares()
    {
        $qb = new QueryBus();
        $spyOne = $this->mockMiddlewareSpy();
        $spyOne->expects($this->once())->method('report');
        $mw = new SimpleMiddleware($spyOne);
        $spyTwo = $this->mockMiddlewareSpy();
        $spyTwo->expects($this->exactly(2))->method('report');
        $amw = new AnotherMiddleware($spyTwo);
        $handler = new SimpleQueryBusHandler();

        $qb->registerMiddleware($amw)->registerMiddleware($mw);
        $qb->registerHandler($handler);

        $query = new SimpleQuery();

        $result = $qb->dispatch($query);

        $this->assertEquals(SimpleQuery::class, $result->getValue());
    }
    private function mockMiddlewareSpy()
    {
        return
            $this->getMockBuilder(Spy::class)
                 ->onlyMethods(['report'])->getMock();
    }

}
