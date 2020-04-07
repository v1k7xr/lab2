<? session_start(); ?>
<!DOCTYPE html>
    <html>
        <head>
            <title>
                Dropnik
            </title>
        </head>
        <body>
        <?php if (isset($_SESSION['userid']) && isset($_SESSION['username'])): ?>
            <? require_once("../static/htmltemp/isUser.php"); ?>
        <?php else: ?>
            <? require_once("../static/htmltemp/isGuest.php"); ?>
        <?php endif; ?>
