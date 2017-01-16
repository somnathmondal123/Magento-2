![ICEPAY](https://camo.githubusercontent.com/49043ebb42bd9b98941d6013761d4aadcd33f14f/68747470733a2f2f6963657061792e636f6d2f6e6c2f77702d636f6e74656e742f7468656d65732f6963657061792f696d616765732f6865616465722f6c6f676f2e737667)

Payment Module for Magento 2
============================

Make payments in your Magento 2 webshop possible. Download the special Magento 2 webshop module [here](https://github.com/ICEPAYdev/Magento-2/releases), and you will be able to offer the most frequently used national and international online payment methods.

License
-------

Our module is available under the BSD-2-Clause. See the [LICENSE](https://github.com/ICEPAYdev/Magento-2/blob/master/LICENSE.md) file for more information.

Installation
------------

### Install by Composer:

1. Go to the Magento 2 root folder

2. Add ICEPAY Payment Module repository to composer:

    ```bash
    composer config repositories.icepay git https://github.com/ICEPAYdev/Magento-2.git
    ```

3. Install the module:

    ```bash
    composer require icepay/icepay-magento2-module:dev-master
    ```
4. Enable the module:

    ```bash
    php bin/magento setup:upgrade
    php bin/magento setup:static-content:deploy
    ```
    
### Install by uploading files:

#### Download the module as "zip" archive

1. Download the latest release

2. Extract the archive to app/code/Icepay/IcpCore

3. Enable the module:

    ```bash
    php bin/magento setup:upgrade
    php bin/magento setup:static-content:deploy
    ```

#### Clone this repository

1. Go to app/code folder

2. Clone this repository

  * Use HTTPS:
    ```bash
    git clone https://github.com/ICEPAYdev/Magento-2.git Icepay/IcpCore
    ```
  * Alternatively, use SSH: 
    ```bash
    git clone git@github.com:ICEPAYdev/Magento-2.git Icepay/IcpCore
    ```
4. Enable the module:

    ```bash
    cd ../../
    php bin/magento setup:upgrade
    php bin/magento setup:static-content:deploy
    ```
   
User documentation
------------------

Coming soon!
    
Contributing
------------

* Fork it
* Create your feature branch (`git checkout -b my-new-feature`)
* Commit your changes (`git commit -am 'Add some feature'`)
* Push to the branch (`git push origin my-new-feature`)
* Create new Pull Request

Bug report
----------

If you found a repeatable bug, and troubleshooting tips didn't help, then be sure to [search existing issues](https://github.com/ICEPAYdev/Magento-2/issues) first. Include steps to consistently reproduce the problem, actual vs. expected results, screenshots, and your PrestaShop version and Payment module version number. Disable all other third party extensions to verify the issue is a bug in the Payment module.
