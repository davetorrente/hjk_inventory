<?php 
$page_title = 'All Medias';
require_once('../includes/load.php');
include_once('../layouts/header.php');
$media_files = paginate('medias',5);
  if(isset($_POST['submit'])) {
   if (empty($_FILES["file_upload"]['name'])) {
        $session->msg('d', 'Image is required');
        redirect('media.php');
    }else{
      $file = $_FILES['file_upload'];
      $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
      $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
      if(in_array($ext, $arr_ext))
      {
        $database->query("SELECT file_name FROM medias WHERE file_name='{$file['name']}'");
        $media_photo = $database->resultset();
        if(empty($media_photo)){
          $moveFile = $file['name'];
          move_uploaded_file($file['tmp_name'], '../assets/images/products/'.$moveFile);
          chmod('../assets/images/products/'.$moveFile, 0666);
          $created = make_date(); 
          $database->query("INSERT INTO medias (file_name,file_type,created) VALUES('{$moveFile}','{$ext}','{$created}')");
          if($database->execute()){
            log_history("You've added ".$moveFile.' to media');
            $session->msg("s", "Successfully Added Media");
            redirect('media.php',false);
          }
        }else{
          $session->msg("d", "Media Photo already exists");
          redirect('media.php',false);
        }
      }
    }
  } 
?>
 <div class="row">
    <div class="col-md-6">
      <?php echo display_msg($msg); ?>
    </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-camera"></span>
        <span>All Photos</span>
        <div class="pull-right">
          <form class="form-inline" action="media.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-btn">
                  <input type="file" name="file_upload" multiple="multiple" class="btn btn-primary btn-file"/>
                 </span>
                 <button type="submit" name="submit" class="btn btn-default">Upload</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr id="media-col">
              <th class="text-center">#</th>
              <th class="text-center">Photo</th>
              <th class="text-center">Photo Name</th>
              <th class="text-center">Photo Type</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>  
          <tbody>
          <?php if(!empty($media_files['list'])): ?>
            <?php foreach ($media_files['list'] as $media_file): ?>
              <tr class="list-inline">
               <td class="text-center"><?php echo $media_file['id'];?></td>
                <td class="text-center">
                    <img src="../assets/images/products/<?php echo $media_file['file_name'];?>" class="img-thumbnail" />
                </td>
              <td class="text-center">
                <?php echo $media_file['file_name'];?>
              </td>
              <td class="text-center">
                <?php echo $media_file['file_type'];?>
              </td>
              <td class="text-center">
                <a href="delete_media.php?id=<?php echo (int) $media_file['id'];?>" class="btn btn-danger btn-xs"  title="Edit">
                  <span class="glyphicon glyphicon-trash"></span>
                </a>
              </td>
             </tr>
            <?php endforeach;?>
          <?php endif; ?>  
          </tbody>
        </table>
      </div>
      <?php if(!empty($media_files['list'])): ?>
        <div class="panel-footer">
          <div class="row">
            <div class="col col-xs-4">Page  <?php echo $media_files['page']==0 ? 1 : $media_files['page'] ; ?> of <?php echo $media_files['count']; ?></div>
            <div class="col col-xs-8">
                <ul class="pagination hidden-xs pull-right">   
                  <?php for($i=1; $i<=$media_files['count']; $i++): ?>
                      <li><a href="media.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                  <?php endfor ?>
                </ul>
                <ul class="pagination visible-xs pull-right">
                    <li><a href="#">«</a></li>
                    <li><a href="#">»</a></li>
                </ul>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>


<?php include_once('../layouts/footer.php'); ?>
