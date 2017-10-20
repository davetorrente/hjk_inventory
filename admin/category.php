<?php 
$page_title = 'All categories';
require_once('../includes/load.php');
include_once('../layouts/header.php'); 
if (!$session->isUserLoggedIn(true)) { redirect('/', false);}
$all_categories = paginate('categories',5);
if(isset($_POST['add_cat'])){
   $req_field = array('category-name');
   validate_fields($req_field);
   $cat_name = remove_junk($_POST['category-name']);
   $created = make_date(); 
    if(empty($errors)){
      $database->query("SELECT name FROM categories WHERE name='$cat_name'");
      $categ_name = $database->resultset();
      if(empty($categ_name)){
          $sql  = "INSERT INTO categories (name,created)";
          $sql .= " VALUES ('{$cat_name}','{$created}')";
          $database->query($sql);
          if($database->execute()){
              log_history('Category '.$cat_name.' has been added');
              $session->msg("s", "Successfully Added Category");
              redirect('category.php',false);
          } else {
            $session->msg("d", "Sorry Failed to add category.");
            redirect('category.php',false);
          }
      }else{
        $session->msg("d", 'Category Name already exists');
        redirect('category.php',false);
      }
    }         
}


?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="fa fa-cube"></i>
          <span>Add New Category</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="category.php">
          <div class="form-group">
              <input type="text" class="form-control" name="category-name" placeholder="Category Name">
          </div>
          <button type="submit" name="add_cat" class="btn btn-primary">Add category</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="fa fa-cubes"></i>
          <span>All Categories</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Categories</th>
              <th class="text-center" style="width: 100px;">Actions</th>
            </tr>
          </thead>
            <tbody>
              <?php if(!empty($all_categories['list'])): ?>
                <?php foreach ($all_categories['list'] as $cat):?>
                  <tr>
                      <td class="text-center"><?php echo $cat['id'];?></td>
                      <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
                      <td class="text-center">
                        <div class="btn-group">
                          <a href="edit_category.php?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                            <span class="glyphicon glyphicon-edit"></span>
                          </a>
                          <a href="delete_category.php?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                            <span class="glyphicon glyphicon-trash"></span>
                          </a>
                        </div>
                      </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>  
            </tbody>
        </table>
      </div>
      <?php if(!empty($all_categories['list'])): ?>
        <div class="panel-footer">
          <div class="row">
            <div class="col col-xs-4">Page  <?php echo $all_categories['page']==0 ? 1 : $all_categories['page'] ; ?> of <?php echo $all_categories['count']; ?></div>
            <div class="col col-xs-8">
                <ul class="pagination hidden-xs pull-right">   
                  <?php for($i=1; $i<=$all_categories['count']; $i++): ?>
                      <li><a href="category.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
  </div>
<?php include_once('../layouts/footer.php'); ?>
