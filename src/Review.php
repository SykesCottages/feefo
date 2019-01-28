<?php

namespace SykesCottages\Feefo;

class Review
{
    public $review;

    public function __construct(object $review)
    {
        $this->review = $review;
    }
}