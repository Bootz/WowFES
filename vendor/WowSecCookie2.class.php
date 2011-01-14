<?php
/**
 * Wow Secure Cookie Manager 2
 *
 * @author Matthieu Huguet (http://bigornot.blogspot.com/)
 * @author Yi-Feng Tzeng <yftzeng@gmail.com>
 * @copyright Copyleft 2008, Matthieu Huguet, All wrongs reserved
 * @copyright Copyright (c) 2011 Yi-Feng Tzeng
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://antbsd.twbbs.org/
 * @package org.twbbs.antbsd.wowsecmodules
 */

/**
 * Wow Secure Cookie Manager 2 class
 *
 * @package org.twbbs.antbsd.wowsecmodules
 * Ref: http://bigornot.blogspot.com/2008/06/securing-cookies-php-implementation.html
 */
class WowSecCookie2
{

    /**
     * Server secret key
     * @var string
     */
    protected $_secret = '';

    /**
     * Encrypt/Decrypt IV, only works if PHP version >= 5.3.3
     * Must be 16 bytes long
     * @var string
     */
    protected $_iv = '1234567890123456';

    /**
     * Cryptographic algorithm used to encrypt cookies data
     * Ref: http://www.php.net/manual/en/function.openssl-get-cipher-methods.php
     * @var object
     */
    protected $_algorithm = 'AES-128-CBC';

    /**
     * Salt for Hash algorithm used to hash cookies data
     * @var string
     */
    protected $_salt = 'badbadguy';

    /**
     * Default cookie expired time
     * @var int
     */
    protected $_default_expire = 86400;

    /**
     * Hash algorithm used to hash cookies data
     * Ref: http://www.php.net/manual/en/function.hash-algos.php
     * @var string
     */
    protected $_hash = 'sha1';

    /**
     * Enable high confidentiality for cookie value (symmetric encryption)
     * @var bool
     */
    protected $_highConfidentiality = true;

    /**
     * Enable SSL support
     * @var bool
     */
    protected $_ssl = FALSE;

    /**
     * Constructor
     *
     * Initialize cookie manager and mcrypt module.
     *
     * @param string $secret server's secret key
     * @param array $config
     */
    public function __construct($secret, $config = null)
    {
        if (empty($secret)) {
            throw new Exception('You must provide a secret key');
        }

        $this->_secret = $secret;

        if ($config !== null && !is_array($config)) {
            throw new Exception('Config must be an array');
        }

        if (is_array($config)) {
            if (isset($config['algorithm']))
                $this->_algorithm = $config['algorithm'];
            if (isset($config['iv']))
                $this->_iv = $config['iv'];
            if (isset($config['salt']))
                $this->_salt = $config['salt'];
            if (isset($config['default_expire']))
                $this->_default_expire = $config['default_expire'];
            if (isset($config['hash']))
                $this->_hash = $config['hash'];
            if (isset($config['high_confidentiality']))
                $this->_highConfidentiality = $config['high_confidentiality'];
            if (isset($config['enable_ssl']))
                $this->_ssl = $config['enable_ssl'];
        }

        if (in_array($this->_algorithm, openssl_get_cipher_methods()) === FALSE) {
            throw new Exception('Error while loading mcrypt module');
        }
    }

    /**
     * Get the high confidentiality mode
     *
     * @return bool TRUE if cookie data encryption is enabled, or FALSE if it isn't
     */
    public function getHighConfidentiality()
    {
        return ($this->_highConfidentiality);
    }

    /**
     * Set the high confidentiality mode
     * Enable or disable cookie data encryption
     *
     * @param bool $enable  TRUE to enable, FALSE to disable
     */
    public function setHighConfidentiality($enable)
    {
        $this->_highConfidentiality = $enable;
        return ($this);
    }

    /**
     * Get the SSL status (enabled or disabled?)
     *
     * @return bool TRUE if SSL support is enabled, or FALSE if it isn't
     */
    public function getSSL()
    {
        return ($this->_ssl);
    }

