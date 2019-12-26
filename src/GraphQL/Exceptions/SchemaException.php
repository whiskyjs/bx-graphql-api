<?php

namespace WJS\API\GraphQL\Exceptions;

class SchemaException extends \Exception
{
    /**
     * @param string $message
     * @param array $replace
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", array $replace = [], $code = 0, \Throwable $previous = null)
    {
        parent::__construct(format($message, $replace), $code, $previous);
    }
}
