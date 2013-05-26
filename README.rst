RouffjHowToBundle
=================

Project which experiment "Learning By Automatic Testing" concept.

Installation
------------

Step 1: Download RouffjHowToBundle using Composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Tell composer to add RouffjHowToBundle in your composer.json and download it by running the command:

::

    $ composer.phar require "rouffj/howto-bundle dev-master"

Composer will install the bundle to your project's vendor/rouffj directory.

Step 2: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Enable the bundle in the kernel:

::

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Rouffj\Bundle\HowToBundle\RouffjHowToBundle(),
        );
    }

Step 3: Configure bundle
~~~~~~~~~~~~~~~~~~~~~~~~

Add to your ``app/config/config.yml`` in ``imports`` directive:

::

    - { resource: @RouffjHowToBundle/Resources/config/config.yml }

Add to your ``app/config/routing.yml``:

::

    _howto_bundle:
        resource: "@RouffjHowToBundle/Resources/config/routing.yml"
