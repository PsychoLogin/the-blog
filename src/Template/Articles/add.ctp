<h1>Add Article</h1>
<?php echo $this->Form->create($article); ?>
<fieldset>
    <?= $this->Form->input('title') ?>
    <?= $this->Form->input('body', array( 'onkeypress' => "javascript:{
      var metadata = document.getElementsByName('keyboard_metadata')[0];
      if (!metadata.value) {
        var content = [];
      } else {
        var content = JSON.parse(metadata.value);
      }
      content.push({ timestamp: new Date().getTime(), key: String.fromCharCode(event.keyCode) });
      metadata.value = JSON.stringify(content);
    }" )) ?>
    <?= $this->Form->hidden('keyboard_metadata') ?>
</fieldset>
<?php
echo $this->Form->button(__('Save Article'));
echo $this->Form->end();
?>