<h1><?php echo $blog_heading; ?></h1>
<?php
$this->registry->form->form_for('/blog/item', array('method'=>'get', 'id'=>'form'));
$this->registry->form->label('first_name');
$this->registry->form->text_field('first_name');
$this->registry->form->label('password');
$this->registry->form->password_field('password');
$this->registry->form->check_box('option1');
$this->registry->form->check_box('option2', array('checked'=>1));
$this->registry->form->radio_button('option1');
$this->registry->form->radio_button('option2', array('checked'=>TRUE));
$this->registry->form->text_area('textarea1');
$this->registry->form->text_area('textarea2', array('value'=>'Hello', 'disabled'=>TRUE));
$this->registry->form->submit('submit');
$this->registry->form->reset('reset');
$this->registry->form->form_end();
$this->registry->url->link_to('/blog', 'Blog');
echo "<br />";
$this->registry->url->mail_to('yftzeng@gmail.com');
echo "<br />";
$this->registry->url->mail_to('yftzeng@gmail.com', array('alt'=>'Email Me'));
echo "<br />";
$this->registry->url->mail_to('yftzeng@gmail.com', array('cc'=>'yftzeng@gmail.com', 'subject'=>'Subject'));
echo "<br />";
$this->registry->url->mail_to('yftzeng@gmail.com', array('subject'=>'Subject'));
echo "<br />";
$this->registry->url->mail_to('yftzeng@gmail.com', array('cc'=>'yftzeng@gmail.com'));
echo "<br />";
$this->registry->url->mail_to('yftzeng@gmail.com', array('alt'=>'Email to me', 'cc'=>'yftzeng@gmail.com'));
?>

<div id="dialogbox-div">
    <a href="javascript:showDialog('Error','You have encountered a critical error.','error',2);">Error</a> |
    <a href="javascript:showDialog('Warning','You must enter all required information.','warning');">Warning</a> |
    <a href="javascript:showDialog('Success','Your request has been successfully received.','success');">Success</a> |
    <a href="javascript:showDialog('Confirmation','Are you sure you want to delete the entry?','prompt');">Prompt</a>
</div>

<script>
function dialogboxPrompt(ans) {
    if (ans === 1) {
        alert('yes');
    }
    else {
        alert('no');
    }
}
</script>


<?php
$item = array(
    'first_name' => array('value'=>'First name', 'em'=>TRUE),
    'last_name' => array(),
    'select1' => array('type'=>'select', 'em'=>TRUE, 'option'=>array(array('1','2'), array('a','b'))),
    'select2' => array('type'=>'select', 'option'=>array(array(array('value'=>'a','show'=>'aaa'),array('value'=>'b', 'show'=>'bbb'), array('value'=>'b','show'=>'bbb')), array(array('value'=>'1', 'show'=>'1'), array('value'=>'2','show'=>'2')))),
    'checkbox1' => array('type'=>'checkbox', 'option'=>array('foot_ball', 'socker')),
    'checkbox2' => array('type'=>'checkbox', 'option'=>array(array('value'=>'foot_ball','show'=>'Foot Ball'), array('value'=>'socker','show'=>'SockeR'))),
    'radio1' => array('type'=>'radio', 'name'=>'group', 'option'=>array('male','female')),
    'radio2' => array('type'=>'radio', 'name'=>'group', 'option'=>array(array('value'=>'male','show'=>'Male'), array('value'=>'female','show'=>'fEMALE'))),
    'textarea1' => array('type'=>'textarea', 'option'=>array('value'=>'textarea')),
    'textarea2' => array('type'=>'textarea', 'option'=>array('value'=>'textarea', 'disabled'=>TRUE)),
    'submit' => array('type'=>'submit'),
    'reset' => array('type'=>'reset'),
);
$this->registry->form->prettier_form_for('/blog/item');
$this->registry->form->prettier_fieldset('Form', $item);
$this->registry->form->prettier_form_end();
?>
