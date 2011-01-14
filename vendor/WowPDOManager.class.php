<?php
/**
 * Wow PDO Manager
 *
 * @author yftzeng <yftzeng@gmail.com>
 * @copyright Copyright (c) 2011 Yi-Feng Tzeng
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://antbsd.twbbs.org/
 * @package org.twbbs.antbsd.wowsecmodules
 */

/**
 * WowPDOManager class
 *
 * @package org.twbbs.antbsd.wowsecmodules
 */
class WowPDOManager {

    /**
     * PDO Driver
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     * @var string
     */
    private static $DB_DRIVER = 'mysql';

    /**
     * The host name to connect database
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     * @var string
     */
    private static $DB_HOST = 'localhost';

    /**
     * The user name for connection database
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     * @var string
     */
    private static $DB_USER = 'root';

    /**
     * The password for user to connect database
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     * @var string
     */
    private static $DB_PASSWORD = '123456';

    /**
     * The database name to connect
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     * @var string
     */
    private static $DB_DATABASE = 'demo';

    /**
     * The database socket path
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     * @var string
     */
    private static $DB_SOCKETPATH;

    /**
     * The database port to connect
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     * @var string
     */
    private static $DB_PORT = '3306';

    /**
     * The charset for database connection
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     * @var string
     */
    private static $DB_CHARSET = 'utf8';

    /**
     * The database connect persistent
     *
     * If 'DB_CONFIG' variable setting is exist. 'DB_CONFIG' is greater priority than this.
     *
     * In http://php.net/manual/en/pdo.connections.php, "recommended that you don't use persistent PDO connections"
     * If you want to close connection, please assign NULL.
     * @var bool
     */
    private static $DB_CONN_PERSISTENT = FALSE;

    /**
     * Defaut database timeout (seconds)
     * @var int
     */
    private static $DB_TIMEOUT = 15;

    /**
     * Database config file
     * @var string
     */
    private static $DB_CONFIG = 'db.ini';

    /**
     * Array of database config
     * @var array
     */
    private static $db_config_array;

    /**
     * The singleton instance
     * @var object
     */
    private static $PDOInstance;

    /**
     * PDO Fetch mode
     * @var object
     */
    private static $PDOFetchMode = PDO::FETCH_ASSOC;

    /**
     * Construct of class for setting initial config
     */
    public function __construct() {
    }

