<?php
abstract class base_controller {
    /**
     * @default_layout string default layout
     */
    protected $default_layout = 'html5';

    /**
     * @registry object
     */
    protected $registry;

    /**
     * Construct
     * @param object $registry registry object
     * @return void
     */
    function __construct($registry) {
        $this->registry = $registry;
        $this->registry->view->layout = $this->default_layout;
    }

    /**
     * Default view
     */
    abstract function index();
}
?>
