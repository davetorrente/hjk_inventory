<?php
$page_title = 'Edit category';
require_once('../includes/load.php');
//Display all catgories.
$categorie = find_by_id('categories',(int)$_GET['id']);
if(!$categorie){
  $session->msg("d","Missing categorie id.");
  redirect('/admin/category/');
}

if(isset($_POST['edit_cat'])){
    $req_field = array('categorie-name');
    validate_fields($req_field);
    $cat_name = remove_junk(($_POST['categorie-name']));
    if(empty($errors)){
      $database->query("SELECT name FROM categories WHERE name='{$cat_name}'");
      $db_categ = $database->resultset();
      if(empty($db_categ))
      {
        $sql = "UPDATE categories SET name='{$cat_name}'";
        $sql .= " WHERE id='{$categorie['id']}'";
        $database->query($sql);
        $database->execute();
        if($database->rowCount() === 1) {
            log_history('Category '.$categorie['name'].' has been updated to '.$cat_name);
            $session->msg("s", "Successfully updated Category");
            redirect('/admin/category/',false);
        } else {
            $session->msg("d", "Sorry! Failed to Update");
           redirect('/admin/edit_category/?id='.$categorie['id'], false);
        }
      }else{
        if($db_categ[0]['name'] == $categorie['name']){
          $session->msg("i", 'Same Category Name');
          redirect('/admin/edit_category/?id='.$categorie['id'], false);
        }else{
          $session->msg("d", 'Category Name already exists');
          redirect('/admin/edit_category/?id='.$categorie['id'], false);
        }
      }
    }else{
    $session->msg("d", $errors);
    redirect('/admin/edit_category/?id='.$categorie['id'], false);
  }
}
include_once('../layouts/header.php');
?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="fa fa-cube"></i>
          <span>Edit Category Name </span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="/admin/edit_category/?id=<?php echo (int)$categorie['id'];?>">
          <div class="form-group">
            <input type="text" class="form-control" name="categorie-name" value="<?php echo remove_junk(ucfirst($categorie['name']));?>">
          </div>
            <button type="submit" name="edit_cat" class="btn btn-primary">Update category</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('../layouts/footer.php'); ?>
