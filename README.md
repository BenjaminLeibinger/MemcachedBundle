IslMemcachedBundle
==================

This Symfony Bundle provide Memcached integration into Symfony. It provides the configured pools as
Singleton. 

The Bundle is inpsired by: 
https://gist.github.com/benr77/258e42642b4632d5a826
https://github.com/LeaseWeb/LswMemcacheBundle

### Requirements

- php 5.4
- memcached 1.4 or higher 
- php-memcached 2.1 or higher

### Installation

To install IslMemcachedBundle with Composer just add the following to your 'composer.json' file:

    {
        require: {
            "isl/memcached-bundle": "*",
            ...
        }
    }

The next thing you should do is install the bundle by executing the following command:

    php composer.phar update isl/memcached-bundle

Finally, add the bundle to the registerBundles function of the AppKernel class in the 'app/AppKernel.php' file:

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Isl\MemcachedBundle\IslMemcachedBundle(),
            ...
        );

Install the following dependencies (in Debian based systems using 'apt'):

    apt-get install memcached php5-memcached

Do not forget to restart you web server after adding the Memcache module. 


### Configuration

Below you can see an example configuration for this bundle.

```yml
isl_memcached:
    pools:
        default:
            servers:
                - { host: 10.0.0.1, port: 11211, weight: 15 }
                - { host: 10.0.0.2, port: 11211, weight: 30 }
        pool2:
            servers:
                - { host: 10.0.0.3, port: 11211, weight: 15 }

```

### Usage

$memcache = $this->get('isl.memcached')->getInstance('defaultpool', "persistentId optional");

$memcache->set('foo', 'bar');
$memcache->get('foo');

### ADP: Anti Dog Pile

Based on: https://github.com/LeaseWeb/LswMemcacheBundle

The methods are modified to work with memcached extension.

### License

This bundle is under the MIT license.