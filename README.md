# # PHP Knack Rest Client

# Requirements

- PHP >= 5.4.9

# Installation

1. Download and Install PHP Composer.

   ``` sh
   curl -sS https://getcomposer.org/installer | php
   ```

2. Next, run the Composer command to install the latest version of php knack rest client.
   ``` sh
   php composer.phar require darkdiesel/php-knack-rest-client "^1.0.0a"
   ```
    or add the following to your composer.json file.
   ```json
   {
       "require": {
           "darkdiesel/php-knack-rest-client": "^1.0.0a"
       }
   }
   ```
   **Note:**
   If you are using **laravel 5.0 or 5.1**(this version dependent on phpdotenv 1.x), then use **"1.5.\*"** version instead.

3. Then run Composer's install or update commands to complete installation. 

   ```sh
   php composer.phar install
   ```

4. After installing, you need to require Composer's autoloader:

   ```php
   require 'vendor/autoload.php';
   ```
   
# Configuration
   
## use array

create Service class with ArrayConfiguration parameter.

```php
use KnackRestApi\Record\RecordService;
use KnackRestApi\Configuration\ArrayConfiguration;

$rs = new RecordService(new ArrayConfiguration(
            array(
                'knackAppId' => 'application_id',
                'knackRestApiKey' => 'rest_api_key',
            )
        ));
```

# Usage

TODO!

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

