<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['username']);
            else echo "HJK Hardware";?>
    </title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/bootstrap/css/date-picker.min.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.css" />
  </head>
  <body>
  <?php  if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
      <div class="logo pull-left"> HJK HARDWARE </div>
      <div class="header-content">
      <div class="header-date pull-left">
        <strong><?php echo date("F j, Y, g:i a");?></strong>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <?php if(!empty($user['image'])): ?>
                <img src="/assets/images/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
              <?php else: ?>
                <img src="/assets/images/users/default_user.png" alt="user-image" class="img-circle img-inline">
              <?php endif; ?>  
              <span><?php echo remove_junk(ucfirst($user['username'])); ?><i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
             <li>
                 <a href="/admin/edit_account/">
                     <i class="glyphicon glyphicon-cog"></i>
                     Settings
                 </a>
             </li>
             <li class="last">
                 <a href="/auth/logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Logout
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header>
    <div class="sidebar">
      <?php include_once('admin_menu.php');?>
   </div>
<?php endif;?>   
<div class="page">
  <div class="container-fluid">
