#!/bin/bash

vendor/bin/phpcs --standard=Doctrine --report-json=./phpcs.json src

errors=($(jq -r '.totals.errors' phpcs.json))

if (( $errors > 0 )); then
  exit 1
fi

vendor/bin/phpunit
