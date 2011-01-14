<?php
class base_helpers {
    /**
     * @registry object
     */
    protected $registry = null;

    /**
     * Construct
     * @param object $registry registry object
     * @return void
     */
    function __construct($registry) {
        $this->registry = $registry;
    }

    /**
     * Output formater
     * @param string $str string for format
     * @return string
     */
    public function format($str) {
        return ucfirst(str_replace('_', ' ', $str));
    }

    /**
     * Anti url cache
     * @return string
     */
    public function anticache() {
        return $this->registry->anticache;
    }
}
?>
