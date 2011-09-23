<div id="recipe_content">
    <div id="recipe">
        <div id="image">
<?php
if ($result !== '食譜不存在' ) {
//echo '<img src="' . $result[0]['image'] . '">';
echo '<img src="' . $result->image . '">';
?>
        </div>
        <div id="intro">
            <div id="title">
                <img src="/img/vendor/recipeName.jpg">料理名稱:
            </div>
            <div id="summary">
<?php
//echo $result[0]['name'];
echo $result->name;
?>
            </div>
        </div>
        <div id="chef">
            <div id="title">
                <img src="/img/vendor/chef.jpg">料理主廚:
            </div>
            <div id="summary">
<?php
//echo $result[0]['createdBy'];
echo $result->createdBy;
?>
            </div>
        </div>
        <div id="material">
            <div id="title">
                <img src="/img/vendor/material.jpg">材料:
            </div>
            <div id="summary">
<?php
//$items = explode(';', $result[0]['ingredient']);
$items = explode(';', $result->ingredient);
for($j=0; $j<count($items)-1; $j++) {
    $item = explode(':', $items[$j]);
    echo "<p>" . $item[0] . "：" . $item[1] . $item[2] . "</p>\n";
}
?>
            </div>
        </div>
        <div id="step">
            <div id="title">
                <img src="/img/vendor/step.jpg">料理步驟:
            </div>
            <div id="item">
<?php
//$items = explode(';', $result[0]['step']);
$items = explode(';', $result->step);
echo "<ol>";
for($j=0; $j<count($items)-1; $j++) {
    echo "<li>" . $items[$j] . "</li>";
}
echo "</ol>";
?>
            </div>
        </div>
        <div id="tips">
            <div id="title">
                <img src="/img/vendor/tips.jpg">料理提示:
            </div>
            <div id="tip">
<?php
//$tips = $result[0]['tips'];
$tips = $result->tips;
if ($tips === '') {
    echo '無';
}
else {
    echo $tips;
}
?>
            </div>
        </div>
        <div id="extra">
            <div id="title">
                <img src="/img/vendor/extra.jpg">補充資料:
            </div>
            <div id="item">
<?php
//$extra = $result[0]['extra'];
$extra = $result->extra;
if ($extra === '') {
    echo '無';
}
else {
    echo $extra;
}
?>
            </div>
<?php
}
else {
    echo $result;
}
?>
        </div>
    </div>
    <div id="clear"></div>
</div>
