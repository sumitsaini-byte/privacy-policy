<?php 

    require('../inc/db-config.php');
    require('../inc/essentials.php');
    adminLogin();

    if(isset($_POST['add_product']))
    {
        $features = filteration(json_decode($_POST['features']));
        $facilities = filteration(json_decode($_POST['facilities']));

        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "INSERT INTO `products` (`name`, `price`, `quantity`, `description`) VALUES (?,?,?,?)";
        $values = [$frm_data['name'],$frm_data['price'],$frm_data['quantity'],$frm_data['desc']];

        if(insert($q1,$values,'siis')){
            $flag = 1;
        }

        $product_id = mysqli_insert_id($con);

        $q2 = "INSERT INTO `product_facilities`(`product_id`, `facilities_id`) VALUES (?,?)";
        if($stmt = mysqli_prepare($con,$q2))
        {
            foreach($facilities as $f){
                mysqli_stmt_bind_param($stmt,'ii',$product_id,$f); 
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
        else{
            $flag = 0;
            die('query cannot be prepared - insert');
        }

        $q3 = "INSERT INTO `product_features`(`product_id`, `features_id`) VALUES (?,?)";
        if($stmt = mysqli_prepare($con,$q3))
        {
            foreach($features as $f){
                mysqli_stmt_bind_param($stmt,'ii',$product_id,$f); 
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
        else{
            $flag = 0;
            die('query cannot be prepared - insert');
        }

        if($flag){
            echo 1;
        }
        else{
            echo 0;
        }


    }

    if(isset($_POST['get_all_products']))
    {
        $res = select("SELECT * FROM `products` WHERE `removed`=?",[0],'i');
        $i=1;

        $data = "";

        while($row = mysqli_fetch_assoc($res))
        {
            if($row['status']==1){
                $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>active</button>";
            }
            else{
                $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>"; 
            }

           $data.="
             <tr class='align-middle'>
               <td>$i</td>
               <td>$row[name]</td>
               <td>₹$row[price]</td>
               <td>$row[quantity]</td>
               <td>$status</td>
               <td>
                 <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-product'>
                    <i class='bi bi-pencil-square'></i>
                 </button> 
                 <button type='button' onclick=\"product_images($row[id],'$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#product-images'>
                     <i class='bi bi-images'></i>
                 </button>
                 <button type='button' onclick='remove_product($row[id])' class='btn btn-danger shadow-none btn-sm'>
                     <i class='bi bi-trash'></i>
                 </button>                 
               </td>
             </tr>
           ";
           $i++;
        }

        echo $data;
    }

    if(isset($_POST['get_product']))
    {
        $frm_data = filteration($_POST);

        $res1 = select("SELECT * FROM `products` WHERE `id`=?",[$frm_data['get_product']],'i');
        $res2 = select("SELECT * FROM `product_features` WHERE `product_id`=?",[$frm_data['get_product']],'i');
        $res3 = select("SELECT * FROM `product_facilities` WHERE `product_id`=?",[$frm_data['get_product']],'i');

        $productdata = mysqli_fetch_assoc($res1);
        $features = [];
        $facilities = [];

        if(mysqli_num_rows($res2)>0)
        {
            while($row = mysqli_fetch_assoc($res2)){
                array_push($features,$row['features_id']);
            }
        }

        if(mysqli_num_rows($res3)>0)
        {
            while($row = mysqli_fetch_assoc($res3)){
                array_push($facilities,$row['facilities_id']);
            }
        }

        $data = ["productdata" => $productdata, "features" => $features, "facilities" => $facilities];

        $data = json_encode($data); 

        echo $data;



    }

    if(isset($_POST['edit_product']))
    {
        $features = filteration(json_decode($_POST['features']));
        $facilities = filteration(json_decode($_POST['facilities']));

        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "UPDATE `products` SET `name`=?,`price`=?,`quantity`=?,
           `description`=? WHERE `id`=?";
        $values = [$frm_data['name'],$frm_data['price'],$frm_data['quantity'],$frm_data['desc'],$frm_data['product_id']];

        if(update($q1,$values,'siisi')){
            $flag = 1;
        }

        $del_features = delete("DELETE FROM `product_features` WHERE `product_id`=?", [$frm_data['product_id']],'i');
        $del_facilities = delete("DELETE FROM `product_facilities` WHERE `product_id`=?", [$frm_data['product_id']],'i');

        if(!($del_facilities && $del_features)){
            $flag = 0;
        }

        $q2 = "INSERT INTO `product_facilities`(`product_id`, `facilities_id`) VALUES (?,?)";
        if($stmt = mysqli_prepare($con,$q2))
        {
            foreach($facilities as $f){
                mysqli_stmt_bind_param($stmt,'ii',$frm_data['product_id'],$f); 
                mysqli_stmt_execute($stmt);
            }
            $flag = 1;
            mysqli_stmt_close($stmt);
        }
        else{
            $flag = 0;
            die('query cannot be prepared - insert');
        }

        $q3 = "INSERT INTO `product_features`(`product_id`, `features_id`) VALUES (?,?)";
        if($stmt = mysqli_prepare($con,$q3))
        {
            foreach($features as $f){
                mysqli_stmt_bind_param($stmt,'ii',$frm_data['product_id'],$f); 
                mysqli_stmt_execute($stmt);
            }
            $flag = 1;
            mysqli_stmt_close($stmt);
        }
        else{
            $flag = 0;
            die('query cannot be prepared - insert');
        }

        if($flag){
            echo 1;
        }
        else{
            echo 0;
        }
    }

    if(isset($_POST['toggle_status']))
    {
        $frm_data = filteration($_POST);

        $q = "UPDATE `products` SET `status`=? WHERE `id`=?";
        $v = [$frm_data['value'],$frm_data['toggle_status']];

        if(update($q,$v,'ii')){
            echo 1;
        }
        else{
            echo 0;
        }
    }

    if(isset($_POST['add_image']))
    {
        $frm_data = filteration($_POST);

        $img_r = uploadImage($_FILES['image'],PRODUCTS_FOLDER);

        if($img_r == 'inv_img'){
            echo $img_r;
        }
        else if($img_r == 'inv_size'){
            echo $img_r;
        }
        else if($img_r == 'upd_failed'){
            ($img_r);
        }
        else{
            $q = "INSERT INTO `product_images`(`product_id`, `image`) VALUES (?,?)";
            $values = [$frm_data['product_id'],$img_r];
            $res = insert($q,$values,'is');
            echo $res;
        }
    }

    if(isset($_POST['get_product_images']))
    {
        $frm_data = filteration($_POST);
        $res = select("SELECT * FROM `product_images` WHERE `product_id`=?",[$frm_data['get_product_images']],'i');

        $path = PRODUCTS_IMG_PATH;

       while($row = mysqli_fetch_assoc($res))
       {
        if($row['thumb']==1){
            $thumb_btn = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
        }
        else{
            $thumb_btn = "<button onclick='thumb_image($row[sr_no],$row[product_id])' class='btn btn-secondary shadow-none'>
            <i class='bi bi-check-lg'></i>
          </button>";
        }
         echo<<<data
            <tr class='align-middle'> 
                <td><img src='$path$row[image]' class='img-fluid'></td>
                <td>$thumb_btn</td>
                <td>
                  <button onclick='rem_image($row[sr_no],$row[product_id])' class='btn btn-danger shadow-none'>
                    <i class='bi bi-trash'></i>
                  </button>
                </td>
            </tr>
         data;
       }
        
    }

    if(isset($_POST['rem_image']))
    {
        $frm_data = filteration($_POST);

        $values = [$frm_data['image_id'],$frm_data['product_id']];

        $pre_q = "SELECT * FROM `product_images` WHERE `sr_no`=? AND `product_id`=?";
        $res = select($pre_q,$values,'ii');
        $img = mysqli_fetch_assoc($res);

        if(deleteImage($img['image'],PRODUCTS_FOLDER)){
            $q  = "DELETE FROM `product_images` WHERE `sr_no`=? AND `product_id`=?";
            $res = delete($q,$values,'ii');
            echo $res;
        }
        else{
            echo 0;
        }

    }

    if(isset($_POST['thumb_image']))
    {
        $frm_data = filteration($_POST);

        $pre_q = "UPDATE `product_images` SET `thumb`=? WHERE `product_id`=?";
        $pre_v = [0,$frm_data['product_id']];
        $pre_res = update($pre_q,$pre_v,'ii');

        $q = "UPDATE `product_images` SET `thumb`=? WHERE `sr_no`=? AND `product_id`=?";
        $v = [1,$frm_data['image_id'],$frm_data['product_id']];
        $res = update($q,$v,'iii');

        echo $res;

    }

    if(isset($_POST['remove_product']))
    {
        $frm_data = filteration($_POST);
        
        $res1 = select("SELECT * FROM `product_images` WHERE `product_id`=?",[$frm_data['product_id']],'i');

        while($row = mysqli_fetch_assoc($res1)){
            deleteImage($row['image'],PRODUCTS_FOLDER);
        }

        $res2 = delete("DELETE FROM `product_images` WHERE `product_id`=?",[$frm_data['product_id']],'i');
        $res3 = delete("DELETE FROM `product_features` WHERE `product_id`=?",[$frm_data['product_id']],'i');
        $res4 = delete("DELETE FROM `product_facilities` WHERE `product_id`=?",[$frm_data['product_id']],'i');
        $res5 = delete("DELETE FROM `products` WHERE `id`=?",[$frm_data['product_id']],'i');

        if($res2 || $res3 || $res4 || $res5){
            echo 1;
        }
        else{
            echo 0;
        }

    }

?>