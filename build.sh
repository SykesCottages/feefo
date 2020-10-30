#!/bin/bash
vendor/bin/phpunit
vendor/bin/phpcs --standard=Doctrine src
vendor/bin/phpcs --standard=Doctrine tests