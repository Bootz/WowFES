<?php
class search_model {
    public function search($name) {
        if ($this->recipe_is_exist($name)) {
            //$table = "recipe";
            //$data = array(
                            //'name' => "%$name%",
                    //);
            //return WowPDOManager::select($table, '*', $data);

            return ORM::for_table('recipe')
                ->where_like('name', "%$name%")->find_many();
        }
    }

    public function recipe_is_exist($name) {
        //$table = "recipe";
        //$data = array(
                        //'name'        => "%$name%",
        //);
        //if (count(WowPDOManager::select($table, '*', $data)) > 0) {
            //return TRUE;
        //}
        //return FALSE;

        $count = ORM::for_table('recipe')
            ->where_like('name', "%$name%")->count();

        if ($count > 0) {
            return TRUE;
        }
        return FALSE;
    }
}
?>
