<?php
  $page_title = 'Change Password';
  require_once('../includes/load.php');
  include_once('../layouts/header.php');
?>
<?php $user = current_user(); ?>
<?php
  if(isset($_POST['update'])){

    $req_fields = array('new-password','old-password','id' );
    validate_fields($req_fields);

    if(empty($errors)){
      $id = (int)$_POST['id'];
      $new = remove_junk(sha1($_POST['new-password']));
      if(sha1($_POST['old-password']) !== current_user()['password']){
        $session->msg('d', "Your old password not match");
        redirect('/admin/change_password/',false);
      }
      if($new == current_user()['password']){
        $session->msg('d', "Same password");
        redirect('/admin/change_password/',false);
      }
      $database->query("UPDATE users SET password ='{$new}' WHERE id='{$id}'");
      $database->execute();
      if($database->rowCount() === 1){  
        log_history("You've change your password!");
        $session->msg('s',"Login with your new password.");
        redirect('/admin/edit_account/', false);
      }else{
            $session->msg('d',' Sorry failed to updated!');
            redirect('/admin/change_password/', false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('/admin/change_password/',false);
    }
  }
?>
<div class="login-page">
  <div class="text-center">
     <h3>Change your password</h3>
   </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="/admin/change_password/" class="clearfix">
       <div class="form-group">
              <label for="oldPassword" class="control-label">Old password</label>
              <input type="password" class="form-control" name="old-password" placeholder="Old password">
        </div>
        <div class="form-group">
              <label for="newPassword" class="control-label">New password</label>
              <input type="password" class="form-control" name="new-password" placeholder="New password">
        </div>   
        <div class="form-group clearfix">
               <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
                <button type="submit" name="update" class="btn btn-warning">Change</button>
        </div>
      </form>
</div>
<?php include_once('../layouts/footer.php'); ?>
