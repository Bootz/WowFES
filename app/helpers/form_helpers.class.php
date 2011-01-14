<?php
class form_helpers extends base_helpers {
    public function form_for($action, $config = array()) {
        $action = __site . $action;

        echo "<from action=\"$action\"";
        if (array_key_exists('method', $config)) {
            echo ' method="' . $config['method'] . '"';
        }
        else {
            // Default method is POST
            echo ' method="post"';
        }

        if (array_key_exists('name', $config)) {
            echo ' name="' . $config['name'] . '"';
        }
        if (array_key_exists('id', $config)) {
            echo ' id="' . $config['id'] . '"';
        }
        if (array_key_exists('class', $config)) {
            echo ' class="' . $config['class'] . '"';
        }
        if (array_key_exists('style', $config)) {
            echo ' style="' . $config['class'] . '"';
        }
        echo ">\n";
        echo "  <div style=\"margin:0;padding:0;display:inline\">\n";
        echo "    <input name=\"authenticity_token\" type=\"hidden\" value=\"NrOp5bsjoLRuK8IW5+dQEYjKGUJDe7TQoZVvq95Wteg=\" />\n";
        echo "  </div>\n";
    }

    public function label($name) {
        echo "  <label for=\"$name\">" . parent::format($name) . "</label>:\n";
    }

    public function text_field($name, $size = 30) {
        echo "  <input id=\"$name\" name=\"$name\" size=\"$size\" type=\"text\" /><br />\n";
    }

    public function password_field($name, $size = 30) {
        echo "  <input id=\"$name\" name=\"$name\" size=\"$size\" type=\"password\" /><br />\n";
    }

    public function check_box($text, $config = array()) {
        $new_text = parent::format($text);

        echo "  <input type=\"checkbox\"";

        if (array_key_exists('name', $config)) {
            echo ' name="' . $config['name'] . '"';
        }
        else {
            echo ' name="' . $text . '"';
        }
        if (array_key_exists('id', $config)) {
            echo ' id="' . $config['id'] . '"';
        }
        if (array_key_exists('class', $config)) {
            echo ' class="' . $config['class'] . '"';
        }

        if (array_key_exists('checked', $config) && $config['checked'] == TRUE) {
            echo ' checked';
        }
        echo " />$new_text<br />\n";
    }

    public function radio_button($text, $config = array()) {
        $new_text = parent::format($text);

        echo "  <input type=\"radio\"";

        if (array_key_exists('name', $config)) {
            echo ' name="' . $config['name'] . '"';
        }
        else {
            echo ' name="radio_group"';
        }
        if (array_key_exists('value', $config)) {
            echo ' value="' . $config['value'] . '"';
        }
        else {
            echo ' value="' . $text . '"';
        }
        if (array_key_exists('id', $config)) {
            echo ' id="' . $config['id'] . '"';
        }
        if (array_key_exists('class', $config)) {
            echo ' class="' . $config['class'] . '"';
        }

        if (array_key_exists('checked', $config) && $config['checked'] == TRUE) {
            echo ' checked';
        }
        echo " />$new_text<br />\n";
    }

    public function text_area($name, $config = array()) {
        echo "  <textarea name=\"$name\"";
        if (array_key_exists('cols', $config)) {
            echo ' cols="' . $config['cols'];
        }
        else {
            echo ' cols="60"';
        }
        if (array_key_exists('rows', $config)) {
            echo ' rows="' . $config['rows'];
        }
        else {
            echo ' rows="10"';
        }
        if (array_key_exists('id', $config)) {
            echo ' id="' . $config['id'] . '"';
        }
        if (array_key_exists('class', $config)) {
            echo ' class="' . $config['class'] . '"';
        }
        if (array_key_exists('disabled', $config)) {
            echo ' disabled="disabled"';
        }

        echo ' />';

        if (array_key_exists('value', $config)) {
            echo $config['value'];
        }

        echo "</textarea><br />\n";
    }

    public function submit($name, $value = null) {
        $value = is_null($value) ? parent::format($name) : parent::format($value);
        echo "  <input id=\"$name\" name=\"$name\" value=\"$value\" type=\"submit\" />\n";
    }