    /**
     * Creates a PDO instance to connect database
     *
     * @param array $config Database configurations
     * @return PDO
     */
    public static function getInstance($config = array()) {
        if(self::$PDOInstance === NULL) {
            $db_ini_config_file = __DIR__ . '/' . self::$DB_CONFIG;
            if (file_exists($db_ini_config_file)) {
                self::$db_config_array = parse_ini_file($db_ini_config_file);
                self::$DB_DRIVER = (isset(self::$db_config_array['DB_DRIVER']) && !empty(self::$db_config_array['DB_DRIVER'])) ? self::$db_config_array['DB_DRIVER'] : self::$DB_DRIVER;
                self::$DB_HOST = (isset(self::$db_config_array['DB_HOST']) && !empty(self::$db_config_array['DB_HOST'])) ? self::$db_config_array['DB_HOST'] : self::$DB_HOST;
                self::$DB_PORT = (isset(self::$db_config_array['DB_PORT']) && !empty(self::$db_config_array['DB_PORT'])) ? self::$db_config_array['DB_PORT'] : self::$DB_PORT;
                self::$DB_DATABASE = (isset(self::$db_config_array['DB_DATABASE']) && !empty(self::$db_config_array['DB_DATABASE'])) ? self::$db_config_array['DB_DATABASE'] : self::$DB_DATABASE;
                self::$DB_SOCKETPATH = (isset(self::$db_config_array['DB_SOCKETPATH']) && !empty(self::$db_config_array['DB_SOCKETPATH'])) ? self::$db_config_array['DB_SOCKETPATH'] : self::$DB_SOCKETPATH;
                self::$DB_USER = (isset(self::$db_config_array['DB_USER']) && !empty(self::$db_config_array['DB_USER'])) ? self::$db_config_array['DB_USER'] : self::$DB_USER;
                self::$DB_PASSWORD = (isset(self::$db_config_array['DB_PASSWORD']) && !empty(self::$db_config_array['DB_PASSWORD'])) ? self::$db_config_array['DB_PASSWORD'] : self::$DB_PASSWORD;
                self::$DB_CHARSET = (isset(self::$db_config_array['DB_CHARSET']) && !empty(self::$db_config_array['DB_CHARSET'])) ? self::$db_config_array['DB_CHARSET'] : self::$DB_CHARSET;
                self::$DB_CONN_PERSISTENT = (isset(self::$db_config_array['DB_CONN_PERSISTENT']) && !empty(self::$db_config_array['DB_CONN_PERSISTENT'])) ? self::$db_config_array['DB_CONN_PERSISTENT'] : self::$DB_CONN_PERSISTENT;
                self::$DB_TIMEOUT = (isset(self::$db_config_array['DB_TIMEOUT']) && !empty(self::$db_config_array['DB_TIMEOUT'])) ? self::$db_config_array['DB_TIMEOUT'] : self::$DB_TIMEOUT;
            }
            else if (!empty($config)) {
                if (isset($config['DB_DRIVER']))
                    self::$DB_DRIVER = $config['DB_DRIVER'];
                if (isset($config['DB_HOST']))
                    self::$DB_HOST= $config['DB_HOST'];
                if (isset($config['DB_PORT']))
                    self::$DB_PORT = $config['DB_PORT'];
                if (isset($config['DB_DATABASE']))
                    self::$DB_DATABASE = $config['DB_DATABASE'];
                if (isset($config['DB_SOCKETPATH']))
                    self::$DB_SOCKETPATH = $config['DB_SOCKETPATH'];
                if (isset($config['DB_USER']))
                    self::$DB_USER = $config['DB_USER'];
                if (isset($config['DB_PASSWORD']))
                    self::$DB_PASSWORD = $config['DB_PASSWORD'];
                if (isset($config['DB_CHARSET']))
                    self::$DB_CHARSET = $config['DB_CHARSET'];
                if (isset($config['DB_CONN_PERSISTENT']))
                    self::$DB_CONN_PERSISTENT = $config['DB_CONN_PERSISTENT'];
                if (isset($config['DB_TIMEOUT']))
                    self::$DB_TIMEOUT = $config['DB_TIMEOUT'];
            }

            try {
                if (self::$DB_DRIVER === 'mysql') {
                    // 1002 == MYSQL_ATTR_INIT_COMMAND
                    // That is because PHP bug #47224 <http://bugs.php.net/bug.php?id=47224>
                    self::$PDOInstance = new PDO("mysql:host=" . self::$DB_HOST . ";port=" . self::$DB_PORT . ";dbname=" . self::$DB_DATABASE, self::$DB_USER, self::$DB_PASSWORD,
                        array(PDO::ATTR_PERSISTENT => self::$DB_CONN_PERSISTENT,
                              PDO::ATTR_TIMEOUT => self::$DB_TIMEOUT,
                              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                              1002 => "SET NAMES '" . self::$DB_CHARSET . "'"));
                }
                else if (self::$DB_DRIVER === 'sqlsrv') {
                    self::$PDOInstance = new PDO("sqlsrv:server=" . self::$DB_HOST . ", " . self::$DB_PORT . ";database=" . self::$DB_DATABASE, self::$DB_USER, self::$DB_PASSWORD,
                        array(PDO::ATTR_PERSISTENT => self::$DB_CONN_PERSISTENT,
                              PDO::ATTR_TIMEOUT => self::$DB_TIMEOUT,
                              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                }
                else {
                    throw new Exception('Invalid DB_HOST');
                }
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                return FALSE;
            }
        }
        return self::$PDOInstance;
    }

    /**
     * Begin a transaction
     *
     * @return bool
     */
    public static function beginTransaction() {
        return self::$PDOInstance->beginTransaction();
    }

    /**
     * Commit a transaction
     *
     * @return bool
     */
    public static function commit() {
        return self::$PDOInstance->commit();
    }

    /**
     * Rollback a transaction
     *
     * @return bool
     */
    public static function rollBack() {
        return self::$PDOInstance->rollBack();
    }

    /**
     * Fetch the 'sql state' associated with the last operation on the database connection
     *
     * @return string
     */
    public static function errorCode() {
        return self::$PDOInstance->errorCode();
    }

    /**
     * Fetch extended error information associated with the last operation on the database connection
     *
     * @return array
     */
    public static function errorInfo() {
        return self::$PDOInstance->errorInfo();
    }

    /**
     * Get database config setting
     *
     * @return array
     */
    public static function getDatabaseConfig() {
        return self::$db_config_array;
    }

    /**
     * Begin a transaction
     *
     * @return bool
     */
    public static function getDatabaseDriver() {
        return self::$DB_DRIVER;
    }

    /**
     * Show an array of available PDO drivers
     *
     * @return array
     */
    public static function getAvailableDrivers() {
        return self::$PDOInstance->getAvailableDrivers();
    }

    /**
     * Retrieve a database connection attribute
     *
     * @param string $attribute Return connection attribute
     * @return array
     */
    public static function getAttribute($attribute) {
        return self::$PDOInstance->getAttribute($attribute);
    }

    /**
     * Set a database connection attribute
     *
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    public static function setAttribute($attribute, $value) {
        return self::$PDOInstance->setAttribute($attribute, $value);
    }

    /**
     * Quotes a string for use in a query
     *
     * @param string $input
     * @param int $parameter_type
     * @return string
     */
    public static function quote($input, $parameter_type=0) {
        return self::$PDOInstance->quote($input, $parameter_type);
    }

    /**
     * Prepares a statement for execution and returns a fetchAll() statement object
     *
     * @param string $sql A valid SQL for database connection
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param array $driver_options Array of key=>value pairs for sql object
     * @return PDOStatement
     */
    public static function prepareFetchAll($sql, $input_parameters=array(), $driver_options=array()) {
        $result = null;
        if ($stmt = self::$PDOInstance->prepare($sql, $driver_options)) {
            if (self::execute($stmt, $input_parameters, '1', $result)) {
                return $result;
            }
        }
    }

    /**
     * Prepares a statement for execution and returns a fetch() statement object
     *
     * @param string $sql A valid SQL for database connection
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param array $driver_options Array of key=>value pairs for sql object
     * @return PDOStatement
     */
    public static function prepareFetchFirst($sql, $input_parameters=array(), $driver_options=array()) {
        $result = null;
        if ($stmt = self::$PDOInstance->prepare($sql, $driver_options)) {
            if (self::execute($stmt, $input_parameters, '2', $result)) {
                return $result;
            }
        }
    }

    /**
     * Prepares a statement for execution and returns a rowCount() statement object
     *
     * @param string $sql A valid SQL for database connection
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param array $driver_options Array of key=>value pairs for sql object
     * @return PDOStatement
     */
    public static function prepareRowCount($sql, $input_parameters=array(), $driver_options=array()) {
        $result = null;

        /**
         * There are two rowCount methods for Microsoft SQL server.
         * Especially for SELECT, if your want to return the number of rows in a result, you must set scrollable cursor.
         * <http://msdn.microsoft.com/en-us/library/ff628154%28SQL.90%29.aspx>
         */
        if (self::$DB_DRIVER === 'sqlsrv' && strpos(strtolower(ltrim($a)), 'select') === 0) {
            $driver_options = $driver_options + array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL);
        }
        if ($stmt = self::$PDOInstance->prepare($sql, $driver_options)) {
            if (self::execute($stmt, $input_parameters, '3', $result)) {
                return $result;
            }
        }
    }

    /**
     * Executes a prepared statement for prepareFetch* API
     *
     * @param object $stmt PDOStatement object
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param string $mode Action mode
     * @param bool $result Return result
     * @return bool
     */
    private static function execute($stmt, $input_parameters, $mode, & $result = null) {
        $return = FALSE;
        if ($stmt->execute($input_parameters)) {
            if ($mode === '1') {
                if ($result = $stmt->fetchAll(self::$PDOFetchMode)) {
                    $return = TRUE;
                }
                else {
                    $return = FALSE;
                }
            }
            else if ($mode === '2') {
                if ($result = $stmt->fetch(self::$PDOFetchMode)) {
                    $return = TRUE;
                }
                else {
                    $return = FALSE;
                }
            }
            else if ($mode === '3') {
                if ($result = $stmt->rowCount()) {
                    $return = TRUE;
                }
                else {
                    $return = FALSE;
                }
            }
        }
        else {
            $return = FALSE;
        }
        return $return;
    }

    /**
     * Executes a prepared statement for SELECT/INSERT/DELETE/UPDATE
     *
     * @param string $sql A valid SQL for database connection
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param array $driver_options Array of key=>value pairs for sql object
     * @return mixed
     */
    private static function _query($sql, $input_parameters, $driver_options, $multiple_insert=FALSE) {
        $stmt = self::$PDOInstance->prepare($sql, $driver_options);
        try {
            if ($multiple_insert) {
                // transaction spped up multiple insert
                self::beginTransaction();
            }
            if ($stmt->execute($input_parameters) !== FALSE) {
                if (strpos($sql, 'SELECT') === 0) {
                    return $stmt->fetchAll(self::$PDOFetchMode);
                }
                else {
                    if ($multiple_insert) {
                        self::commit();
                    }
                    return $stmt->rowCount();
                }
            }
            if ($multiple_insert) {
                self::rollBack();
            }
            return FALSE;
        }
        catch (PDOException $e) {
            return self::errorInfo();
        }
    }

    /**
     * Executes a SQL SELECT prepared statement
     *
     * @param string $table Table name of database
     * @param string $fields Fields name of table
     * @param array $where Where conditions for sql
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param array $driver_options Array of key=>value pairs for sql object
     * @return mixed
     */
    public static function select($table, $fields='*', $where=array(), $input_parameters=array(), $driver_options=array()) {
        $sql = "SELECT $fields FROM $table";

        $bindValue = array();

        if (!empty($where)) {
            $sql .= " WHERE";
            $first_where = TRUE;
            foreach($where as $key=>$value) {
                if (is_array($value)) {
                    if ($first_where) {
                        if (strrpos($value[0], '%') === FALSE) {
                            $sql .= " $key = :where_$key";
                        }
                        else {
                            $sql .= " $key LIKE :where_$key";
                        }
                        $first_where = FALSE;
                    }
                    else {
                        if (!empty($value[1]) AND $value[1] == '1' || $value[1] === 'OR') {
                            if (strrpos($value[0], '%') === FALSE) {
                                $sql .= " OR $key = :where_$key";
                            }
                            else {
                                $sql .= " OR $key LIKE :where_$key";
                            }
                        }
                        else {
                            if (strrpos($value[0], '%') === FALSE) {
                                $sql .= " AND $key = :where_$key";
                            }
                            else {
                                $sql .= " AND $key LIKE :where_$key";
                            }
                        }
                    }
                    $bindValue[":where_$key"] = $value[0];
                }
                else {
                    if ($first_where) {
                        if (strrpos($value, '%') === FALSE) {
                            $sql .= " $key = :where_$key";
                        }
                        else {
                            $sql .= " $key LIKE :where_$key";
                        }
                        $first_where = FALSE;
                    }
                    else {
                        if ($value == '1' || $value === 'OR') {
                            if (strrpos($value, '%') === FALSE) {
                                $sql .= " OR $key = :where_$key";
                            }
                            else {
                                $sql .= " OR $key LIKE :where_$key";
                            }
                        }
                        else {
                            if (strrpos($value, '%') === FALSE) {
                                $sql .= " AND $key = :where_$key";
                            }
                            else {
                                $sql .= " AND $key LIKE :where_$key";
                            }
                        }
                    }
                    $bindValue[":where_$key"] = $value;
                }
            }
        }

        if (array_key_exists('groupby', $input_parameters)) {
            $sql .= " GROUP BY";
            foreach($input_parameters['groupby'] as $f) {
                $sql .= " $f,";
            }
            $sql = substr($sql, 0, -1);
        }
        if (array_key_exists('having', $input_parameters)) {
            $sql .= " HAVING ";
            foreach($input_parameters['having'] as $f) {
                $sql .= " $f,";
            }
            $sql = substr($sql, 0, -1);
        }
        if (array_key_exists('orderby', $input_parameters)) {
            if (is_array($input_parameters['orderby'])) {
                $sql .= " ORDER BY";
                foreach($input_parameters['orderby'] as $f) {
                    if (is_array($f)) {
                        if (empty($f[1])) {
                            $sql .= " $f[0] ASC,";
                        }
                        else {
                            $sql .= " $f[0] DESC,";
                        }
                    }
                    else {
                        $sql .= " $f ASC,";
                    }
                }
                $sql = substr($sql, 0, -1);
            }
            else {
                $sql .= " ORDER BY $input_parameters[orderby]";
            }
        }
        if (array_key_exists('limit', $input_parameters) && is_numeric($input_parameters['limit'])) {
            if (array_key_exists('offset', $input_parameters) && is_numeric($input_parameters['offset'])) {
                if (self::$DB_DRIVER === 'sqlsrv') {
                    // Ref: http://bbs.phpchina.com/thread-34537-1-1.html
                    $limit = $input_parameters['limit'];
                    $offset = $input_parameters['offset'];
                    $orderby = strstr($sql, 'ORDER BY');
                    if ($orderby !== FALSE) {
                        $sort = (strpos($orderby, 'DESC') !== FALSE) ? 'DESC' : 'ASC';
                        $order = str_replace('ORDER BY', '', $orderby);
                        $order = preg_replace('/ASC|DESC/', '', $order);
                    }
                    $sql = preg_replace('/^SELECT/', 'SELECT TOP ' . ($limit + $offset), $sql);
                    $sql = 'SELECT * FROM (SELECT TOP ' . $limit . ' * FROM (' . $sql . ') AS temp_inner_tbl';
                    if ($orderby !== FALSE) {
                        $sql .= ' ORDER BY ' . $order . ' ';
                        $sql .= (strpos($sort, 'ASC') !== FALSE) ? 'DESC' : 'ASC';
                    }
                    $sql .= ') AS temp_outer_tbl';
                    if ($orderby !== FALSE) {
                        $sql .= ' ORDER BY ' . $order . ' ' . $sort;
                    }
                }
                else {
                    $sql .= " LIMIT " . $input_parameters['limit'] . " OFFSET " . $input_parameters['offset'];
                }
            }
            else {
                // Ref: http://www.alan888.com/Discuz/thread-180792-1-2.html
                if (self::$DB_DRIVER === 'sqlsrv') {
                    $sql = preg_replace('/^SELECT/', 'SELECT TOP ' . $input_parameters['limit'], $sql);
                }
                else {
                    $sql .= " LIMIT " . $input_parameters['limit'];
                }
            }
        }

        $sql .= ';';

        return self::_query($sql, $bindValue, $driver_options);
    }

    /**
     * Executes a SQL INSERT prepared statement
     *
     * @param string $table Table name of database
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param array $driver_options Array of key=>value pairs for sql object
     * @return mixed
     */
    public static function insert($table, $input_parameters, $driver_options=array()) {
        $fields = array_keys($input_parameters);
        $bindValue = array();

        // Multiple insert for more faster, but only if the database supported
        $multiple_insert = FALSE;
        $multiple = array_values($input_parameters);
        if (is_array($multiple[0])) {
            $multiple_insert = TRUE;
            $sql = "INSERT INTO $table (" . implode($fields, ', ') . ") VALUES";
            for($i = 0; $i < count($multiple[0]); $i++) {
              $sql .= " (";
              for($j = 0; $j < count($multiple); $j++) {
                  $sql .= ":insert_" . $i . "_" . $j . "_" . $multiple[$j][$i] . ",";
                  $bindValue[":insert_" . $i . "_" . $j . "_" . $multiple[$j][$i]] = $multiple[$j][$i];
              }
              $sql = substr($sql, 0, -1);
              $sql .= "),";
            }
            $sql = substr($sql, 0, -1);
        }
        else {
            $sql = "INSERT INTO $table (" . implode($fields, ', ') . ") VALUES (:" . implode($fields, ', :') . ");";
            foreach($input_parameters as $key=>$value) {
                $bindValue[":$key"] = $value;
            }
        }
        return self::_query($sql, $bindValue, $driver_options, $multiple_insert);
    }

    /**
     * Executes a SQL DELETE prepared statement
     *
     * @param string $table Table name of database
     * @param array $where Where conditions for sql
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param array $driver_options Array of key=>value pairs for sql object
     * @return mixed
     */
    public static function delete($table, $where=array(), $input_parameters=array(), $driver_options=array()) {
        $sql = "DELETE FROM $table";

        $bindValue = array();

        if (!empty($where)) {
            $sql .= " WHERE";
            $first_where = TRUE;
            foreach($where as $key=>$value) {
                if (is_array($value)) {
                    if ($first_where) {
                        if (strrpos($value[0], '%') === FALSE) {
                            $sql .= " $key = :where_$key";
                        }
                        else {
                            $sql .= " $key LIKE :where_$key";
                        }
                        $first_where = FALSE;
                    }
                    else {
                        if (!empty($value[1]) AND $value[1] == '1' || $value[1] === 'OR') {
                            if (strrpos($value[0], '%') === FALSE) {
                                $sql .= " OR $key = :where_$key";
                            }
                            else {
                                $sql .= " OR $key LIKE :where_$key";
                            }
                        }
                        else {
                            if (strrpos($value[0], '%') === FALSE) {
                                $sql .= " AND $key = :where_$key";
                            }
                            else {
                                $sql .= " AND $key LIKE :where_$key";
                            }
                        }
                    }
                    $bindValue[":where_$key"] = $value[0];
                }
                else {
                    if ($first_where) {
                        if (strrpos($value, '%') === FALSE) {
                            $sql .= " $key = :where_$key";
                        }
                        else {
                            $sql .= " $key LIKE :where_$key";
                        }
                        $first_where = FALSE;
                    }
                    else {
                        if ($value == '1' || $value === 'OR') {
                            if (strrpos($value, '%') === FALSE) {
                                $sql .= " OR $key = :where_$key";
                            }
                            else {
                                $sql .= " OR $key LIKE :where_$key";
                            }
                        }
                        else {
                            if (strrpos($value, '%') === FALSE) {
                                $sql .= " AND $key = :where_$key";
                            }
                            else {
                                $sql .= " AND $key LIKE :where_$key";
                            }
                        }
                    }
                    $bindValue[":where_$key"] = $value;
                }
            }
        }

        return self::_query($sql, $bindValue, $driver_options);
    }

    /**
     * Executes a SQL UPDATE prepared statement
     *
     * @param string $table Table name of database
     * @param array $set Set condition for sql update
     * @param array $where Where conditions for sql
     * @param array $input_parameters Array for bind PHP variables to the parameter markers
     * @param array $driver_options Array of key=>value pairs for sql object
     * @return mixed
     */
    public static function update($table, $set, $where=array(), $input_parameters=array(), $driver_options=array()) {
        $sql = "UPDATE $table SET";

        $bindValue = array();

        if (!empty($set)) {
            foreach($set as $key=>$value) {
                $sql .=  " $key = :$key,";
                $bindValue[":$key"] = $value;
            }
            $sql = substr($sql, 0, -1);
        }

        if (!empty($where)) {
            $sql .= " WHERE";
            $first_where = TRUE;
            foreach($where as $key=>$value) {
                if (is_array($value)) {
                    if ($first_where) {
                        $sql .= " $key = :where_$key";
                        $first_where = FALSE;
                    }
                    else {
                        if (!empty($value[1]) AND $value[1] == '1' || $value[1] === 'OR') {
                            $sql .= " OR $key = :where_$key";
                        }
                        else {
                            $sql .= " AND $key = :where_$key";
                        }
                    }
                    $bindValue[":where_$key"] = $value[0];
                }
                else {
                    if ($first_where) {
                        $sql .= " $key = :where_$key";
                        $first_where = FALSE;
                    }
                    else {
                        if ($value == '1' || $value === 'OR') {
                            $sql .= " OR $key = :where_$key";
                        }
                        else {
                            $sql .= " AND $key = :where_$key";
                        }
                    }
                    $bindValue[":where_$key"] = $value;
                }
            }
        }
        return self::_query($sql, $bindValue, $driver_options);
    }

    /**
     * Execute an SQL statement and return the number of affected rows
     *
     * @param string $sql A valid SQL for database connection
     * @return int
     */
    public static function exec($sql) {
        return self::$PDOInstance->exec($sql);
    }

    /**
     * Executes an SQL statement, returning a result set as a PDOStatement object
     *
     * @param string $sql A valid SQL for database connection
     * @return PDOStatement
     */
    public static function query($sql) {
        return self::$PDOInstance->query($sql);
    }

    /**
     * Execute query and return all rows in assoc array
     *
     * @param string $sql A valid SQL for database connection
     * @return array
     */
    public static function fetchAll($sql) {
        return self::$PDOInstance->query($sql)->fetchAll(self::$PDOFetchMode);
    }

    /**
     * Execute query and return one row in assoc array
     *
     * @param string $sql A valid SQL for database connection
     * @return array
     */
    public static function fetch($sql) {
        return self::$PDOInstance->query($sql)->fetch(self::$PDOFetchMode);
    }

    /**
     * Execute query and select one column only
     *
     * @param string $sql A valid SQL for database connection
     * @return mixed
     */
    public static function fetchColumn($sql) {
        return self::$PDOInstance->query($sql)->fetchColumn();
    }

    /**
     * Returns the number of columns affected by the last SQL statement
     *
     * @param string $sql A valid SQL for database connection
     * @return int
     */
    public static function columnCount($sql) {
        return self::$PDOInstance->query($sql)->columnCount();
    }

    /**
     * Returns the number of rows affected by the last SQL statement
     *
     * @param string $sql A valid SQL for database connection
     * @return int
     */
    public static function rowCount($sql) {
        return self::$PDOInstance->query($sql)->rowCount();
    }

    /**
     * Returns the ID of the last inserted row or sequence value
     *
     * @param string $id The sequence object from which the ID should be returned
     * @return string
     */
    public static function lastInsertId($id) {
        return self::$PDOInstance->lastInsertId($id);
    }

    /**
     * Disconnect a PDO instance
     *
     * @return bool
     */
    public static function close() {
        try {
            self::$PDOInstance = null;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
?>
