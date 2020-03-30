Tested with PHP 7.4.3

settings are in src/cass/settings/Settings.php

There is an htaccess file at the root that deny access to all but index.php. That seems to not affect parent directories.

## Errors :
### 1000
Encryption in .env file is wrong, *STARTTLS* or *SMTPS* must be used.

### 2000
Error with the template engine.

### 3000
The provide E-mail is not valid according to the E-mail validations settings.

### 4000
Error in MailSend class while sending the mail.