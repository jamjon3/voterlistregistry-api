# VoterListRegistryAPI

A Composer library for the VoterListRegistry API

## Install

*Via Composer*

``` bash
composer require ymd/voterlistregistry-api
```

### Publish the configuration
Then you will need to run vendor publish to create the configuration file. 

``` bash
$ php artisan vendor:publish
```

This will create voterlistregistry-api.php in the config directory. You will need to update the configuration... You should set the values in your .env file. Here are the configuration values...

#### Host
Where your host is... this is with the actual path to VoterListRegistry.
```
VOTERLISTREGISTRY_HOST=http://example.com
```

#### JWT Username
This is the username used for requesting a JWT token.
```
VOTERLISTREGISTRY_USERNAME=admin
```

#### JWT Password
This is the password used for requesting a JWT token.
```
VOTERLISTREGISTRY_PASSWORD=password
```
