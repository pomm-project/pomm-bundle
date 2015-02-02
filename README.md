# Pomm2 bundle for Symfony.

Although this bundle usable already, it is a work in progress. New features will be added.

This bundle provides a `pomm` service to use the Pomm2 [Model Manager](https://github.com/pomm-project/ModelManager) with Symfony.

## Installation

Simply require `pomm-project/pomm-bundle: 2.0.*@dev` in your `composer.json` file and run the `update` command.

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

And in `routing_dev.yml`:

```yml
_pomm:
    resource: "@PommBundle/Resources/config/routing.yml"
    prefix:   /_pomm
```

## Command line interface

The [Pomm CLI](https://github.com/pomm-project/Cli) is available through the `app/console` utility. It is possible to browse the database or to generate model files. 

```
$ ./app/console pomm:generate:relation-all -d src -a 'AppBundle\Model' my_db1 student
```

## Using Pomm from the controller

The Pomm service is available in the DIC as any other service:

```php
    function myAction($name)
    {
        $students = $this->get('pomm')['my_db1']
            ->getModel('\AppBundle\Model\MyDb1\PublicSchema\StudentModel')
            ->findWhere('name = $*', [$name])
            ;

        …
```

It is now possible to tune and create a model layer as described in [the quick start guide](http://pomm-project.org/documentation/sandbox2). 

