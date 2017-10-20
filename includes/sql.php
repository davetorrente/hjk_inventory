<?php
  require_once(LIB_PATH_INC.DS."load.php");
  


/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   if(tableExists($table))
   {
    return find_by_sql("SELECT * FROM {$table}");
   }
}
function paginate($table, $limit){
  $limit = (int)$limit;
  if(tableExists($table)){
    $page = 0;
    if(isset($_GET['page']))
    {
      $page = $_GET['page'];
      if($page=='' || $page == 1)
      {
          $setPage = 0;
      }else{
          $setPage = $page*$limit -$limit;
      }
    }else{
      $setPage = 0;
    }
    $findQuery = find_by_sql("SELECT * FROM {$table} ORDER by created ASC LIMIT $setPage, {$limit}");
    $ceilPage = ceil(countData($table)/$limit);
    return array('list'=>$findQuery,'count'=>$ceilPage, 'page' =>$page);
  }
}
function countData($table){
  if(tableExists($table))
  {
   return count(find_by_sql("SELECT * FROM {$table}"));
  }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $database;
  $database->query($sql);
  $result_set = $database->resultset();
  if(empty($resultset))
    return $result_set;
  else
    return $result_set[0]; 
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $database;
  $id = (int)$id;
  if(tableExists($table)){
    $database->query("SELECT * FROM ".$table." WHERE id = $id");
    $database->execute();
    if(count($database->resultset()) > 0){
      $result = $database->resultset();
      return $result[0];
    }else
      return null;
   }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $database;
  if(tableExists($table))
  {
    $sql = "DELETE FROM ".$table;
    $sql .= " WHERE id=".$id;
    $sql .= " LIMIT 1";
    $database->query($sql);
    $database->execute();
    return (!empty($database->rowCount())) ? true : false;
  }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}

/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $database;
  $database->query("SHOW TABLES FROM ".DB_NAME." LIKE'%users%'");
  $database->execute();
  if($database->rowCount() > 0) 
    return true;
  else
    return false;
}
/*--------------------------------------------------------------*/
/* Login with the data provided in $_POST,
/* coming from the login form.
/*--------------------------------------------------------------*/
function authenticate($username='', $password='') {
  global $database;
  $username = htmlspecialchars($username);
  $password = htmlspecialchars($password);
  $database->query("SELECT id, password, username FROM users WHERE username = '$username'");
  if(count($database->resultset()) > 0){
    $user = $database->resultset();
    $password_request = sha1($password);
    if($password_request === $user[0]['password'] ){
      return $user[0]['id'];
    }
  }
  return false;
}


/*--------------------------------------------------------------*/
/* Find current log in user by session id
/*--------------------------------------------------------------*/
function current_user(){
  static $current_user;
  if(!$current_user){
     if(isset($_SESSION['user_id'])):
         $user_id = intval($_SESSION['user_id']);
         $current_user = find_by_id('users',$user_id);
    endif;
  }
  return $current_user;
}
  

function updateLastLogIn($user_id)
{
  global $database;
  $date = make_date();
  $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
  $database->query($sql);
  $database->execute();
  return ($database->rowCount() === 1 ? true : false);
}
function join_product_table($table){
  if(tableExists($table))
  {
    $page = 0;
    if(isset($_GET['page']))
    {
      $page = $_GET['page'];
      if($page=='' || $page == 1)
      {
          $setPage = 0;
      }else{
          $setPage = $page*5 -5;
      }
    }else{
      $setPage = 0;
    }
    $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.created,c.name";
    $sql  .=" AS category,m.file_name AS image";
    $sql  .=" FROM {$table} p";
    $sql  .=" LEFT JOIN categories c ON c.id = p.category_id";
    $sql  .=" LEFT JOIN medias m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC LIMIT $setPage, 5";
    $findQuery = find_by_sql($sql);
    $ceilPage = ceil(countData($table)/5);
    return array('list'=>$findQuery,'count'=>$ceilPage, 'page' =>$page);
  }
  
}
function find_all_product_info_by_title($title){
  $sql  = "SELECT * FROM products ";
  $sql .= " WHERE name ='{$title}'";
  $sql .=" LIMIT 1";
  return find_by_sql($sql);
}
function find_product_by_title($product_name){
   $p_name = remove_junk($product_name);
   $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
   $result = find_by_sql($sql);
   return $result;
 }

function checkQty($p_id){
  $id  = (int)$p_id;
  $sql = "SELECT quantity FROM products WHERE id = '{$id}'";
  $result = find_by_sql($sql);
  return $result[0]['quantity'];
}

function update_product_qty($qty,$p_id){
  global $database;
  $qty = (int) $qty;
  $id  = (int)$p_id;
  $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
  $database->query($sql);
  if($database->execute());
  {
    $database->query("SELECT name FROM products WHERE id = '{$id}'");
    $prod_name = $database->resultset();
    return($database->rowCount() === 1 ? $prod_name[0]['name'] : '');
  }
}

