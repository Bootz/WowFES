<?php
class table_helpers extends base_helpers {
    public function simple($data = array(), $config = array()) {
        if (count($data) === 0) {
            return;
        }

        echo '<table';
        if (array_key_exists('border', $config)) {
            echo ' border="' . $config['border'] . '"';
        }
        else {
            echo ' border="1"';
        }
        if (array_key_exists('summary', $config)) {
            echo ' summary="' . $config['summary'] . '"';
        }
        echo ">\n";
        echo "  <thead>\n";
        foreach (array_keys($data[0]) as $item) {
            echo "    <td><b>$item<b></td>\n";
        }
        echo "  </thead>\n";
        foreach ($data as $row) {
            echo "  <tr>\n";
            foreach ($row as $item) {
                echo '    <td>';
                if ($item === '') {
                    echo "&nbsp;";
                }
                else {
                    echo $item;
                }
                echo "</td>\n";
            }
            echo "  </tr>\n";
        }
        echo "</table>\n";
    }
}
?>
