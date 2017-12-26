<!DOCTYPE html>
<?php
  require_once('../resources/core/init.php');
$pageTitle = 'Home';
  require_once(RESOURCE_DIR . '/templates/header.php');
?>
<body>
<!-- Navigation Menu Starts -->
<?php
  if (LoginCheck::isLoggedInAsAdmin() && LoginCheck::isDomain()) {
    require_once(RESOURCE_DIR . '/templates/admin_navigation.php');
  }
  elseif (LoginCheck::isLoggedIn() && LoginCheck::isDomain()) {
    require_once(RESOURCE_DIR . '/templates/navigation.php');
  }
  elseif (LoginCheck::isLocal()) {
    header('location: /localadmin.php?logout');
  }
  else {
    require_once(RESOURCE_DIR . '/templates/not_loggedin_navigation.php');
  }
?>
<!-- Navigation Menu Ends -->
<?php
  if (FlashMessage::flashIsSet('passwordSetMessage')) {
    FlashMessage::runJsScript('passwordSetMessage');
  }
  elseif (FlashMessage::flashIsSet('InvalidCodeError')) {
    FlashMessage::runJsScript('InvalidCodeError');
  }
?>

  <div class="container" id="mainContentBody">
    <div class="col-md-12">
      <form class="form-horizontal" method="post" action="index.php" name="loginform">
        <fieldset>
          <h2 class="topHeader">Password Reset Portal</h2>
          <br />
          <div class="col-md-12">
            <div class="panel-group" id="accordion">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    What would you like to do?
                  </h4>
                  <br />
                  <h4 class="panel-title">
                    If you need to reset an expired password via email choose "Reset with Email" below
                  </h4>
                </div>
                <div id="collapse4" class="panel-collapse ">
                  <div class="panel-body">
                    <br />
                    <p style="font-weight:normal">
                      This system does NOT reset your Google Mail account. You must contact <a href="mailto:jmcintyre@parchment.com">jmcintyre@parchment.com</a> to have that password reset.
                    </p>
                    <br />
                    This system allows you to reset your Active Directory/VPN password via email or secret questions.
                    <ul>
                      <li>To reset a forgotten password simply click on the "Reset with Email" option below and you will get a one time reset link in your email.</li>
                      <li>If you would like to set your secret questions, click on the "Set Questions" button and then log in with your Active Directory/VPN account. Your password cannot be reset via this method until your secret questions are set.</li>
                      <li>You may also simply change your password by entering your current password and your new password. To do so, simply click on "Change Password".</li>
                    </ul>
                    <p style="font-weight:normal" class="indexHeader">
                      Please select an option below:
                    </p>
                    <p class="indexOptions">
<?php
if (LoginCheck::isLoggedInAsAdmin()) {
  echo '<a data-toggle="tooltip" data-title="This function is disabled because you are an administrator" class="btn btn-primary disabled">Set Questions</a><br />';
}
else {
  echo '<a href="account.php" class="btn btn-primary">Set Questions</a><br />';
}
if (isset($isEmailResetEnabled) && $isEmailResetEnabled == 'true') {
  echo '<a href="resetpwemail.php" class="btn btn-primary">Reset with Email</a><br />';
}
else {
  echo '<a data-toggle="tooltip" data-title="This function is disabled by your administrator." class="btn btn-primary disabled">Reset with Email</a><br />';
}
}
?>
                      <a href="changepw.php" class="btn btn-primary">Change Password</a><br />
<?php
if (LoginCheck::isLoggedIn()) {
  echo '<a data-toggle="tooltip" data-title="This function is disabled while you are logged in" class="btn btn-primary disabled">Reset with Email</a><br />';
  echo '<a data-toggle="tooltip" data-title="This function is disabled while you are logged in" class="btn btn-primary disabled">Reset with Questions</a><br />';
}
else {
  echo '<a href="resetpw.php" class="btn btn-primary">Reset with Questions</a><br />';

  $systemSettings = new SystemSettings;
  $isEmailResetEnabled = $systemSettings->getOtherSetting('emailresetenabled');
  if (isset($isEmailResetEnabled) && $isEmailResetEnabled == 'true') {
    echo '<a href="resetpwemail.php" class="btn btn-primary">Reset with Email</a><br />';
  }
  else {
    echo '<a data-toggle="tooltip" data-title="This function is disabled by your administrator." class="btn btn-primary disabled">Reset with Email</a><br />';
  }
}
?>
                    </p>
                    <br />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
<!-- Content Ends -->
</body>
</html>
