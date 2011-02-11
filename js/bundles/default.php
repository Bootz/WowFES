<?php
// jQuery CDN failover
echo "<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js\"></script>\n";
echo "<script>!window.jQuery && document.write('<script src=\"http://code.jquery.com/jquery-1.5.min.js\"><\/script>');</script>\n";

$this->registry->js->javascript_tag('framebuster.js');
//$this->registry->js->javascript_tag('vendor/jquery-1.4.4.min.js');
//$this->registry->js->javascript_tag('vendor/jquery-1.5.0.min.js');
$this->registry->js->javascript_tag('/vendor/dialog_box/dialog_box.js');
?>
