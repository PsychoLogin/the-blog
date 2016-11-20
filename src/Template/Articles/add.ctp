<h1>Add Article</h1>
<?php echo $this->Form->create($article); ?>
<fieldset>
    <?= $this->Form->input('title') ?>
    <?= $this->Form->input('body', array( 'onkeydown' => "javascript:{
      var metadata = document.getElementsByName('keyboard_metadata')[0];
      if (!metadata.value) {
        metadata.value = '';
      } else {
        metadata.value += ',';
      }
      var c = String.fromCharCode(event.keyCode)
      metadata.value += new Date().getTime() + c;
    }" )) ?>
    <?= $this->Form->hidden('keyboard_metadata') ?>
</fieldset>
<?php
echo $this->Form->button(__('Save Article'));
echo $this->Form->end();
?>