    public function reset($name, $value = null) {
        $value = is_null($value) ? parent::format($name) : parent::format($value);
        echo "  <input id=\"$name\" name=\"$name\" value=\"$value\" type=\"reset\" />\n";
    }

    public function form_end() {
        echo "</form>\n";
    }

    // *************
    // Prettier form
    // *************

    public function prettier_form_for($action, $config = array()) {
        $action = __site . $action;

        echo "<form action=\"$action\"";
        if (array_key_exists('method', $config)) {
            echo ' method="' . $config['method'] . '"';
        }
        else {
            // Default method is POST
            echo ' method="post"';
        }
        echo ' class="cmxform" style="';
        if (array_key_exists('style', $config)) {
            echo $config['style'];
        }
        echo 'font-size: 72.5%;"';

        echo ">\n";
        echo "  <div style=\"margin:0;padding:0;display:inline\">\n";
        echo "    <input name=\"authenticity_token\" type=\"hidden\" value=\"NrOp5bsjoLRuK8IW5+dQEYjKGUJDe7TQoZVvq95Wteg=\" />\n";
        echo "  </div>\n";

        if (array_key_exists('title', $config)) {
            echo $config['title'];
            echo "  <p id=\"table-p\">" . $config['title'] . " <em>*</em></p>\n";
        }
        else {
            echo "  <p id=\"table-p\">Please complete the form below. Mandatory fields marked <em>*</em></p>\n";
        }
    }

    public function prettier_fieldset($text = '', $config = array()) {
        echo "  <fieldset>\n";
        echo "    <legend>$text<legend>\n";
        if (count($config) > 0) {
            echo "      <ol>\n";
            foreach($config as $key => $value) {
                $type = array_key_exists('type', $value);
                if ($type) {
                    if ($value['type'] === 'select' && array_key_exists('option', $value)) {
                        if (isset($value['em']) && $value['em'] !== FALSE) {
                            $this->prettier_select_field($key, $value['option'], $value['em']);
                        }
                        else {
                            $this->prettier_select_field($key, $value['option'], FALSE);
                        }
                    }
                    else if ($value['type'] === 'checkbox' && array_key_exists('option', $value)) {
                        if (isset($value['em']) && $value['em'] !== FALSE) {
                            $this->prettier_check_box($key, $value['option'], $value['em']);
                        }
                        else {
                            $this->prettier_check_box($key, $value['option'], FALSE);
                        }
                    }
                    else if ($value['type'] === 'radio' && isset($value['name'])) {
                        if (isset($value['em']) && $value['em'] !== FALSE) {
                            $this->prettier_radio_button($key, $value['name'], $value['option'], $value['em']);
                        }
                        else {
                            $this->prettier_radio_button($key, $value['name'], $value['option'], FALSE);
                        }
                    }
                    else if ($value['type'] === 'textarea') {
                        if (isset($value['em']) && $value['em'] !== FALSE) {
                            $this->prettier_text_area($key, $value['option'], $value['em']);
                        }
                        else {
                            $this->prettier_text_area($key, $value['option'], FALSE);
                        }
                    }
                    else if ($value['type'] === 'submit') {
                        $value = isset($value['value']) ? $value['value'] : $key;
                        $this->prettier_submit($key, $value);
                    }
                    else if ($value['type'] === 'reset') {
                        $value = isset($value['value']) ? $value['value'] : $key;
                        $this->prettier_reset($key, $value);
                    }
                    else {
                        $this->prettier_text_field($key, $value);
                    }
                }
                else {
                    $this->prettier_text_field($key, $value);
                }
            }
            echo "      </ol>\n";
        }
        echo "  </fieldset>\n";
    }

    public function prettier_text_field($name, $config = array()) {
        echo "        <li><label for=\"$name\">";
        if (array_key_exists('value', $config)) {
            echo $config['value'];
        }
        else {
            echo parent::format($name);
        }
        if (array_key_exists('em', $config)) {
            echo ' <em>*</em>';
        }
        echo "</label><input id=\"$name\" name=\"$name\" /></li>\n";
    }

    public function prettier_password_field($name, $config = array()) {
        echo "        <li><label for=\"$name\">";
        if (array_key_exists('value', $config)) {
            echo $config['value'];
        }
        else {
            echo parent::format($name);
        }
        if (array_key_exists('em', $config)) {
            echo ' <em>*</em>';
        }
        echo "</label><input id=\"$name\" name=\"$name\" type=\"password\" /></li>\n";
    }

