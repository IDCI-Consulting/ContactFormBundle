ContactFormBundle
=================

Symfony2 contact form bundle and social sharing


Instalation
===========

To install this bundle please follow the next steps:

First add the dependencies to your `composer.json` file:

```json
"require": {
    ...
    "idci/contact-form-bundle": "dev-master"
},
```

Then install the bundle with the command:

```sh
php composer update
```

Enable the bundle in your application kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IDCI\Bundle\ContactFormBundle\IDCIContactFormBundle(),
    );
}
```

Now the Bundle is installed.

Configure your database parameters in the `app/config/parameters.yml` then run

```sh
php app/console doctrine:schema:update --force
```