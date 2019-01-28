<?php

namespace SykesCottages\Feefo\Tests;

use PHPUnit\Framework\TestCase;
use SykesCottages\Feefo\Reviews;
use SykesCottages\Feefo\ResultSet;

class ResultSetTest extends TestCase
{
    private $reviews;

    public function setUp()
    {
        parent::setUp();
        $this->reviews = $this->createMock(Reviews::class);
    }

    public function testCountable()
    {
        $resultSet = new ResultSet($this->reviews, [1, 2], (object)["pages" => 1, "current_page" => 1]);

        $this->assertEquals(2, count($resultSet));
    }

    public function testIterating()
    {
        $resultSet = new ResultSet($this->reviews, [1, 2], (object)["pages" => 3, "current_page" => 1]);
        $extraResults = new ResultSet($this->reviews, [3], (object)["pages" => 3, "current_page" => 2]);
        $lastResult = new ResultSet($this->reviews, [], (object)["pages" => 3, "current_page" => 3]);

        $this->reviews->method('getReviews')->will($this->onConsecutiveCalls($extraResults, $lastResult));

        $count = 0;
        foreach ($resultSet as $key => $value) {
            $count++;
        }

        $this->assertEquals(3, $count);
        $this->assertEquals(2, $key);
    }

    public function testIteratingWithCurrentPageAfterPages()
    {
        $resultSet = new ResultSet($this->reviews, [1, 2], (object)["pages" => 1, "current_page" => 4]);

        $this->reviews->method('getReviews');

        $count = 0;
        foreach ($resultSet as $key => $result) {
            $count++;
        }

        $this->assertEquals(2, $count);
        $this->assertEquals(1, $key);
    }
}
