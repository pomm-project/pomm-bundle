# Pomm2 bundle for Symfony

[![Build Status](https://travis-ci.org/pomm-project/pomm-bundle.svg)](https://travis-ci.org/pomm-project/pomm-bundle)

Although this bundle usable already, it is a work in progress. New features will be added.

This bundle provides a `pomm` service to use the Pomm2 [Model Manager](https://github.com/pomm-project/ModelManager) with Symfony.

**Note:**

If you are looking for a bundle for Pomm 1.x then look up for `pomm/pomm-bundle` on packagist.

## Installation

```
composer require pomm-project/pomm-bundle
```

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

In the `app/config` folder, store your db connection parameters in `parameters.yml`:

```yml
parameters:
    db_host1: 127.0.0.1
    db_port1: 5432
    db_name1: my_db_name
    db_user1: user
    db_password1: pass

    db_host2: 127.0.0.1
#   etc.
```

Sensitive information such as database credentials should not be committed in Git. To help you prevent committing those files and folders by accident, the Symfony Standard Distribution comes with a file called .gitignore which list resources that Git should ignore, included this `parameters.yml` file.
You can now refer to these parameters elsewhere by surrounding them with percent (%).

Add an entry in `config.yml`:

```yml
pomm:
    configuration:
        my_db1:
            dsn: "pgsql://%db_user1%:%db_password1%@%db_host1%:%db_port1%/%db_name1%"
            pomm:default: true
        my_db2:
            dsn: "pgsql://%db_user2%:%db_password2%@%db_host2%:%db_port2%/%db_name2%"
            session_builder: "pomm.session_builder"
    logger:
        service: "@logger"
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
        $students = $this->get('pomm')['my_db2']
            ->getModel('\AppBundle\Model\MyDb1\PublicSchema\StudentModel')
            ->findWhere('name = $*', [$name])
            ;

        …
```

It is now possible to tune and create a model layer as described in [the quick start guide](http://www.pomm-project.org/documentation/sandbox2).

## Param converter

This bundle provide a [param
converter](http://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/annotations/converters.html)
to convert request to a flexible entity. The converter search in the request the
parameters with names matching primary key.

You can specify witch connexion use in the option:

```php

/**
 * @ParamConverter("student", options={"session": "my_db2"})
 */
public function getAction(Student $student)
```

By default, the model used for find the entity is deduce by adding ``Model`` to
entity class name. If you have a different class name, you can use the ``model``
option:

```php

/**
 * @ParamConverter("student", options={"model": "StudentModel"})
 */
public function getAction(Student $student)
```

This feature require
[sensio/framework-extra-bundle](http://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/index.html).

## Serializer

You can use the
[serializer](https://symfony.com/doc/current/components/serializer.html)
component to serialize entities.

## Property info

This bundle also provide [property
info](https://symfony.com/doc/current/components/property_info.html) support to
retrieve flexible entity properties informations.

## Poolers as service

If you need to add additional poolers into the session builder all you need to do is tag a service definition with `pomm.pooler`

## Model and Model layer as a service

Model and model layer objects can be registered as a service.
For this to work properly you have to tag your service correctly and remove `class:session_builder` from configuration.

Models must be tagged with `pomm.model` and layers with `pomm.model_layer`

Both of those tags have the following parameters:
 * `pooler` which is the name of a default pooler service, if left blank the default is used
 * `session` which is the name of a default session service this is used from, if left blank the default is used
