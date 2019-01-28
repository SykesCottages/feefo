<?php

namespace SykesCottages\Feefo;

use Countable;
use Iterator;

class ResultSet implements Countable, Iterator
{
    protected $reviews;
    protected $array;
    protected $summary;
    protected $current = 0;

    public function __construct(Reviews $reviews, array $startingArray, object $summary)
    {
        $this->reviews = $reviews;
        $this->array = $startingArray;
        $this->summary = $summary;
    }

    public function current()
    {
        return $this->array[$this->current];
    }

    public function next()
    {
        $this->current++;
    }

    public function key()
    {
        return $this->current;
    }

    public function valid()
    {
        if (isset($this->array[$this->current])) {
            return true;
        }

        if ($this->summary->current_page < $this->summary->pages) {
            $this->getMoreResults();
            return isset($this->array[$this->current]);
        }

        return false;
    }

    public function rewind()
    {
        $this->current = 0;
    }

    public function getArray()
    {
        return $this->array;
    }

    public function count()
    {
        return count($this->array);
    }

    protected function getMoreResults()
    {
        $this->summary->current_page++;
        $this->reviews->page($this->summary->current_page);
        $extraReviews = $this->reviews->getReviews();
        $this->array = array_merge($this->array, $extraReviews->getArray());
    }
}
