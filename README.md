# Feefo PHP API Package

This is designed to be an easy way in php to use the reviews API from Feefo.

This can be installed using composer for example:

    composer require sykesCottages/feefo
    
 Then the most simple method of getting the reviews is as follows
 
```php
$reviews = new SykesCottages\feefo\Reviews('merchant-identifier');
foreach ($reviews->getReviews() as $review) {
    // Handle review here
}
```

# Functions

All functions can be chained, together for example:

```php
$reviews->sku('sku')->pageSize(50));
foreach ($reviews->getReviews() as $review) {
    // Handle review here
}
```

| <b>Function Name</b>  | <b>Description</b>                                              | <b>Default Value</b>                          |
| --------------------- | --------------------------------------------------------------- | --------------------------------------------- |
| url                   | The URL endpoint                                                | https://api.feefo.com/api/10/reviews/product  |
| sincePeriod           | Filter reviews to those created during the specified period     | all                                           |
| fullThread            | Filters subsequent exchanges between the customer and merchant  | include                                       |
| pageSize              | The number of reviews to return per page, max 100               | 100                                           |
| page                  | The page number to return reviews for                           | 1                                             |
| fields                | Limit the response to include certain fields                    |                                               |
| sku                   | Filter reviews assigned to the specified product search code    |                                               |
