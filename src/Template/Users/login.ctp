<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('password', array( 'onkeydown' => "javascript:{
          var metadata = document.getElementsByName('keyboard_metadata')[0];
          if (!metadata.value) {
            metadata.value = '';
          } else {
            metadata.value += ',';
          }
          metadata.value += new Date().getTime();
        }" )) ?>
        <?= $this->Form->hidden('keyboard_metadata') ?>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>