    public function prettier_select_field($name, $config = array(), $em = FALSE) {
        echo "        <li>\n";

        $item = 1;
        foreach($config as $config_key => $config_value) {
            if ($item === 1) {
                echo '          <label>' . parent::format($name) . '<span id="sr"></span>';
            }
            else {
                echo '          <label id="sr">';
            }
            $item++;
            if ($item === 1 && $em) {
                echo ' <em>*</em>';
            }
            echo "</label>\n";
            echo "          <select id=\"$config_key\" name=\"$config_key\">\n";
            if (is_array($config_value) && is_array($config_value[0])) {
                foreach($config_value as $k => $v) {
                    $show = $v['show'];
                    for ($i = 0; $i < count($show); $i++) {
                        echo '            <option value="' . $v['value'] . '">' . $show . "</option>\n";
                    }
                }
            }
            else {
                for ($i = 0; $i < count($config_value); $i++) {
                    echo '            <option value="' . $config_value[$i] . '">' . parent::format($config_value[$i]) . "</option>\n";
                }
            }
            echo "          </select>\n";
        }
        echo "        </li>\n";
    }

    public function prettier_check_box($name, $config = array(), $em = FALSE) {
        echo "        <li>\n";
        echo "          <fieldset>\n";
        echo '            <legend>' . parent::format($name);
        if ($em) {
            echo ' <em>*</em>';
        }
        echo "</legend>\n";

        foreach($config as $k => $v) {
            if (is_array($v) && array_key_exists('value', $v) && array_key_exists('show', $v)) {
                $value = $v['value'];
                $show = $v['show'];
                for ($i = 0; $i < count($value); $i++) {
                    echo "              <label for=\"$value\"><input id=\"$value\" name=\"$value\" type=\"checkbox\" />$show";
                }
            }
            else {
                echo "              <label for=\"$v\"><input id=\"$v\" name=\"$v\" type=\"checkbox\" />" . parent::format($v);
            }
            echo "</label>\n";
        }

        echo "          </fieldset>\n";
        echo "        </li>\n";
    }

    public function prettier_radio_button($text, $name, $config = array(), $em = FALSE) {
        echo "        <li>\n";
        echo "          <fieldset>\n";
        echo '            <legend>' . parent::format($text);
        if ($em) {
            echo ' <em>*</em>';
        }
        echo "</label>\n";

        foreach($config as $k => $v) {
            echo '            <label><input type="radio" name="' . $name . '" value="';
            if (is_array($v) && array_key_exists('value', $v) && array_key_exists('show', $v)) {
                $value = $v['value'];
                for ($i = 0; $i < count($value); $i++) {
                    echo $value . '" />' . parent::format($v['show']);
                }
            }
            else {
                echo $v . '" />' . parent::format($v);
            }
            echo "</label>\n";
        }

        echo "          </fieldset>\n";
        echo "        </li>\n";
    }

    public function prettier_text_area($name, $config = array(), $em = FALSE) {
        echo "        <li><label for=\"$name\">" . parent::format($name);
        if ($em) {
            echo ' <em>*</em>';
        }
        echo "</label><textarea id=\"$name\" name=\"$name\"";
        if (array_key_exists('cols', $config)) {
            echo ' cols="' . $config['cols'];
        }
        else {
            echo ' cols="25"';
        }
        if (array_key_exists('rows', $config)) {
            echo ' rows="' . $config['rows'];
        }
        else {
            echo ' rows="7"';
        }
        if (array_key_exists('disabled', $config)) {
            echo ' disabled="disabled"';
        }

        echo ' />';

        if (array_key_exists('value', $config)) {
            echo $config['value'];
        }

        echo "</textarea></li>\n";
    }

    public function prettier_submit($name, $value = null) {
        $value = is_null($value) ? parent::format($name) : parent::format($value);
        echo "  <input value=\"$value\" type=\"submit\" />\n";
    }

    public function prettier_reset($name, $value = null) {
        $value = is_null($value) ? parent::format($name) : parent::format($value);
        echo "  <input value=\"$value\" type=\"reset\" />\n";
    }

    public function prettier_form_end() {
        echo "</form>\n";
    }
}
?>
