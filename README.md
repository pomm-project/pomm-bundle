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

If you want a nice query debugger, enable it in your `config_dev.yml`:

```yml
pomm:
    web_profiler: true
```

And add the corresponding routes in your `routing_dev.yml`:

```yml
_pomm:
    resource: "@PommBundle/Resources/config/routing.yml"
    prefix:   /_pomm
```

## Command line interface

The [Pomm CLI](https://github.com/pomm-project/Cli) is available through the `app/console` utility. It is possible to browse the database or to generate model files. Even though the CLI interfaces with the Symfony console utility, it still needs to find a file named `.pomm_cli_bootstrap.php` in the project root directory. Here is a sample content:

```php
<?php

$kernel = new \AppKernel('dev', true);
$kernel->boot();

return $kernel->getContainer()
    ->get('pomm');
```

It is now possible to generate the model or inspecting the database using the command line:

```
$ ./app/console pomm:generate:relation-all -d src -a 'AppBundle\Model' db student
```

## Using Pomm from the controller

The Pomm service is available in the DIC as any other service:

```php
    function myAction($name)
    {
        $students = $this->get('pomm')['db']
            ->getModel('\AppBundle\Model\Db\PublicSchema\StudentModel')
            ->findWhere('name = $*', [$name])
            ;

        …
```

It is now possible to tune and create a model layer as described in [the quick start guide](http://pomm-project.org/documentation/sandbox2). 

