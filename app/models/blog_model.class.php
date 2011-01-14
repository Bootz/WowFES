<?php
class blog_model {
    public function blog_item_get($id) {

        // Database example
        //$table = "blog_items";
        //$where = array('item_id' => $id);
        //return WowPDOManager::select($table, '*', $where);

        return "Get $id blog post";
    }

    public function blog_item_post($content) {

        // Database example
        //$table = "blog_items";
        //$input = array('content' => $content);
        //return WowPDOManager::insert($table, $input);

        return $content;
    }
}
?>
