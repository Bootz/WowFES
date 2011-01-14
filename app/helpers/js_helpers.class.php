<?php
class js_helpers extends base_helpers {
    public function javascript_tag($url, $config = array()) {
        if (strpos($url, '/vendor/') === 0) {
            $url = __site . '/' . $url;
        }
        else if (!strstr($url, '//')) {
            $url = __site . '/js/' . $url;
        }

        if (!(array_key_exists('cache', $config) && $config['cache'] == TRUE)) {
            $url .= '?' . parent::anticache();
        }

        echo "<script type=\"text/javascript\" src=\"" . $url . "\"></script>\n";
    }
}
?>
