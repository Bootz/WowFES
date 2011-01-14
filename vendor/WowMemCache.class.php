<?php
/**
 * Wow MemCache Manager
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
 * Wow Memcache Cache
 *
 * Memcache cache manager
 *
 * @package org.twbbs.antbsd.wowcache
 */
class WowMemCache implements WowCacheInterface {

    /**
     * Memcache connection variable
     *
     * @var object
     */
    private $connection;

    /**
     * Memcache default policy
     *
     * @return array
     */
    protected $_default_policy = array(
        'servers' => array(
                            array('host' => '127.0.0.1', 'port' => '11211', 'persistent' => false, 'weight' => 10, 'timeout' => 10, 'retry_interval' => 15),
                          ),
        'compressed' => 2,
        'life_time' => 900,
    );

    /**
     * Construct of memcache cache manager
     *
     * More detail constants in http://www.php.net/manual/en/memcache.constants.php
     *
     * @param array $policy
     * @return void
     */
    function __construct(array $policy = null) {
        if (is_array($policy)) {
            /*
             * If use array_merge may have duplicate server in list.
             * You may add 127.0.0.1 and its public ip into list.
             */
            //$this->_default_policy = array_merge($this->_default_policy, $policy);
            $this->_default_policy = $policy;
        }
        $this->connection = new Memcache();

        if( !empty($this->_default_policy['servers']) ) {
            foreach($this->_default_policy['servers'] as $server) {
                $this->connection->addServer($server['host'], $server['port'], $server['persistent'], $server['weight'], $server['timeout'], $server['retry_interval']);
            }
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
        foreach($servers as $server) {
            if( !$this->connection->addServer($server['host'], $server['port'], $server['persistent'], $server['weight'], $server['timeout'], $server['retry_interval']))
                throw new RuntimeException("ERROR: connect cache servers failed.");
        }
    }

    /**
     * Get servers list.
     *
     * @return array
     */
    function getServerList() {
        throw new RuntimeException("ERROR: WowMemCache does not support getServerList");
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
        $compressed = is_null($this->_default_policy['life_time']) ? 2 : $this->_default_policy['life_time'];
        $ttl = is_null($ttl) ? $this->_default_policy['life_time'] : $ttl;
        return $this->connection->add($key, $data, $compressed, $ttl);
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
        $compressed = is_null($this->_default_policy['life_time']) ? 2 : $this->_default_policy['life_time'];
        $ttl = is_null($ttl) ? $this->_default_policy['life_time'] : $ttl;
        return $this->connection->set($key, $data, $compressed, $ttl);
    }

    /**
     * Store multiple items
     *
     * @param array[string] $items
     * @param int $ttl time to live
     * @return bool
     */
    function setMulti($items, $ttl) {
        $ttl = is_null($ttl) ? $this->_default_policy['life_time'] : $ttl;
        foreach($items as $key=>$value) {
            if (!$this->connection->set($key, $value, $ttl))
                return FALSE;
        }
        return TRUE;
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
