<?php
  error_reporting(E_ALL|E_STRICT);

  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }

  session_destroy();

?>
