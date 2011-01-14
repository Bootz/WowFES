<?php
class css_helpers extends base_helpers {
    public function css_tag($url, $config = array()) {
        if (strpos($url, '/vendor/') === 0) {
            $url = __site . '/' . $url;
        }
        else if (!strstr($url, '//')) {
            $url = __site . '/css/' . $url;
        }

        if (!(array_key_exists('cache', $config) && $config['cache'] == TRUE)) {
            $url .= '?' . parent::anticache();
        }

        echo "<link rel=\"stylesheet\" href=\"$url\" type=\"text/css\"";
        if (array_key_exists('media', $config)) {
            echo ' media="' . $config['media'] . '"';
        }
        echo ">\n";
    }
}
?>
