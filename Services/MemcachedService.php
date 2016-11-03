<?php
/**
 * User: 'Benjamin Leibinger'
 * Date: 01.11.2016 20:12
 */

namespace Isl\MemcachedBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Isl\MemcachedBundle\Utils\MemcachedWrapper;

/**
 * Class MemcachedService
 * @package Isl\MemcachedBundle\Services
 */
class MemcachedService
{
    /**
     * @var array
     */
    private $pools = array();
    /**
     * @var Container
     */
    private $container;

    /**
     * MemcachedService constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param $pool
     * @param null $persistentId
     * @return MemcachedWrapper|mixed
     */
    public function getInstance($pool, $persistentId = null)
    {
        if(array_key_exists($pool, $this->pools)) {
            return $this->pools[$pool];
        }

        $pools = $this->container->getParameter('isl_memcached.pools_config');

        if(!array_key_exists($pool, $pools))
        {
            throw new ParameterNotFoundException($pool, 'isl_memcached', 'pools_config');
        }
        $config = $pools[$pool];

        $memcached = new MemcachedWrapper($persistentId);
        $memcached->addServers($config['servers']);

        $this->pools[$pool] = $memcached;

        return $memcached;
    }

}