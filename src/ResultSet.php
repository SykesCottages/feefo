<?php

namespace SykesCottages\Feefo;

use Countable;
use Iterator;

class ResultSet implements Countable, Iterator
{
    protected $dataArray;
    protected $current;
    protected $reviews;
    protected $summary;

    public function __construct(Reviews $reviews, array $startingArray, object $summary)
    {
        $this->current   = 0;
        $this->dataArray = $startingArray;
        $this->reviews   = $reviews;
        $this->summary   = $summary;
    }

    public function current()
    {
        return $this->array[$this->current];
    }

    public function next(): void
    {
        $this->current++;
    }

    public function key(): int
    {
        return $this->current;
    }

    public function valid(): bool
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

    public function rewind(): void
    {
        $this->current = 0;
    }

    public function getArray(): array
    {
        return $this->array;
    }

    public function count(): int
    {
        return count($this->array);
    }

    protected function getMoreResults(): void
    {
        $this->summary->current_page++;
        $this->reviews->page($this->summary->current_page);
        $extraReviews = $this->reviews->getReviews();
        $this->array  = array_merge($this->array, $extraReviews->getArray());
    }
}
