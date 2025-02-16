<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
 
<?php require('inc/links.php'); ?>
<title><?php echo $settings_r['site_title'] ?> - CONFIRM BOOKING</title>


</head>
<body class="bg-light">
   
    <?php require('inc/header.php'); ?>

    <?php 
        if(!isset($_GET['id']) || $settings_r['shutdown']==true){
            redirect('products.php');
        }
        else if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
            redirect('products.php');
        }

        $data = filteration($_GET);

        $product_res = select("SELECT * FROM `products` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

        if(mysqli_num_rows($product_res)==0){
            redirect('products.php');
        }

        $product_data = mysqli_fetch_assoc($product_res);

        $_SESSION['product'] = [
            "id" => $product_data['id'],
            "name" => $product_data['name'],
            "price" => $product_data['price'],
            "payment" => null,
            "available" => false,
        ];

        $user_res = select("SELECT * FROM `user_cred` WHERE `id` = ? LIMIT 1", [$_SESSION['uId']],"i");
        $user_data = mysqli_fetch_assoc($user_res);
      
      


    ?>

    

    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">CONFIRM BOOKING</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="products.php" class="text-secondary text-decoration-none">PRODUCT</a> 
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRM</a> 
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                
                <?php

                    $product_thumb = PRODUCTS_IMG_PATH."thumbnail.jpg";
                    $thumb_q = mysqli_query($con,"SELECT * FROM `product_images` 
                      WHERE `product_id`='$product_data[id]' 
                      AND `thumb`='1'");

                    if(mysqli_num_rows($thumb_q)>0){
                      $thumb_res = mysqli_fetch_assoc($thumb_q);
                      $product_thumb = PRODUCTS_IMG_PATH.$thumb_res['image'];
                    }

                    echo<<<data
                     <div class="card p-3 shadow-sm rounded">
                      <img src="$product_thumb" class="img-fluid rounded mb-3">
                      <h5>$product_data[name]</h5>
                      <h6>₹$product_data[price] per night</h6>
                     </div> 
                    data; 

                ?>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-3 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                      <form action="pay_now.php" method="POST" id="booking_form">
                        <h6 class ="mb-3">BOOKING DETAILS</h6>
                        <div class ="row">
                         <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" type="text" value="<?php echo $user_data['name']?>" class="form-control shadow-none" required readonly>   
                         </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input name="phonenum" type="number" value="<?php echo $user_data['phonenum']?>" class="form-control shadow-none" required readonly>   
                         </div>
                         <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control shadow-none" rows="1" required readonly><?php echo $user_data['address']?></textarea>
                         </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input name="quantity_p" type="number"  class="form-control shadow-none" required>   
                         </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label">rent-in</label>
                            <input name="rentin" onchange="check_availability()" type="date" class="form-control shadow-none" required>   
                         </div>
                         <div class="col-md-6 mb-4">
                            <label class="form-label">rent-out</label>
                            <input name="rentout" onchange="check_availability()" type="date" class="form-control shadow-none" required>   
                         </div>
                         <div class="col-12">
                           <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                              <span class="visually-hidden">Loading.....</span>   
                           </div>

                           <h6 class="mb-3 text-danger" id="pay_info">Provide rent-in & rent-out date !</h6>
                           <h7 class="mb-3 text-danger" >If the there is an delay in giving back the property, you will be charged extra !</h7>
                           <button name="pay_now" type="submit" class="btn w-100 text-white custom-bg shadow-none mb-1">Pay Now</button>
                         </div>
                        </div>
                       </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>        

<?php require('inc/footer.php'); ?>
<script>
    let booking_form = document.getElementById('booking_form');
    let info_loader  = document.getElementById('info_loader');
    let pay_info = document.getElementById('pay_info');

    function check_availability()
    {
        let rentin_val = booking_form.elements['rentin'].value;
        let rentout_val = booking_form.elements['rentout'].value;
        let quantity_p = booking_form.elements['quantity_p'].value;

        booking_form.elements['pay_now'].setAttribute('disabled',true);

        if(rentin_val!='' && rentout_val!='')
        {
            pay_info.classList.add('d-none');
            pay_info.classList.replace('text-dark','text-danger');
            info_loader.classList.remove('d-none');
           
            let data = new FormData();

            data.append('check_availability','');
            data.append('rent_in',rentin_val);
            data.append('rent_out',rentout_val);
        
            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/confirm_booking.php",true);

            xhr.onload = function()
            {   
               
                     let data = JSON.parse(this.responseText);

                if(data.status=='rent_in_out_equal'){
                    pay_info.innerText = "You cannot Rent-out on the same day!";
                }
                else if(data.status == 'rent_out_earlier'){
                    pay_info.innerText = "Rent-out date is earlier than Rent-in date!";
                }
                else if(data.status == 'rent_in_earlier'){
                    pay_info.innerText = "Rent-in date is earlier than Today's date!";
                }
                else if(data.status == 'rent_out_more'){
                    pay_info.innerText = "You can't Rent-out for more than 30 days!";
                }
                
               else if(data.status == 'unavailable')
                {
                    pay_info.innerText = "product not available!";
                }
                else
                {
                    pay_info.innerHTML = "No. of Days :"+data.days+"<br>Total amount to buy : ₹"+(data.payment*quantity_p);
                    pay_info.classList.replace('text-danger','text-dark');
                    booking_form.elements['pay_now'].removeAttribute('disabled');
                    }
                pay_info.classList.remove('d-none');  
                info_loader.classList.add('d-none');      
            }
    
        
        xhr.send(data);
    }
}          
       
    
</script>    

</body>
</html>