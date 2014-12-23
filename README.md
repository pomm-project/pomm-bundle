# Pomm2 bundle for Symfony.

Although this bundle usable already, it is a work in progress. New features will be added.

This bundle provides a `pomm` service to use Pomm2 [Model Manager](https://github.com/pomm-project/ModelManager) with Symfony.

## Installation

Simply require `pomm-project/pomm-bundle: 2.0.*@dev` in your `composer.json` file and launch the `update` command.

## Setup

Add the bundle in the `app/AppKernel.php` file:

```php
<?php // app/AppKernel.php
// …
    public function registerBundles()
    {
        $bundles = [
        // other bundles
        new \PommProject\PommBundle\PommBundle(),
        // other bundles
        ];
```
## Configuration

Add an entry in `config.yml`:

```yml
pomm:
    configuration:
        my_db1:
            dsn: 'pgsql://user:pass@host:port/db_name'
        my_db2:
            dsn: 'pgsql://user:pass@host:port/db_name2'
            class:session_builder: '\PommProject\ModelManager\SessionBuilder'
    logger:
        service: '@logger'
```
