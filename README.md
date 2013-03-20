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

Add needed routes in the `app/config/routing.yml` to use this bundle with all your forms anywhere

```yml
idci_contact_form_api:
    resource: "../../vendor/idci/contact-form-bundle/IDCI/Bundle/ContactFormBundle/Controller/ApiController.php"
    type:     annotation
    prefix: /contact
```

If you wish to see a form demo in action, you can add a contact demo controller

```yml
idci_contact_form_demo:
    resource: "../../vendor/idci/contact-form-bundle/IDCI/Bundle/ContactFormBundle/Controller/DemoController.php"
    type:     annotation
    prefix: /contact-demo
```

Now the Bundle is installed.

Configure your database parameters in the `app/config/parameters.yml` then run

```sh
php app/console doctrine:schema:update --force
```
