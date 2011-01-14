<?php
class img_helpers extends base_helpers {
    public function img_tag($url, $config = array()) {
        if (!strstr($url, '//')) {
            $url = __site . '/img/' . $url;
        }

        if (array_key_exists('cache', $config) && $config['cache'] == TRUE) {
            $new_url .= '?' . parent::anticache();
        }

        echo "<img src=\"$url\"";
        if (array_key_exists('alt', $config)) {
            echo ' alt="' . $config['alt'] . '"';
        }
        if (array_key_exists('height', $config)) {
            echo ' height="' . $config['height'] . '"';
        }
        if (array_key_exists('width', $config)) {
            echo ' width="' . $config['width'] . '"';
        }
        echo ">\n";
    }

    public function img_to($url, $link_to, $config = array()) {
        if (!strstr($url, '//')) {
            $new_url = __site . '/img/' . $url;
        }
        if (!strstr($link_to, '//')) {
            $link_to = __site . $link_to;
        }

        if (array_key_exists('cache', $config) && $config['cache'] == TRUE) {
            $new_url .= '?' . parent::anticache();
        }

        echo "<a href=\"$link_to\"";
        if (array_key_exists('target', $config) && $config['target'] == TRUE) {
            echo ' target="_blank"';
        }

        echo " style=\"background: url('" . $new_url . "'); display: block;";

        $isHeight = array_key_exists('height', $config);
        $isWidth  = array_key_exists('width', $config);

        // If not assign height or width, it will get from GD 'getimagesize'
        if (!$isHeight || !$isWidth) {
            if (function_exists('getimagesize')) {
                $img_file = __img . '/' . $url;
                if (file_exists($img_file)) {
                    list($width, $height) = getimagesize($img_file);
                }
            }
        }
        if ($isHeight) {
            echo ' height: ' . $config['height'];
            if ($config['height'][strlen($config['height'])-1] !== '%') {
                echo 'px;';
            }
        }
        else {
            echo ' height: ' . $height; 
            if ($height[strlen($height)-1] !== '%') {
                echo 'px;';
            }
        }
        if ($isWidth) {
            echo ' width: ' . $config['width'];
            if ($config['width'][strlen($config['width'])-1] !== '%') {
                echo 'px;';
            }
        }
        else {
            echo ' width: ' . $width;
            if ($width[strlen($width)-1] !== '%') {
                echo 'px;';
            }
        }

        if (array_key_exists('css', $config)) {
            echo ' ' . $config['css'] . ';';
        }
        echo "\"> </a>";
    }
}
?>
