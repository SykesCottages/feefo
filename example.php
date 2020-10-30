<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$reviews = new SykesCottages\Feefo\Reviews('example-retail-merchant');

foreach ($reviews->getReviews() as $review) {
    // Handle review here
}
