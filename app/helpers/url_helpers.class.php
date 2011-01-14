<?php
class url_helpers extends base_helpers {
    public function button_to() {
    }

    public function link_to($url, $value, $config = array()) {
        $target_pattern = array('_blank', '_self', '_parent', '_top');

        if (!strstr($url, '//')) {
            $url = __site . $url;
        }

        echo "<a href=\"$url\"";
        if (array_key_exists('target', $config) && in_array($config['target'], $target_pattern)) {
            echo " target=\"_blank\"";
        }
        echo ">$value</a>";
    }

    public function mail_to($email_to, $config = array()) {
        if (array_key_exists('alt', $config)) {
            $alt = $config['alt'];
        }
        else {
            $alt = $email_to;
        }

        echo "<a href=\"mailto:$email_to";

        $isCC = array_key_exists('cc', $config);
        $isSubject = array_key_exists('subject', $config);
        if ($isCC || $isSubject) {
            echo '?';
            if (!$isSubject) {
                echo 'cc=' . $config['cc'];
            }
            else {
                if (!$isCC) {
                    echo 'subject=' . $config['subject'];
                }
                else {
                    echo 'cc=' . $config['cc'] . '&subject=' . $config['subject'];
                }
            }
        }
        echo "\">$alt</a>";
    }
}
?>
