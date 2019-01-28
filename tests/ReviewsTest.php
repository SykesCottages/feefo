<?php

namespace SykesCottages\Feefo\Tests;

use PHPUnit\Framework\TestCase;
use SykesCottages\Feefo\Reviews;
use SykesCottages\Feefo\Review;

class ReviewsTest extends TestCase
{
    /**
     * @var Reviews
     */
    private $reviews;
    private $sampleReviews;

    public function setUp()
    {
        parent::setUp();
        $this->reviews = new Reviews('example-freefo-merchant');
        $this->sampleReviews = json_decode(file_get_contents(__DIR__ . '/fixtures/SampleReviews.json'));
    }

    public function testGetReviews()
    {
        $this->reviews->url('https://api.feefo.com/api/10/reviews/product');
        $this->reviews->sincePeriod('all');
        $this->reviews->fullThread('include');
        $this->reviews->pageSize(1);
        $this->reviews->page(1);
        $this->reviews->fields('reviews.products.review');
        $this->reviews->sku('G0BAQSJ6');

        $expectedReview[] = new Review($this->sampleReviews->singleReview);

        $this->assertEquals(
            $expectedReview,
            $this->reviews->getReviews()->getArray()
        );
    }
}
