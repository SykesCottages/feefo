<?php

declare(strict_types=1);

namespace SykesCottages\Feefo;

use Countable;
use Iterator;

use function array_merge;
use function count;

class ResultSet implements Countable, Iterator
{
    protected Reviews $reviews;
    /** @var array<mixed> */
    protected array $array;
    protected object $summary;
    protected int $current = 0;

    /**
     * @param array<mixed> $array
     */
    public function __construct(Reviews $reviews, array $array, object $summary)
    {
        $this->reviews = $reviews;
        $this->array   = $array;
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
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

    /**
     * @return array<mixed>
     */
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
