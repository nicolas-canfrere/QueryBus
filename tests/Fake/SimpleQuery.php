<?php


namespace Loxodonta\QueryBus\Tests\Fake;


use Loxodonta\QueryBus\Signature\QueryInterface;

class SimpleQuery implements QueryInterface
{
    public string $var = 'test';
}
