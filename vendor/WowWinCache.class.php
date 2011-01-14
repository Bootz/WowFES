<?php
/**
 * Wow WinCache Manager
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
 * Wow WinCache
 *
 * Wincache manager
 *
 * @package org.twbbs.antbsd.wowsecmodules
 */
class WowWinCache implements WowCacheInterface {

    /**
     * Add servers into memcached
     *
     * @param array $servers
     * @return void
     */
    function addExtraServers(array $servers = null) {
        throw new RuntimeException("ERROR: WowWinCache does not support addExtraServers.");
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
        return wincache_ucache_add($key, $data, $ttl);
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
        return wincache_ucache_set($key, $data, $ttl);
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
        return wincache_ucache_get($key);
    }

    /**
     * Get the data of key from cache manager
     *
     * @param string $key key
     * @return mixed
     */
    function fetch($key) {
        return wincache_ucache_get($key);
    }

    /**
     * Delete the data of key from cache manager
     *
     * @param string $key key
     * @return bool
     */
    function delete($key) {
        return wincache_ucache_delete($key);
    }

    /**
     * Delete the data of key from cache manager
     *
     * @param string $key key
     * @return bool
     */
    function remove($key) {
        return wincache_ucache_delete($key);
    }

    /**
     * Remove all of key->data in cache manager
     *
     * @return bool
     */
    function clear() {
        return wincache_ucache_clear();
    }

    /**
     * Remove all of key->data in cache manager
     *
     * @return bool
     */
    function flush() {
        return wincache_ucache_clear();
    }
}
?>
