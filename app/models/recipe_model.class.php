<?php
class recipe_model {
    public function get($id) {
        if ($this->recipe_is_exist($id)) {
            //$table = "recipe";
            //$data = array(
                            //'recipeID' => "$id",
                    //);
            //return WowPDOManager::select($table, '*', $data);

            return ORM::for_table('recipe')
                ->where_equal('recipeID',$id)->find_one();
        }
        else {
            return "食譜不存在";
        }
    }

    public function recipe_is_exist($id) {
        //$table = "recipe";
        //$data = array(
                        //'recipeID'        => $id
        //);
        //if (count(WowPDOManager::select($table, '*', $data)) > 0) {
            //return TRUE;
        //}
        //return FALSE;

        $count = ORM::for_table('recipe')
            ->where_equal('recipeID',$id)->count();

        if ($count > 0) {
            return TRUE;
        }
        return FALSE;
    }
}
?>
