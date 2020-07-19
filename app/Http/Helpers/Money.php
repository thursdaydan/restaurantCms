<?php

namespace App\Http\Helpers;

class Money
{
    /**
     * @var int
     */
    private $pence;

    /**
     * Money constructor.
     *
     * @param $pence
     */
    private function __construct($pence)
    {
        $this->pence = (integer) $pence;
    }

    public static function fromPounds($pounds): Money
    {
        return new static($pounds * 100);
    }

    public static function fromPence($pence): Money
    {
        return new static($pence);
    }

    public function inPounds(): string
    {
        return (string) ($this->pence / 100);
    }

    public function inPence(): string
    {
        return (string) $this->pence;
    }

    public function inPoundsAndPence(): string
    {
        return number_format($this->pence / 100, 2);
    }
}
