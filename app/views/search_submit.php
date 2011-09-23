<div id="content">
<?php
if (count($result) === 0) {
    echo "<div class='center'>查無此食譜</div>";
}
else {
?>
    <div id="left">
        <div id="result">
<?php
for ($i=0; $i<count($result); $i++) {
?>
            <div id="items">
                <div id="leftCol">
<?php
//echo '<a href="/recipe/' . $result[$i]['recipeID'] . '"><img width="150" src="' . $result[$i]['image'] . '" title="' . $result[$i]['name'] . '"></a>';
echo '<a href="/recipe/' . $result[$i]->recipeID . '"><img width="150" src="' . $result[$i]->image . '" title="' . $result[$i]->name . '"></a>';
?>
                </div>
                <div id="rightCol">
<?php
//echo '<p id="recipeTitle"><a href="/recipe/' . $result[$i]['recipeID'] . '">' . $result[$i]['name'] . "</a></p>\n";
echo '<p id="recipeTitle"><a href="/recipe/' . $result[$i]->recipeID . '">' . $result[$i]->name . "</a></p>\n";

//$items = explode(';', $result[$i]['ingredient']);
$items = explode(';', $result[$i]->ingredient);
$show_max_ingredient = 4;
$count = min(count($items)-1, $show_max_ingredient);
for($j=0; $j<$count; $j++) {
    $item = explode(':', $items[$j]);
    if ($j===$show_max_ingredient-1) {
        echo "...(略)";
    }
    else {
        echo "<span>" . $item[0] . "：" . $item[1] . $item[2] . "</span><br/>\n";
    }
}
?>
                </div>
            </div>
<?php
}
?>
        </div>
    </div>

<!--
    <div id="right">
        <div class="box">
            <h2 style="margin-top:17px">Recent Entries</h2>
            <ul>
                <li><a href="#">Recent Entries1</a> <i>01 Des 06</i></li>
                <li><a href="#">Recent Entries2</a> <i>01 Des 06</i></li>
                <li><a href="#">Recent Entries3</a> <i>01 Des 06</i></li>
                <li><a href="#">Recent Entries4</a> <i>01 Des 06</i></li>
                <li><a href="#">Recent Entries5</a> <i>01 Des 06</i></li>
            </ul>
        </div>
    </div>
-->

<?php
}
?>
    <div id="clear"></div>
</div>
