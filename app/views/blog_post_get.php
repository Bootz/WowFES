<h1><?php echo $blog_heading; ?></h1>

<p><?php echo $blog_content; ?></p>

<form action="<?php echo __site; ?>/blog/item" method="post">
Blog content: <input type="text" name="content"><BR>
<input type="submit" value="Send">
</form>
