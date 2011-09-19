<?php
class js_helpers extends base_helpers {
    public function javascript_tag($url, $config = array()) {
        $site = '';
        if ((array_key_exists('secure', $config) && $config['secure'] == TRUE)) {
            $site = 'https://' . __fqdn;
        }

        if (strpos($url, '/vendor/') === 0) {
            $url = $site . __site . $url;
        }
        else {
            $url = $site . __site . '/js/' . $url;
        }

        if (!(array_key_exists('cache', $config) && $config['cache'] == TRUE)) {
            $url .= '?' . parent::anticache();
        }

        echo "<script type=\"text/javascript\" src=\"" . $url . "\"></script>\n";
    }
}
?>
