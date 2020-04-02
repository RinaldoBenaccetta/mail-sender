# Mail sender

Tested with PHP 7.4.3

settings are in src/cass/settings/Settings.php

There is an htaccess file at the root that deny access to all but index.php. That seems to not affect parent directories.

## templating

Templates are in Twig ( https://twig.symfony.com/ ) and should be put in */src/templates/* folder.

Custom templates can be specified in POST with the value *template*. If no one is specified, the default one sets in settings will be used. If no one is set in settings, an error will occur.

The values can be all ones sends by POST, and can be accessed like this : {{ myValue }}. Object values can be accessed like this : *{{ myObject.myValue }}*

## Subject

Subject can be set in POST with the value subject.

## Response
### From an HTML form
If redirect value is true, the page will be redirected according to *mailOK* and *mailError* values. If *mailOk* is not provided, the default one in settings will be used. If *mailError* is not provided, the default one in settings will be used.

If redirect value is not set or set to false, a page with *ok* or the error will be displayed.

Default error page must be set in Settings->redirect->defaultMailErrorPage and the page must be created for backup in case of POST error.

### From other clients (JS, PHP,...)
A message with *ok* will be send in case of succes. If an error occur, a response with the error number will be sended, in this form : **error:number**, eg. : **error:1000**


## Errors :
### 1000

Critical.

Encryption in .env file is wrong, *STARTTLS* or *SMTPS* must be used.

### 2000

Error.

Error with the template engine.

### 3000

Notice.

The provided E-mail is not valid according to the E-mail validations settings.

### 4000

Critical.

Error in MailSend class while sending the mail.

### 5000

Warning.

Invalid option exception. There is a problem with provided arguments.

#### 5010
Sender name is not provided or have no default in settings.

#### 5020
Sender mail is not provided or have no default in settings.

#### 5030
Recipient name is not provided or have no default in settings.

#### 5040
Recipient mail is not provided or have no default in settings.

#### 5050
Subject is not provided or have no default in settings.

#### 5060
Template is not provided or have no default in settings.

#### 5070
$_POST is empty or not provided. Verify if you send datas or if the method is POST and no GET.

### 9000

Error.

Undetermined error.