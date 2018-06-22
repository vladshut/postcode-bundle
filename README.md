Apiwise Postcode Bundle
=======================

This bundle can be useed to fetch Address details from zipcode with number.
An account at Apiwise is required. For more information please take a look at: https://www.postcodeapi.nu

[![Build Status](https://travis-ci.org/Shivella/postcode-bundle.svg?branch=master)](https://travis-ci.org/Shivella/postcode-bundle) [![Latest Stable Version](https://poser.pugx.org/vladshut/postcode-bundle/v/stable)](https://packagist.org/packages/vladshut/postcode-bundle) [![License](https://poser.pugx.org/vladshut/postcode-bundle/license)](https://packagist.org/packages/vladshut/postcode-bundle) [![Total Downloads](https://poser.pugx.org/vladshut/postcode-bundle/downloads)](https://packagist.org/packages/vladshut/postcode-bundle) [![Coverage Status](https://coveralls.io/repos/github/Shivella/postcode-bundle/badge.svg)](https://coveralls.io/github/Shivella/postcode-bundle) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Shivella/postcode-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Shivella/postcode-bundle/?branch=master)

Installation
------------
Installation is a quick 4 step process:

1. Download postcode-bundle using composer
2. Enable the Bundle in AppKernel.php
3. Configure Apiwise credentials
4. Add routes

### Step 1: Download postcode-bundle using composer

Add PostcodeBundle by running the command:

``` bash
$ composer require vladshut/postcode-bundle
```

### Step 2: Enable the Bundle in AppKernel.php


``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new PostcodeBundle\PostcodeBundle(),
    );
}
```

### Step 3: Configure Apiwise credentials
```yaml
# app/config/config.yml

# Apiwise Postcode API
app_postcode:
    apiwise:
        key: secret_api_wise_key

```

### Step 4. Add routes
```yaml
# app/config/routing.yml

postcode:
    resource: "@PostcodeBundle/Resources/config/routing.yml"
    prefix:   /

```

Usage Services
--------------
``` php
$address = $this->get('app.postcode.client')->getAddress('1012JS', 1);
	
$address->getStreet();       // Dam
$address->getCity();         // Amsterdam
$address->getMunicipality(); // Amsterdam
$address->getProvince();     // Noord-Holland
$address->getNumber();       // 1
$address->getZipcode();      // 1012JS
$address->getGeoLocation();  // array('latitude' => 52.3732926, 'longitude' => 4.8937176)
```

Usage from API
--------------

Or try the API response:

http://127.0.0.1:8000/api/postcode?postcode=2011WD&nummer=2
