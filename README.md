# TIG MaxCDN for Magento 2

We created this extension to improve the workability of MaxCDN with Magento 2. At this point the moments at which MaxCDN's refreshes its
servers are depended on them. They poll periodically if new files have been uploaded or download them upon request. This means that the
first request is always slower than it could be.

* But what if you change an already existing image or file?
* What if you made changes to your JS- or CSS-code?

If you forgot to login to your MaxCDN-account and purge your pull zone after you made the above changes, it'll mean that your layout 
breaks.

You can imagine that it makes more sense to let Magento decide when the files on your MaxCDN pull zone are refreshed, instead of the 
other way around. This extension makes your M2 installation and MaxCDN work together, instead of seperately.

## What does it do?
* It purges all available pull zones in your account, when:
  * You press the 'Purge All Pull Zones'-button within the Cache Management-page, or
* Whenever the following happens:
  * Flush Magento Cache,
  * Flush Cache Storage,
  * Flush Catalog Images Cache,
  * Flush JS/CSS Cache,
  * Upload a product image.

At this point this extension has only been tested on Magento 2.1.11, but we will make it compatible with more recent versions in upcoming
releases.

## Installation using Composer

<pre>composer require tig/maxcdn-magento2</pre>

## Configuration

This module's configuration can be found under _Stores > Configuration > Advanced > MaxCDN_.

#### To create your API Application
* Make sure you're logged in to your MaxCDN-account and follow [this URL](https://cp.maxcdn.com/account/api)
* Click on 'Create Application'
* Enter a Name and Description for your API-application, the Application URL and Callback URL should replicate your store-URL
* Allow API key full permission to this account
* Click on 'Update' and you'll be presented with the necessary credentials to configure the extension.
* **Don't forget to Whitelist your servers' IP!**

#### Further Configuration
* Take note of the _Company Alias_, the _Consumer Key_ and the _Consumer Secret_ and enter them in the corresponding
fields of this Magento 2 module's configuration page.

