<?php

namespace SykesCottages\Feefo;

class Review
{
    public object $review;

    public function __construct(object $review)
    {
        $this->review = $review;
    }
}
