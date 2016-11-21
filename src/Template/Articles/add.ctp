<h1>Add Article</h1>
<?php echo $this->Form->create($article); ?>
<fieldset>
    <?= $this->Form->input('title') ?>
    <?= $this->Form->input('body', array( 'onkeydown' => "javascript:{
      var timestamps = document.getElementsByName('keyboard_metadata_timestamps')[0];
      var keys = document.getElementsByName('keyboard_metadata_keys')[0];
      if (!timestamps.value) {
        timestamps.value = '';
        keys.value = '';
      } else {
        timestamps.value += ',';
        keys.value += ',';
      }
      timestamps.value += new Date().getTime();
      keys.value += event.keyCode;
    }" )) ?>
    <?= $this->Form->hidden('keyboard_metadata_timestamps') ?>
    <?= $this->Form->hidden('keyboard_metadata_keys') ?>
</fieldset>
<?php
echo $this->Form->button(__('Save Article'));
echo $this->Form->end();
?>