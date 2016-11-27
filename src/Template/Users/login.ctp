<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('password', array( 'onkeydown' => "javascript:{
          var metadata = document.getElementsByName('keyboard_metadata')[0];
          if (!metadata.value) {
            var sdu = [];
          } else {
            var sdu = JSON.parse(metadata.value);
          }
          sdu.push(new Date().getTime());
          metadata.value = JSON.stringify(sdu);
        }" )) ?>
        <?= $this->Form->hidden('keyboard_metadata') ?>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>