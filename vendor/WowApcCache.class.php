<?php
/**
 * Wow ApcCache Manager
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
 * Wow APC Cache
 *
 * APC cache manager
 *
 * @package org.twbbs.antbsd.wowsecmodules
 */
class WowApcCache implements WowCacheInterface {

    /**
     * Add servers into memcached
     *
     * @param array $servers
     * @return void
     */
    function addExtraServers(array $servers = null) {
        throw new RuntimeException("ERROR: WowApcCache does not support addExtraServers.");
    }

    /**
     * Get servers list
     *
     * @return array
     */
    function getServerList() {
        return array('localhost');
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
        return apc_add($key, $data, $ttl);
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
        return apc_store($key, $data, $ttl);
    }

    /**
     * Store multiple items
     *
     * @param array[string] $items
     * @param int $ttl time to live
     * @return bool
     */
    function setMulti($items, $ttl = NULL) {
        $ttl = is_null($ttl) ? 0 : $ttl;
        foreach($items as $key=>$value) {
            if (!$this->set($key, $value, $ttl))
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
        return apc_fetch($key);
    }

    /**
     * Get the data of key from cache manager
     *
     * @param string $key key
     * @return mixed
     */
    function fetch($key) {
        return apc_fetch($key);
    }

    /**
     * Delete the data of key from cache manager
     *
     * @param string $key key
     * @return bool
     */
    function delete($key) {
        return apc_delete($key);
    }

    /**
     * Delete the data of key from cache manager
     *
     * @param string $key key
     * @return bool
     */
    function remove($key) {
        return apc_delete($key);
    }

    /**
     * Remove all of key->data in cache manager
     *
     * @return bool
     */
    function clear() {
        return apc_clear_cache();
    }

    /**
     * Remove all of key->data in cache manager
     *
     * @return bool
     */
    function flush() {
        return apc_clear_cache();
    }
}
?>
