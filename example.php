<?php

require __DIR__ . '/vendor/autoload.php';

$reviews = new SykesCottages\Feefo\Reviews('example-freefo-merchant');

foreach ($reviews->getReviews() as $review) {
    // Handle review here
};