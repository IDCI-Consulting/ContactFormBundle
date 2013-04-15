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
    "pagerfanta/pagerfanta": "dev-master",
    "white-october/pagerfanta-bundle": "dev-master",
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
        new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
        new IDCI\Bundle\ContactFormBundle\IDCIContactFormBundle(),
    );
}
```

As you can see, we use WhiteOctoberPagerFantaBundle to paginate list results.
So you have to define the max_per_page parameter in your app/config/parameters.yml

```yml
parameters:
    ...
    max_per_page:  25
```

Add needed routes in the `app/config/routing.yml` to use this bundle with all your forms anywhere

```yml
idci_contact_form_api:
    resource: "../../vendor/idci/contact-form-bundle/IDCI/Bundle/ContactFormBundle/Controller/ApiController.php"
    type:     annotation
    prefix:   /contact
```

If you wish access to an administration space, add this following controllers:

```yml
idci_contact_form_admin:
    resource: "../../vendor/idci/contact-form-bundle/IDCI/Bundle/ContactFormBundle/Controller/AdminController.php"
    type:     annotation
    prefix:   /admin

idci_contact_form_admin_source:
    resource: "../../vendor/idci/contact-form-bundle/IDCI/Bundle/ContactFormBundle/Controller/AdminSourceController.php"
    type:     annotation
    prefix:   /admin

idci_contact_form_admin_message:
    resource: "../../vendor/idci/contact-form-bundle/IDCI/Bundle/ContactFormBundle/Controller/AdminMessageController.php"
    type:     annotation
    prefix:   /admin
```

If you wish to see a form demo in action, you can add the contact demo controller

```yml
idci_contact_form_demo:
    resource: "../../vendor/idci/contact-form-bundle/IDCI/Bundle/ContactFormBundle/Controller/DemoController.php"
    type:     annotation
    prefix:   /contact-demo
```

Furthermore you can simply declare one route, which will include all controllers

```yml
idci_contact_form:
    resource: "../../vendor/idci/contact-form-bundle/IDCI/Bundle/ContactFormBundle/Controller"
    type:     annotation
    prefix:   /contact-form
```

Now the Bundle is installed.

Configure your database parameters in the `app/config/parameters.yml` then run

```sh
php app/console doctrine:schema:update --force
```
