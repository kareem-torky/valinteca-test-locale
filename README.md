## Localization package
A composer package from Valinteca that introduces an easy integration with [Localization](https://www.Localization.com/index.php?lang=Ar) platform for Laravel applications.

## Features
- Send SMS messages
- Send personalized messages
- Send & verify OTP codes
- Manage senders
- Message cost calculation
- Balance inquiry

## Installation
```
composer require valinteca/Localization
```
<br>

To publish configurations:
```
php artisan vendor:publish --provider="Valinteca\Localization\LocalizationServiceProvider"
```
This will publish config file to config/Localization.php

<br>

Then add these keys to .env file:
```
Localization_USERNAME="VALUE_HERE" # From your Localization subscription
Localization_API_KEY="VALUE_HERE" # From your Localization subscription
Localization_SENDER_NAME="VALUE_HERE" # Custom sender name
Localization_LANG="VALUE_HERE" # Language ("En" or "Ar")
```

## Usage

```php
use Valinteca\Localization\Facades\Localization;
```

### **Send message**

*to:* acccepts number or array of numbers

*at:* accepts time to send in format "Y-m-d H:i:s" or a *Carbon* instance

*message:* acccepts message text

*send:* performs operation and returns response

***Examples***
* with default settings:
```php
Localization::to('05xxxxxxxx')
    ->message('hello world')
    ->send();
```
* Custom sender: <br>
Use *sender* method for custom sender name. If you didn't use this method then default sender name from config/env will be used.
```php
Localization::sender('another sender')
    ->to('05xxxxxxxx')
    ->message('hello world')
    ->send();
```
* Multiple numbers: <br>
Pass an array to *to* method.
```php
Localization::to(['05xxxxxxxx', '05xxxxxxxx'])
    ->message('hello world')
    ->send();
```
* At later time: <br>
Pass datetime to *at* method.
```php
// Using string datetime format
Localization::to('05xxxxxxxx', '05xxxxxxxx')
    ->message('hello world')
    ->at('2023-05-01 20:10:05')
    ->send();

// Using carbon instance
Localization::to('05xxxxxxxx', '05xxxxxxxx')
    ->message('hello world')
    ->at(now()->addMinutes(5))
    ->send();
```
* Custom options: <br>
Pass options to *options* method
Available options are:

    1- reqBulkId: to get msg id of the bulk (*true* or *false*, default is *false*)

    2- msgEncoding: (*UTF8* or *windows-1256*, default is *UTF8*)

    3- reqFilter: to filter the duplicated numbers (*true* or *false*, default is *true*)
```php
Localization::to('05xxxxxxxx')
    ->options([
        'reqBulkId' => true,
        'msgEncoding' => 'windows-1256',
        'reqFilter' => false,
    ])
    ->message('hello world')
    ->send();
```
<br>

### **Send personalized messages**
Personalized messages are message with different SMS content for each number in array. To send personalized messages use *sendPersonalized* method with an array of variables for each number.

Message body should contain the message body including the variables that should be between curly brackets {}.

```php
Localization::to(['05xxxxxxxx', '05yyyyyyyy'])
    ->message('Hello {name}. Your order {order} will be delivered soon')
    ->sendPersonalized([
        ['name' => 'Mohammed', 'order' => '123'],
        ['name' => 'Ahmed', 'order' => '456'],
    ]);

    // Messages:
    // 05xxxxxxxx: "Hello Mohammed. Your order 123 will be delivered soon" 
    // 05yyyyyyyy: "Hello Ahmed. Your order 456 will be delivered soon"
```

### **Send test message**
You can test Localization API for free . You will get free sms every day . To test service you can send sms using *sendTestMessage* method.

This method uses predefined sender name and message text. so you will define numbers only.
```php
Localization::to('05xxxxxxxx')
    ->sendTestMessage();
```

### **Balance Inquiry**
To inquire about your balance use *getBalance* method
```php
Localization::getBalance();
```

### **Get messages**
To get messages for bulk ID use *forbulkId* method with *getMessages*. The result is paginated and default return is page 1.
```php
Localization::forBulkId('bulk-id-returned-from-send-method')
    ->getMessages();
```
To define page number use *page* method:
```php
Localization::forBulkId('bulk-id-returned-from-send-method')
    ->page(2)
    ->getMessages();
```
To define limit use *limit* method:
```php
Localization::forBulkId('bulk-id-returned-from-send-method')
    ->page(1)
    ->limit(5)
    ->getMessages();
```

### **Calculate message cost**
```php
Localization::to(['05xxxxxxxx', '05yyyyyyyy'])
    ->message('this is message')
    ->calculateCost();
```
*Response:*
```json
{
    "success": true,
    "data": {
        "cost": "3,9"
    }
}
```

### **Get user balance**
```php
Localization::getBalance();
```
*Response:*
```json
{
    "success": true,
    "data": {
        "balance": "3042.00"
    }
}
```