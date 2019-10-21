# Mobily.ws Package
=======================
[![GitHub issues](https://img.shields.io/github/issues/greatsami/mobilyws)](https://github.com/greatsami/mobilyws/issues)
[![GitHub forks](https://img.shields.io/github/forks/greatsami/mobilyws)](https://github.com/greatsami/mobilyws/network)
[![GitHub stars](https://img.shields.io/github/stars/greatsami/mobilyws)](https://github.com/greatsami/mobilyws/stargazers)
![Packagist (custom server)](https://img.shields.io/packagist/dt/greatsami/mobilyws?server=https%3A%2F%2Fpackagist.org)

It a package to Send SMS messages, improved from [AbdullahObaid Laravel-SMS](https://github.com/AbdullahObaid/Laravel-SMS) with Laravel 6.* compatibility.
Gateway is support [Mobily.ws](https://www.mobily.ws/) only.   

#### Features & Requirements:
* Supports sending messages directly
* Supports sending messages at a certain date/time
* Supports sending messages to multiple numbers at once
* Supports multiple number formats.
* Supports delete scheduled SMS not sent ready.
* Support add Sender Name, activate it, check its status, and delete it.
* Support to change your account password, or retrieve it if you forgot it.
* Supports Laravel 6.*
* cURL 
* php >=7.2

#### Installation
Install the package with composer:

`composer require greatsami/mobilyws`

Note: You don\'t need to register it in service provider or aliases, It is auto-discover package.

#### config
Publish the configuration file by running the following Artisan command.

```php
$ php artisan vendor:publish --provider="Greatsami\Mobilyws\MobilywsServiceProvider"
```
Finally, you need to edit the configuration file at  `config/mobilyws.php` with your own information.

#### Usage

##### Check Balance
`Mobilyws::balanceSMS();`

##### Send SMS
`Mobilyws::sendSMS($numbers, $msg, $timeSend=0, $dateSend=0, $deleteKey=0)`

* $numbers: you can add single mobile number for Saudi Arabia numbers only like '9665XXXXXXXX' or '05XXXXXXXX' or '+9665XXXXXXXX'.

* But for other Countris you should add full number with country code "without zeros"

* Other way if you need send SMS to multiple numbers, you sou should to push numbers to array like:
$numbers = ['9665XXXXXXX1', '9665XXXXXXX2', '9665XXXXXXX3', ..., '9665XXXXXXXN'];

* $timeSend: you can specify send time like hh:mm:ss
* $dateSend: you can specify send date like mm/dd/yyyy
* $deleteKey: if you want to delete this message after send, just remove '0'.

##### Check send status
`Mobilyws::sendStatus();`

##### Change Password
`Mobilyws::changePassword($newPassAccount);`

##### Forget Password
`Mobilyws::forgetPassword($sendType);`

ask mobily.ws about your account type.


##### Forget Password
`Mobilyws::sendSMSWK($numbers, $msg, $msgKey, $timeSend=0, $dateSend=0, $deleteKey=0);`

ask mobily.ws about your account type.


##### Send SMS with unique template saved in mobily.ws
`Mobilyws::sendSMSWK($numbers, $msg, $msgKey, $timeSend=0, $dateSend=0, $deleteKey=0);`

* same sendSMS function description.
* $msgKey: it is template key number saved in Mobily.ws dashboard.

##### Delete SMS
`Mobilyws::deleteSMS();`

##### Add sender name
`Mobilyws::addSender($sender);`

##### Activate sender name
`Mobilyws::activeSender($senderId, $activeKey);`

##### Check sender name status
`Mobilyws::checkSender($senderId);`

##### Add alpha sender name
`Mobilyws::addAlphaSender($sender);`

##### Check alpha sender name status
`Mobilyws::checkAlphasSender($sender);`


#### License
MIT