function find_all_sale($table){
  if(tableExists($table))
  { 
    $page = 0;
      if(isset($_GET['page']))
      {
        $page = $_GET['page'];
        if($page=='' || $page == 1)
        {
            $setPage = 0;
        }else{
            $setPage = $page*5 -5;
        }
      }else{
        $setPage = 0;
      }
      $sql  = "SELECT s.id,s.quantity,s.price,s.created,p.name";
      $sql  .=" FROM {$table} s";
      $sql .= " LEFT JOIN products p ON s.product_id = p.id";
      $sql  .=" LEFT JOIN medias m ON m.id = p.media_id";
      $sql  .=" ORDER BY s.created DESC LIMIT $setPage, 5";
      $findQuery = find_by_sql($sql);
      $ceilPage = ceil(countData($table)/5);
      return array('list'=>$findQuery,'count'=>$ceilPage, 'page' =>$page);
  }
}
function find_sale_by_dates($start_date,$end_date){
  global $database;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.created, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.quantity) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.quantity) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.quantity) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.created BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.created),p.name";
  $sql .= " ORDER BY DATE(s.created) DESC";
  return find_by_sql($sql);
}
function  monthlySales($year,$table){
  if(tableExists($table))
  {
    $page = 0;
    if(isset($_GET['page']))
    {
      $page = $_GET['page'];
      if($page=='' || $page == 1)
      {
          $setPage = 0;
      }else{
          $setPage = $page*5 -5;
      }
    }else{
      $setPage = 0;
    }
    $sql  = "SELECT s.id,";
    $sql .= " DATE_FORMAT(s.created, '%Y-%m-%e') AS date,p.name,";
    $sql .= "SUM(s.quantity) AS total_qty,";
    $sql .= "SUM(p.sale_price * s.quantity) AS total_saleing_price";
    $sql .= " FROM {$table} s";
    $sql .= " LEFT JOIN products p ON s.product_id = p.id";
    $sql .= " WHERE DATE_FORMAT(s.created, '%Y' ) = '{$year}'";
    $sql .= " GROUP BY DATE_FORMAT( s.created,  '%c' ),s.product_id";
    $sql .= " ORDER BY date_format(s.created, '%c' ) ASC LIMIT $setPage, 5";
    $findQuery = find_by_sql($sql);
    $ceilPage = ceil(count($findQuery)/5);
    return array('list'=>$findQuery,'count'=>$ceilPage, 'page' =>$page);
  }
}
function  dailySales($year,$month,$table){
  if(tableExists($table))
  {
    $page = 0;
    if(isset($_GET['page']))
    {
      $page = $_GET['page'];
      if($page=='' || $page == 1)
      {
          $setPage = 0;
      }else{
          $setPage = $page*5 -5;
      }
    }else{
      $setPage = 0;
    }
    $sql  = "SELECT s.id,";
    $sql .= " DATE_FORMAT(s.created, '%Y-%m-%e') AS created,p.name,";
    $sql .= "SUM(s.quantity) AS total_qty,";
    $sql .= "SUM(p.sale_price * s.quantity) AS total_saleing_price";
    $sql .= " FROM {$table} s";
    $sql .= " LEFT JOIN products p ON s.product_id = p.id";
    $sql .= " WHERE DATE_FORMAT(s.created, '%Y-%m' ) = '{$year}-{$month}'";
    $sql .= " GROUP BY DATE_FORMAT( s.created,  '%e' ),s.product_id";
    $sql .= " ORDER BY date_format(s.created, '%c' ) ASC LIMIT $setPage, 5";
    $findQuery = find_by_sql($sql);
    $ceilPage = ceil(count($findQuery)/5);
    return array('list'=>$findQuery,'count'=>$ceilPage, 'page' =>$page);
  }
}

function find_high_sell_product($limit){
  $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.quantity) AS totalQty";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
  $sql .= " GROUP BY s.product_id";
  $sql .= " ORDER BY totalSold DESC LIMIT ".(int)$limit;
  return find_by_sql($sql);
}

function find_recent_prod($limit){
  $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS category,";
  $sql  .= "m.file_name AS image FROM products p";
  $sql  .= " LEFT JOIN categories c ON c.id = p.category_id";
  $sql  .= " LEFT JOIN medias m ON m.id = p.media_id";
  $sql  .= " ORDER BY p.id DESC LIMIT ".(int)$limit;
  return find_by_sql($sql);
}
function find_high_sale($limit){
  $sql  = "SELECT s.id,s.quantity,s.price,s.created,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.price DESC LIMIT ".(int)$limit;
  return find_by_sql($sql);
}

 /*--------------------------------------------------------------*/
/* Insert to Logs table
/*--------------------------------------------------------------*/
function log_history($name){
  global $database;
  $database->query("INSERT INTO logs (name) VALUES (:log)");
  $database->bind(':log',$name);
  $database->execute();
}

?>
