<?php
/**
 * Wow Cache Manager
 *
 * @author yftzeng <yftzeng@gmail.com>
 * @copyright Copyright (c) 2011 Yi-Feng Tzeng
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://antbsd.twbbs.org/
 * @package org.twbbs.antbsd.wowsecmodules
 */

/**
 * Wow Cache Interface
 *
 * @package org.twbbs.antbsd.wowsecmodules
 */
Interface WowCacheInterface {

    /**
     * Add servers into memcached
     *
     * @param array $servers
     * @return void
     */
    function addExtraServers(array $servers = null);

    /**
     * Get servers list
     *
     * @return array
     */
    function getServerList();

    /**
     * Add key->data into cache manager, if key exists return null
     *
     * @param string $key key
     * @param string $data data
     * @param int $ttl time to live
     * @return bool
     */
    function add($key, $data, $ttl);

    /**
     * Set key->data into cache manager, no matter what if key is exists or not
     *
     * @param string $key key
     * @param string $data data
     * @param int $ttl time to live
     * @return bool
     */
    function set($key, $data, $ttl);

    /**
     * Store multiple items
     *
     * @param array[string] $items
     * @param int $ttl time to live
     * @return bool
     */
    function setMulti($items, $ttl);

    /**
     * Get the data of key from cache manager
     *
     * @param string $key key
     * @return mixed
     */
    function get($key);

    /**
     * Get the data of key from cache manager
     *
     * @param string $key key
     * @return mixed
     */
    function fetch($key);

    /**
     * Delete the data of key from cache manager
     *
     * @param string $key key
     * @return bool
     */
    function delete($key);

    /**
     * Delete the data of key from cache manager
     *
     * @param string $key key
     * @return bool
     */
    function remove($key);

    /**
     * Remove all of key->data in cache manager
     *
     * @return bool
     */
    function clear();

    /**
     * Remove all of key->data in cache manager
     *
     * @return bool
     */
    function flush();
}
?>
