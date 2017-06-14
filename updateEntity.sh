#!/bin/bash

php bin/console doctrine:mapping:import --force AppBundle xml
php bin/console doctrine:mapping:convert annotation ./src --force
php bin/console doctrine:generate:entities AppBundle

