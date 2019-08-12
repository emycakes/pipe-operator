<?php

namespace MickPaliokas;

/**
 * Class Pipeline
 * Based on https://wiki.php.net/rfc/pipe-operator
 * Drawback: You lose Intellisense on any piped functions
 */
class Pipeline
{
    // simpler piped value reference
    const TOKEN_NAME = '$$';

    // internal pipeline token
    const TOKEN = 'PIPE_TOKEN';

    /** @var mixed $value */
    private $value;


    /**
     * Pipeline constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        // define pipeline token constant if it hasn't been done yet
        if (!defined(static::TOKEN_NAME)) {
            define(static::TOKEN_NAME, static::TOKEN);
        }

        $this->value = $value;
    }


    /**
     * To Allow unwrapped nicer looking calls
     * @param string|callable $name
     * @param array $arguments
     * @return Pipeline
     */
    public function __call($name, $arguments)
    {
        return $this->pipe($name, ...$arguments);
    }


    /**
     * Apply the callback and return fluent interface
     * to allow continue chaining
     * @param callable $callback
     * @param mixed ...$arguments
     * @return Pipeline
     */
    public function pipe($callback, ...$arguments)
    {
        $this->value = $callback(...$this->getArguments($arguments));

        return $this;
    }


    /**
     * a conditional pipe
     * @param bool|callable $condition
     * @param callable $callback
     * @param mixed ...$arguments
     * @return Pipeline
     */
    public function when($condition, $callback, ...$arguments)
    {
        if (is_callable($condition)
            ? $condition(...$this->getArguments($arguments))
            : $condition
        ) {
            return $this->pipe($callback, ...$arguments);
        }

        return $this;
    }


    /**
     * Get final value out of the pipeline
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }


    /**
     * Apply pipeline value to the piped function arguments
     * @param array $arguments
     * @return array
     */
    private function getArguments(array $arguments)
    {
        // if token is not specified in the arguments
        // add the value as the last argument
        if (! in_array(static::TOKEN, $arguments)) {
            return array_merge($arguments, [$this->value]);
        }

        return array_map(function ($argument) {
            return $argument !== static::TOKEN ? $argument : $this->value;
        }, $arguments);
    }
}
