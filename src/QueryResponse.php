<?php

namespace Loxodonta\QueryBus;

use Loxodonta\QueryBus\Signature\QueryResponseInterface;

/**
 * Class QueryResponse
 */
class QueryResponse implements QueryResponseInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * QueryResponse constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->value;
    }
}
