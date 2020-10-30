#!/bin/bash
vendor/bin/phpcs --standard=Doctrine src
vendor/bin/phpcs --standard=Doctrine tests
vendor/bin/phpunit
