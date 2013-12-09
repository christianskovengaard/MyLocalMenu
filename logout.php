<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    setcookie('sec_session_id', '', time()-3600,'/', '', 0, 0);
?>
