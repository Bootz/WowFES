<?php
class registry {
    /**
     * Variable array
     */
    private $vars = array();

    /**
     * __set function
     *
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public function __set($index, $value) {
       $this->vars[$index] = $value;
    }

    /**
     * __get function
     *
     * @param mixed $index
     * @return mixed
     */
    public function __get($index) {
       return $this->vars[$index];
    }
}
?>
