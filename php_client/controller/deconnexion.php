<?php
  $auth->deconnect();
  unset($_SESSION);
  session_destroy();

  header('Location: /index.php?action=login');
?>
