ApiWise Postcode Bundle
=======================

This bundle can be useed to fetch Address details from zipcode with number.
An account at ApiWise is required.

Installation
------------
Installation is a quick 3 step process:

1. Download postcode-bundle using composer
2. Enable the Bundle in AppKernel.php
3. Configure ApiWise credentials
4. Add routes

### Step 1: Download postcode-bundle using composer

Add UsoftPostcodeBundle by running the command:

``` bash
$ composer require shivella/postcode-bundle
```

### Step 2: Enable the Bundle in AppKernel.php


``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Usoft\PostcodeBundle\UsoftPostcodeBundle(),
    );
}
```

### Step 3: Configure ApiWise credentials
```yaml
# app/config/config.yml

# ApiWise Postcode API
usoft_postcode:
    apiwise:
        key: secret_api_wise_key

```

### Step 4. Add routes
```yaml
# app/config/routing.yml

postcode:
    resource: "@UsoftPostcodeBundle/Resources/config/routing.yml"
    prefix:   /

```

Usage Services
--------------
``` php
$address = $this->get('usoft.postcode.client')->getAddress('1012JS', 1);
	
$address->getStreet();     // Dam
$address->getCity();       // Amsterdam
$address->getProvince();   // Noord-Holland
```

Usage from API
--------------

Or try the API response:

http://127.0.0.1:8000/api/postcode?postcode=1012JS&nummer=1
