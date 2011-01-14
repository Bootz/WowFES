<?php
/**
 * Wow MemCached Manager
 *
 * @author yftzeng <yftzeng@gmail.com>
 * @copyright Copyright (c) 2011 Yi-Feng Tzeng
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://antbsd.twbbs.org/
 * @package org.twbbs.antbsd.wowsecmodules
 */

include_once('interface/WowCacheInterface.php');

/**
 * Wow Memcached Cache
 *
 * Memcached cache manager
 *
 * @package org.twbbs.antbsd.wowcache
 */
class WowMemCached implements WowCacheInterface {

    /**
     * Memcached connection variable
     *
     * @var object
     */
    private $connection;

    /**
     * Memcached default policy
     *
     * Here said memcached persistent connection has a memory leak bug:
     * http://brian.moonspot.net/php-memcached-issues
     *
     * @return array
     */
    protected $_default_policy = array(
        'name' => 'antbsd',
        'servers' => array(
                            array('host' => '127.0.0.1', 'port' => '11211', 'weight' => 10),
                          ),
        'timeout' => 10,
        'retry_interval' => 15,
        'compressed' => true,
        'life_time' => 900,
    );

    /**
     * Construct of memcached cache manager
     *
     * More detail constants in http://php.net/manual/en/memcached.constants.php
     *
     * @param array $policy
     * @return void
     */
    function __construct(array $policy = null) {
        if (is_array($policy)) {
            //$this->_default_policy = array_merge($this->_default_policy, $policy);
            $this->_default_policy = $policy;
        }
        $this->connection = new Memcached($this->_default_policy['name']);

        /**
         * Enables or disables payload compression.
         * When enabled, item values longer than a certain threshold (currently 100 bytes) will be compressed during storage and decompressed during retrieval transparently.
         */
        if (!$this->_default_policy['compressed'])
            $this->connection->setOption(Memcached::OPT_COMPRESSION, $this->_default_policy['compressed']);

        /**
         * Set the value of the timeout during socket connection (milliseconds)
         */
        $this->connection->setOption(Memcached::OPT_CONNECT_TIMEOUT, $this->_default_policy['timeout']);

        /**
         * The amount of time, in seconds, to wait until retrying a failed connection attempt (seconds)
         */
        $this->connection->setOption(Memcached::OPT_RETRY_TIMEOUT, $this->_default_policy['retry_interval']);

        /**
         * The method of distributing item keys to the servers.
         * Currently supported methods are modulo and consistent hashing. Consistent hashing delivers better distribution and allows servers to be added to the cluster with minimal cache losses.
         *
         * It is highly recommended to enable this option if you want to use consistent hashing.
         */
        if ($this->connection->getOption(Memcached::OPT_DISTRIBUTION))
            $this->connection->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);

        if( !empty($this->_default_policy['servers']) ) {
            if( !$this->connection->addServers( $this->_default_policy['servers'] ) )
                throw new RuntimeException("ERROR: connect cache servers failed.");
        } else {
            throw new LogicException("ERROR: No cache server found.");
        }
    }

    /**
     * Add servers into memcached
     *
     * @param array $servers
     * @return void
     */
    function addExtraServers(array $servers = null) {
        if( !$this->connection->addServers( $servers ))
            throw new RuntimeException("ERROR: connect cache servers failed.");
    }

    /**
     * Get servers list
     *
     * @return array
     */
    function getServerList() {
        return $this->connection->getServerList();
    }

    /**
     * Add key->data into cache manager, if key exists return null
     *
     * @param string $key key
     * @param string $data data
     * @param int $ttl time to live
     * @return bool
     */
    function add($key, $data, $ttl) {
        $ttl = is_null($ttl) ? $this->_default_policy['life_time'] : $ttl;
        return $this->connection->add($key, $data, $ttl);
    }

    /**
     * Set key->data into cache manager, no matter what if key is exists or not
     *
     * @param string $key key
     * @param string $data data
     * @param int $ttl time to live
     * @return bool
     */
    function set($key, $data, $ttl) {
        $ttl = is_null($ttl) ? $this->_default_policy['life_time'] : $ttl;
        return $this->connection->set($key, $data, $ttl);
    }

    /**
     * Store multiple items
     * @return bool
     */
    function setMulti($items, $ttl) {
        $ttl = is_null($ttl) ? $this->_default_policy['life_time'] : $ttl;
        return $this->connection->setMulti($items, $ttl);
    }

    /**
     * Get the data of key from cache manager
     *
     * @param string $key key
     * @return mixed
     */
    function get($key) {
        return $this->connection->get($key);
    }

    /**
     * Get the data of key from cache manager
     *
     * @param string $key key
     * @return mixed
     */
    function fetch($key) {
        return $this->connection->get($key);
    }

    /**
     * Delete the data of key from cache manager
     *
     * @param string $key key
     * @return bool
     */
    function delete($key) {
        return $this->connection->delete($key, 0);
    }

    /**
     * Delete the data of key from cache manager
     *
     * @param string $key key
     * @return bool
     */
    function remove($key) {
        return $this->connection->delete($key, 0);
    }

    /**
     * Remove all of key->data in cache manager
     *
     * @return bool
     */
    function clear() {
        return $this->connection->flush();
    }

    /**
     * Remove all of key->data in cache manager
     *
     * @return bool
     */
    function flush() {
        return $this->connection->flush();
    }
}
?>
