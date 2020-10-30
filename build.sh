#!/bin/bash -e
vendor/bin/phpcs --standard=Doctrine src
vendor/bin/phpunit
