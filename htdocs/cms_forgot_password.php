<?php include 'cms_header.inc.php'; ?>

<h1>Email Password Reminder</h1>

<p>Forgot your password? Just enter your email address, and we’ll email you a new one!</p>

<form method="post" action="cms_transact_user.php">
  <div>
    <label for="email">Email Address:</label>
    <input type="text" id="email" name="email" maxlength="100" />
    <input type="submit" name="action" value="Send my reminder!" />
  </div>
</form>

<?php include 'cms_footer.inc.php'; ?>