    /**
     * Enable SSL support (not enabled by default)
     * pro: protect against replay attack
     * con: cookie's lifetime is limited to SSL session's lifetime
     *
     * @param bool $enable TRUE to enable, FALSE to disable
     */
    public function setSSL($enable)
    {
        $this->_ssl = $enable;
        return ($this);
    }

    /**
     * Hash username for more secure
     *
     * @param string $username username
     */
    public function doHash($username) {
        if ($this->_hash === 'sha1') {
            return sha1($username . $this->_salt);
        }
        else if ($this->_hash === 'md5') {
            return md5($username . $this->_salt);
        }
    }

    /**
     * Send a secure cookie
     *
     * @param string $name cookie name
     * @param string $value cookie value
     * @param string $username user name (or ID)
     * @param integer $expire expiration time
     * @param string $path cookie path
     * @param string $domain cookie domain
     * @param bool $secure when TRUE, send the cookie only on a secure connection
     * @param bool $httponly when TRUE the cookie will be made accessible only through the HTTP protocol
     */
    public function setCookie($cookiename, $value, $username, $expire = null, $path = '', $domain = '', $secure = FALSE, $httponly = null)
    {
        $expire = is_null($expire) ? time() + $this->_default_expire : $expire;
        $secureValue = $this->_secureCookieValue($value, $this->doHash($username), $expire);
        $this->setClassicCookie($cookiename, $secureValue, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Delete a cookie
     *
     * @param string $name cookie name
     * @param string $path cookie path
     * @param string $domain cookie domain
     * @param bool $secure when TRUE, send the cookie only on a secure connection
     * @param bool $httponly when TRUE the cookie will be made accessible only through the HTTP protocol
     */
    public function deleteCookie($name, $path = '/', $domain = '', $secure = FALSE, $httponly = null)
    {
        // delete cookie only once
        if (isset($this->deleted)) return; else $this->deleted = true;
        /* 1980-01-01 */
        $expire = 315554400;
        setcookie($name, '', $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Get a secure cookie value
     *
     * Verify the integrity of cookie data and decrypt it.
     * If the cookie is invalid, it can be automatically destroyed (default behaviour)
     *
     * @param string $cookiename cookie name
     * @param bool $deleteIfInvalid destroy the cookie if invalid
     */
    public function getCookieValue($cookiename, $deleteIfInvalid = true)
    {
        if ($this->cookieExists($cookiename)) {
            $cookieValues = explode('|', $_COOKIE[$cookiename]);
            if ((count($cookieValues) === 4) && ($cookieValues[1] == 0 || $cookieValues[1] >= time())) {
                $key = hash_hmac($this->_hash, $cookieValues[0].$cookieValues[1], $this->_secret);
                $cookieData = $cookieValues[2];
                if ($this->getHighConfidentiality()) {
                    $data = $this->_decrypt($cookieData, $key, md5($cookieValues[1]));
                } else {
                    $data = $cookieData;
                }
                if ($this->_ssl && isset($_SERVER['SSL_SESSION_ID'])) {
                    $verifKey = hash_hmac($this->_hash, $cookieValues[0].$cookieValues[1].$data.$_SERVER['SSL_SESSION_ID'], $key);
                } else {
                    $verifKey = hash_hmac($this->_hash, $cookieValues[0].$cookieValues[1].$data, $key);
                }
                if ($verifKey == $cookieValues[3]) {
                    return ($data);
                }
            }
        }
        if ($deleteIfInvalid) {
            $this->deleteCookie($cookiename);
        }
        return (FALSE);
    }

    /**
     * Get a classic (unsecure) cookie value
     *
     * @param string $cookiename cookie name
     * param bool $deleteIfInvalid destroy the cookie if invalid
     */
    public function getClassicCookieValue($cookiename, $deleteIfInvalid = true)
    {
        if ($this->cookieExists($cookiename)) {
            return $_COOKIE[$cookiename];
        }
        if ($deleteIfInvalid) {
            $this->deleteCookie($cookiename);
        }
        return (FALSE);
    }

    /**
     * Send a classic (unsecure) cookie
     *
     * @param string $name cookie name
     * @param string $value cookie value
     * @param integer $expire expiration time
     * @param string $path cookie path
     * @param string $domain cookie domain
     * @param bool $secure when TRUE, send the cookie only on a secure connection
     * @param bool $httponly when TRUE the cookie will be made accessible only through the HTTP protocol
     */
    public function setClassicCookie($cookiename, $value, $expire = 0, $path = '', $domain = '', $secure = FALSE, $httponly = null)
    {
        /* httponly option is only available for PHP version >= 5.2 */
        if ($httponly !== null && (!defined('PHP_VERSION_ID') || PHP_VERSION_ID >= 50200)) {
            setcookie($cookiename, $value, $expire, $path, $domain, $secure, $httponly);
        }
        else {
            setcookie($cookiename, $value, $expire, $path, $domain, $secure);
        }
    }

    /**
     * Verify if a cookie exists
     *
     * @param string $cookiename
     * @return bool TRUE if cookie exist, or FALSE if not
     */
    public function cookieExists($cookiename)
    {
        return (isset($_COOKIE[$cookiename]));
    }

    /**
     * Secure a cookie value
     *
     * The initial value is transformed with this protocol :
     *
     *  secureValue = username|expire|base64((value)k,expire)|HMAC(user|expire|value,k)
     *  where k = HMAC(user|expire, sk)
     *  and sk is server's secret key
     *  (value)k,md5(expire) is the result an cryptographic function (ex: AES256) on "value" with key k and initialisation vector = md5(expire)
     *
     * @param string $value unsecure value
     * @param string $username user name (or ID)
     * @param integer $expire expiration time
     * @return string secured value
    */

    protected function _secureCookieValue($value, $username, $expire)
    {
        $key = hash_hmac($this->_hash, $username.$expire, $this->_secret);
        if ($this->getHighConfidentiality()) {
            $encryptedValue = $this->_encrypt($value, $key, md5($expire));
        } else {
            $encryptedValue = $value;
        }
        if ($this->_ssl && isset($_SERVER['SSL_SESSION_ID'])) {
            $verifKey = hash_hmac($this->_hash, $username . $expire . $value . $_SERVER['SSL_SESSION_ID'], $key);
        } else {
            $verifKey = hash_hmac($this->_hash, $username . $expire . $value, $key);
        }
        $result = array($username, $expire, $encryptedValue, $verifKey);
        return(implode('|', $result));
    }

    /**
     * Encrypt a given data with a given key and a given initialisation vector
     *
     * @param string $data data to crypt
     * @param string $key secret key
     * @param string $iv initialisation vector
     * @return string encrypted data
     */
    protected function _encrypt($data, $key, $iv)
    {
        /* If PHP version >= 5.3.3 */
        if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID >= 50303) {
            $res = openssl_encrypt($data, $this->_algorithm, $key, FALSE, $this->_iv);
        }
        else {
            $res = openssl_encrypt($data, $this->_algorithm, $key, FALSE);
        }
        return $res;
    }

    /**
     * Decrypt a given data with a given key and a given initialisation vector
     *
     * @param string $data data to crypt
     * @param string $key secret key
     * @param string $iv initialisation vector
     * @return string encrypted data
     */
    protected function _decrypt($data, $key, $iv)
    {
        /* If PHP version >= 5.3.3 */
        if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID >= 50303) {
            $res = openssl_decrypt($data, $this->_algorithm, $key, FALSE, $this->_iv);
        }
        else {
            $res = openssl_decrypt($data, $this->_algorithm, $key, FALSE);
        }
        return $res;
    }
}
