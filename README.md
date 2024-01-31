# README #

## WebIt OrderExtended ##

This module is used to add special comments to the order. 

## Installation ##

upload the module files to app/code/WebIt/OrderExtended

Then we run the following commands in the console:

* php bin/magento module:enable WebIt_OrderExtended
* php bin/magento setup:upgrade
* php bin/magento setup:di:compile
* php bin/magento setup:static-content:deploy
* php bin/magento cache:flush

## Usage ##

Module configuration can be found in 

#### Stores -> Configuration -> WebIt -> OrderExtended. ####

The module handles configuration settings for scope store.

----------------

To test in developer mode use the command 
#### bin/magento queue:consumers:start WebItOrderCreate --max-messages=1 #### 

before or after placing your order

------------------

After placing the order, the comment will be visible when editing the order in the Information tab in "Notes for this Order".

