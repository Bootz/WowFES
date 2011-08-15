<?php
class view {
    /**
     * Registry object
     */
    private $registry;

    /**
     * vars array
     */
    private $vars = array();

    /**
     * Construct
     * @param object $registry registry object
     * @return void
     *
     */
    function __construct($registry) {
        $this->registry = $registry;
    }

    /**
     * __set function
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }

    /**
     * Get view
     * @param string $name name of view
     * @param string $title title of webpage
     * @return void
     */
    function show($name, $title = '') {
        $views_root = __web . '/app/views/';
        $request_file_prefix = $views_root . $name;
        $request_file_header = $views_root . '_header/' . $name . '.php';
        $request_file = $views_root . $name . '.php';
        $request_file_footer = $views_root . '_footer/' . $name . '.php';

        if (file_exists($request_file) === FALSE) {
            throw new Exception('View not found in '. $request_file);
            return FALSE;
        }

        if (array_key_exists('layout', $this->vars)) {
            $header = $views_root . '_layouts/' . $this->vars['layout'] . '/header.php';
            if (file_exists($header)) {
                include_once($header);
            }
        }

        // Load variables
        foreach ($this->vars as $key => $value) {
            // multiple language (i18n)
            $i18n_file = $views_root . '_i18n/' . $this->registry->lang . "/$name.php";
            if (file_exists($i18n_file)) {
                include_once($i18n_file);
                if (array_key_exists($value, $i18n)) {
                    $$key = $i18n[$value];
                }
                else {
                    $$key = $value;
                }
            }
            else {
                $$key = $value;
            }
        }

        if (file_exists($request_file_header) === TRUE) {
            include($request_file_header);
        }
        include_once($request_file);

        if (array_key_exists('layout', $this->vars)) {
            $footer = $views_root . '_layouts/' . $this->vars['layout'] . '/footer.php';
            if (file_exists($footer)) {
                include_once($footer);
            }
        }
        if (file_exists($request_file_footer) === TRUE) {
            include($request_file_footer);
        }
    }
}
?>
