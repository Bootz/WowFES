<?php
/**
 * Wow Secure Filter
 *
 * Compatible with PHP 5.2+
 * Ref:
 *     http://www.php.net/manual/en/filter.filters.validate.php
 *     http://www.php.net/manual/en/filter.filters.sanitize.php
 *
 * @author yftzeng <yftzeng@gmail.com>
 * @copyright Copyright (c) 2011 Yi-Feng Tzeng
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://antbsd.twbbs.org/
 * @package org.twbbs.antbsd.wowsecmodules
 */

/**
 * WowSecFilter class
 * @package org.twbbs.antbsd.wowsecmodules
 */
class WowSecFilter {

    /**
     * Database Drive
     *
     * MySQL ->      'mysql'
     * PostgreSQL -> 'pgsql'
     *
     * @var string
     */
    static private $DB_DRIVE = 'mysql';

    /**
     * Strip unvalidated string of array
     * For version before PHP 5.2
     *
     * "\0" including array("\x00", "\x0a", "\x0d", "\x1a)
     *                array('\0',   '\n',   '\r',   '\Z')
     *
     * @var array
     */
    static private $extra_strip_array = array("\0", "%0a", "%0A", "%0d", "%0D", "%00", "%1d", "%1D");

    /**
     * Safe check variable
     * @return bool
     */
    public static function check($input) {
        if (empty($input) && $input != '0') {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Clean general danergous variable
     */
    public static function cleanDefault() {
        if (PHP_VERSION >= 5.2) {
            $_SERVER['PHP_SELF'] = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            if (isset($_SERVER['HTTP_REFERER'])) {
                $_SERVER['HTTP_REFERER'] = filter_var($_SERVER['HTTP_REFERER'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            }
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $_SERVER['HTTP_USER_AGENT'] = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            }
        }
        else {
            $_SERVER['PHP_SELF'] = htmlentities(str_replace(self::$extra_strip_array, "", strip_tags($_SERVER['PHP_SELF'])));
            if (isset($_SERVER['HTTP_REFERER'])) {
                $_SERVER['HTTP_REFERER'] = htmlentities(str_replace(self::$extra_strip_array, "", strip_tags($_SERVER['HTTP_REFERER'])));
            }
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $_SERVER['HTTP_USER_AGENT'] = htmlentities(str_replace(self::$extra_strip_array, "", strip_tags($_SERVER['HTTP_USER_AGENT'])));
            }
        }
    }

    /**
     * Clean value for safety
     * This method only support array filter
     *
     * @param string $input Value for filtering
     * @param array $filters Filtering options
     * @param string $key Filtering key in $filters
     * @return mixed
     */
    public static function clean($input, $filters = array(), $key = null) {
        if (is_array($input)) {
            foreach($input as $key => $value) {
                $input[$key] = self::clean($value, $filters, $key);
            }
        }
        else if ($key === null) {
            // If $input is not array()
            return FALSE;
        }
        else {
            if (PHP_VERSION >= 5.2) {
                $input = self::filter_var_wrapper($input, $filters, $key);
            }
            else {
                $input = trim(htmlentities(str_replace(self::$extra_strip_array, "", strip_tags($input))));
            }
        }
        return $input;
    }
    /**
     * Clean value by type
     *
     * @param string $input Value for filtering
     * @param array $filters Filtering options
     * @param string $key Filtering key in $filters
     * @return mixed
     */
    private static function filter_var_wrapper($input, $filters, $key) {
        if (array_key_exists($key, $filters)) {
            switch ($filters[$key]) {
            case 'string':
                return filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            case 'utf8-string':
                return filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            case 'boolean':
                return filter_var($input, FILTER_VALIDATE_BOOLEAN);
            case 'int':
                // This may got another security issue,
                //      For example, a string will map to a int, and may this int is not validate.
                // If you think it is not a issue, you can uncomment next line.
                //$input = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
                //
                return filter_var($input, FILTER_VALIDATE_INT);
            case 'float':
                return filter_var($input, FILTER_VALIDATE_FLOAT);
            case 'url':
                return filter_var($input, FILTER_SANITIZE_URL);
            case 'ip':
            case 'ipv4':
                return filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
            case 'ipv6':
                return filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
            case 'email':
                return filter_var($input, FILTER_VALIDATE_EMAIL);
            case 'html':
                return filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            case 'utf8-html':
                return filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
            case 'mysql_date':
                $input = trim($input);
                if (preg_match("/^(\d{2})-(\d{2})-(\d{4})$/", $input, $matches)) {
                    if (checkdate($matches[2], $matches[1], $matches[3])) {
                        return $matches[3] . "-" . $matches[2] . "-" . $matches[1] . " 00:00:00";
                    }
                }
                return FALSE;
            case 'phone': // Telephone, p is for USA
                $length = strlen($input);
                for ($i=0; $i<$length; $i++) {
                    if (!((is_numeric($input[$i])) || ($input[$i] === '+') || ($input[$i] === '*') || ($input[$i] === 'p') || ($input[$i] === '#') || ($input[$i] === '-'))) {
                        return FALSE;
                    }
                }
                return $input;
            case 'pin':
                if ((strlen($input) != 13) || (!is_numeric($input))) {
                    return FALSE;
                }
                return $input;
            default:
                if (is_array($filters[$key])) {
                    if ($filters[$key][0] === 'int' && array_key_exists("options", $filters[$key])) {
                        if (filter_var($input, FILTER_VALIDATE_INT)) {
                            if (array_key_exists("min_range", $filters[$key]["options"])) {
                                if ($input < $filters[$key]["options"]["min_range"]) {
                                    return FALSE;
                                }
                            }
                            if (array_key_exists("max_range", $filters[$key]["options"])) {
                                if ($input > $filters[$key]["options"]["max_range"]) {
                                    return FALSE;
                                }
                            }
                            return $input;
                        }
                        else {
                            return FALSE;
                        }
                    }
                    else if ($filters[$key][0] === 'float' && array_key_exists("options", $filters[$key])) {
                        if (filter_var($input, FILTER_VALIDATE_FLOAT)) {
                            if (array_key_exists("min_range", $filters[$key]["options"])) {
                                if ($input < $filters[$key]["options"]["min_range"]) {
                                    return FALSE;
                                }
                            }
                            if (array_key_exists("max_range", $filters[$key]["options"])) {
                                if ($input > $filters[$key]["options"]["max_range"]) {
                                    return FALSE;
                                }
                            }
                            return $input;
                        }
                        else {
                            return FALSE;
                        }
                    }
                    else if ($filters[$key][0] === 'string' && array_key_exists("options", $filters[$key])) {
                        if (array_key_exists("min_range", $filters[$key]["options"])) {
                            if (strlen($input) < $filters[$key]["options"]["min_range"]) {
                                return FALSE;
                            }
                        }
                        if (array_key_exists("max_range", $filters[$key]["options"])) {
                            if (strlen($input) > $filters[$key]["options"]["max_range"]) {
                                return FALSE;
                            }
                        }
                        return filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
                    }
                    else if ($filters[$key][0] === 'utf8-string' && array_key_exists("options", $filters[$key])) {
                        if (array_key_exists("min_range", $filters[$key]["options"])) {
                            if (strlen(utf8_decode($input)) < $filters[$key]["options"]["min_range"]) {
                                return FALSE;
                            }
                        }
                        if (array_key_exists("max_range", $filters[$key]["options"])) {
                            if (strlen(utf8_decode($input)) > $filters[$key]["options"]["max_range"]) {
                                return FALSE;
                            }
                        }
                        return filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
                    }
                    else if ($filters[$key][0] === 'url' && array_key_exists("options", $filters[$key])) {
                        if (array_key_exists("min_range", $filters[$key]["options"])) {
                            if (strlen($input) < $filters[$key]["options"]["min_range"]) {
                                return FALSE;
                            }
                        }
                        if (array_key_exists("max_range", $filters[$key]["options"])) {
                            if (strlen($input) > $filters[$key]["options"]["max_range"]) {
                                return FALSE;
                            }
                        }
                        return filter_var($input, FILTER_SANITIZE_URL);
                    }
                    else if ($filters[$key][0] === 'email' && array_key_exists("options", $filters[$key])) {
                        if (array_key_exists("min_range", $filters[$key]["options"])) {
                            if (strlen($input) < $filters[$key]["options"]["min_range"]) {
                                return FALSE;
                            }
                        }
                        if (array_key_exists("max_range", $filters[$key]["options"])) {
                            if (strlen($input) > $filters[$key]["options"]["max_range"]) {
                                return FALSE;
                            }
                        }
                        return filter_var($input, FILTER_VALIDATE_EMAIL);
                    }
                    else if ($filters[$key][0] === 'phone' && array_key_exists("options", $filters[$key])) {
                        if (array_key_exists("min_range", $filters[$key]["options"])) {
                            if (strlen($input) < $filters[$key]["options"]["min_range"]) {
                                return FALSE;
                            }
                        }
                        if (array_key_exists("max_range", $filters[$key]["options"])) {
                            if (strlen($input) > $filters[$key]["options"]["max_range"]) {
                                return FALSE;
                            }
                        }
                        $length = strlen($input);
                        for ($i=0; $i<$length; $i++) {
                            if (!((is_numeric($input[$i])) || ($input[$i] === '+') || ($input[$i] === '*') || ($input[$i] === 'p') || ($input[$i] === '#') || ($input[$i] === '-'))) {
                                return FALSE;
                            }
                        }
                        return $input;
                    }
                }
                return filter_var($input, FILTER_SANITIZE_STRING);
            }
        }
        else {
            return filter_var($input, FILTER_SANITIZE_STRING);
        }
    }

    /**
     * Clean SQL for safety
     *
     * @param string $sql
     * @return string
     */
    public static function cleanSQL($sql) {
        // filter_var is more fast than trim/htmlentities/strip_tags
        if (PHP_VERSION >= 5.2) {
            $sql = filter_var($sql, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
        }
        else {
            $sql = trim(htmlentities(strip_tags($sql), ENT_QUOTES, 'UTF-8'));

            if (get_magic_quotes_gpc())
                $sql = stripslashes($sql);
        }

        if (self::$DB_DRIVE === 'mysql') {
            $sql = mysql_real_escape_string($sql);
        }
        else if (self::$DB_DRIVE === 'pgsql') {
            $sql = pg_escape_string($sql);
        }

        return $sql;
    }

    /**
     * Deep Clean SQL for safety
     * - This can filter second order / mutiple order SQL injection
     *
     * @param string $sql
     * @return string
     */
    public static function deepcleanSQL($sql) {
        //$sql = urldecode($sql);
        $replace = '　';
        $pattern = array(
                         "/(^SELECT....*)(FROM[ |\/])/i",
                         "/([ |\/|(]SELECT....*)(FROM[ |\/])/i",
                         "/(^CREATE..*)(TABLE[ |\/])/i",
                         "/([ |\/]CREATE..*)(TABLE[ |\/])/i",
                         "/(^CREATE..*)(DATABASE[ |\/])/i",
                         "/([ |\/]CREATE..*)(DATABASE[ |\/])/i",
                         "/(^CREATE..*)(INDEX[ |\/])/i",
                         "/([ |\/]CREATE..*)(INDEX[ |\/])/i",
                         "/(^CREATE..*)(VIEW[ |\/])/i",
                         "/([ |\/]CREATE..*)(VIEW[ |\/])/i",
                         "/(^DELETE..*)(FROM[ |\/])/i",
                         "/([ |\/]DELETE..*)(FROM[ |\/])/i",
                         "/(^DROP..*)(FROM[ |\/])/i",
                         "/([ |\/]DROP..*)(FROM[ |\/])/i",
                         "/(^UNION..*)(SELECT[ |\/])/i",
                         "/([ |\/|(]UNION..*)(SELECT[ |\/])/i",
                        );
        if (self::$DB_DRIVE === 'mysql') {
            // Ref: http://dev.mysql.com/doc/refman/5.1/en/information-functions.html
            // [N|O][DR] = AND/OR
            array_push($pattern,
                                "/([N|O][DR].*)(BENCHMARK\([0-9].*)/i",
                                "/([N|O][DR].*)(VERSION\(\).*[>|<|=])/i"
                      );
        }
        else if (self::$DB_DRIVE === 'mssql') {
            array_push($pattern,
                                "/(^UNION..*)(ALL[ |\/])/i",
                                "/([ |\/|(]UNION..*)(ALL[ |\/])/i"
                      );

        }

        $count = count($pattern);
        for ($i = 0; $i < $count; $i++) {
            if (preg_match($pattern[$i], $sql)) {
                $sql = preg_replace($pattern[$i], '${1}' . $replace . '${2}', $sql);
            }
        }
        return $sql;
    }

    /**
     * Deep stripslashes
     * @return array
     */
    public static function stripslashes_deep(&$input) {
        return is_array($input) ? array_map('self::stripslashes_deep', $input) : stripslashes($input);
    }

    /**
     * Deep clean
     * @return array
     */
    public static function clean_deep(&$input) {
        return is_array($input) ? array_map('self::clean_deep', $input) : filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    }
}
?>
