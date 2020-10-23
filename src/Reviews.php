<?php

namespace SykesCottages\Feefo;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Reviews extends Client
{
    public $fields;
    public $fullThread = 'include';
    public $merchantIdentifier;
    public $page = 1;
    public $pageSize = 100;
    public $sincePeriod = 'all';
    public $sku;
    public $url = 'https://api.feefo.com/api/10/reviews/product';

    public function __construct(string $merchantIdentifier)
    {
        parent::__construct();
        $this->merchantIdentifier = $merchantIdentifier;
    }

    public function getReviews(): ResultSet
    {
        $query = [
            'merchant_identifier' => $this->merchantIdentifier,
            'since_period'        => $this->sincePeriod,
            'full_thread'         => $this->fullThread,
            'page_size'           => $this->pageSize,
            'page'                => $this->page,
        ];

        if ($this->fields) {
            $query['fields'] = $this->fields;
        }

        if ($this->sku) {
            $query['product_sku'] = '*' . $this->sku . '*';
        }

        $response = json_decode($this->get($this->url, [
            RequestOptions::QUERY => $query,
        ])->getBody());

        return $this->makeReviews($response);
    }

    public function url(string $url): Reviews
    {
        $this->url = $url;
        return $this;
    }

    public function sincePeriod(string $sincePeriod): Reviews
    {
        $this->sincePeriod = $sincePeriod;
        return $this;
    }

    public function fullThread(string $fullThread): Reviews
    {
        $this->fullThread = $fullThread;
        return $this;
    }

    public function pageSize(int $pageSize): Reviews
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    public function page(int $page): Reviews
    {
        $this->page = $page;
        return $this;
    }

    public function fields(string $fields): Reviews
    {
        $this->fields = $fields;
        return $this;
    }

    public function sku(string $sku): Reviews
    {
        $this->sku = $sku;
        return $this;
    }

    private function makeReviews(object $response): ResultSet
    {
        $reviews = [];
        if (isset($response->reviews)) {
            foreach ($response->reviews as $review) {
                $reviews[] = new Review($review);
            }
        }
        return new ResultSet($this, $reviews, $response->summary->meta);
    }
}
