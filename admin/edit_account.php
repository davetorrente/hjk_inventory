<?php
  $page_title = 'Edit Account';
  require_once('../includes/load.php');
?>
<?php
//update user image
  if(isset($_POST['change'])) {
    $user_id = $_POST['user_id'];
    if (empty($_FILES["file_upload"]['name'])) {
        $session->msg('d', 'Image is required');
        redirect('edit_account.php');
    }else{
      $file = $_FILES['file_upload'];
      $newFile = '';
      $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
      $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
      if(in_array($ext, $arr_ext))
      {
          $time = date("d-m-Y")."-".time();
          $newfileName = str_replace("'","",$file['name']);
          $moveFile = $time."-".$newfileName;
          move_uploaded_file($file['tmp_name'], '../assets/images/users/'.$moveFile);
          chmod('../assets/images/users/'.$moveFile, 0666);
      } 
      $sql = "UPDATE users SET image='{$moveFile}'";
      $sql .= " WHERE id='{$user_id}'";
      $database->query($sql);
      $database->execute();
      if($database->rowCount() === 1){
        log_history("You've change your profile photo");
        $session->msg("s", "Successfully Added User Photo");
        redirect('edit_account.php',false);
      }
    }
  }
?>
<?php
 //update user other info
  if(isset($_POST['update'])){
    $req_fields = array('username');
    validate_fields($req_fields);
    if(empty($errors)){
      $id = (int)$_SESSION['user_id'];
      $username = remove_junk($_POST['username']);
      $sql = "UPDATE users SET username ='{$username}' WHERE id='{$id}'";
      $database->query($sql);
      $database->execute();
      if($database->rowCount() === 1){
        $session->msg('s',"Acount updated ");
        redirect('edit_account.php', false);
      } else {
        $session->msg('d',' Sorry failed to updated!');
        redirect('edit_account.php', false);
      }
    }else {
      $session->msg("d", $errors);
      redirect('edit_account.php',false);
    }
  }
?>
<?php include_once('../layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span>Change My photo</span>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
            <?php if(!empty($user['image'])): ?>
                <img src="/assets/images/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-size-2">
              <?php else: ?>
                <img src="/assets/images/users/default_user.png" alt="user-image" class="img-circle img-size-2">
              <?php endif; ?>  
            </div>
            <div class="col-md-8">
              <form class="form" action="edit_account.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" name="file_upload" multiple="multiple" class="btn btn-default btn-file"/>
              </div>
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                 <button type="submit" name="change" class="btn btn-warning">Change</button>
              </div>
             </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Edit My Account</span>
      </div>
      <div class="panel-body">
          <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
            </div>
            <div class="form-group clearfix">
                    <a href="change_password.php" title="change password" class="btn btn-danger pull-right">Change Password</a>
                    <button type="submit" name="update" class="btn btn-info">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php include_once('../layouts/footer.php'); ?>
