<? session_start(); ?>
<?php if (isset($_SESSION['userid']) && isset($_SESSION['username'])): ?>
    <? require_once("../static/html/isUser.php"); ?>
<?php else: ?>
    <? require_once("../static/html/isGuest.php"); ?>
<?php endif; ?>
