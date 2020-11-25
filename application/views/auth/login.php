<div id="notifikasi"><?php echo $this->session->flashdata('msg'); ?></div>
<form class="login100-form validate-form" id="sign_in" method="POST" autocomplete="off" action="<?php echo base_url(); ?>auth/login">
  <p>
    <input type="text" autofocus name="username" placeholder="Username" class="input email" required />
  </p>
  <p>
    <input name="password" placeholder="Password" placeholder="Password" class="input email" type="password" required />
  </p>
  <p>
    <input type="submit" name="submit" class="input submit" value="Sign Me In">
  </p>
</form>