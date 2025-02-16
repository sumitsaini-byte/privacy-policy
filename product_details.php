<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
 
<?php require('inc/links.php'); ?>
<title><?php echo $settings_r['site_title'] ?> - PRODUCT DETAILS</title>


</head>
<body class="bg-light">
   
    <?php require('inc/header.php'); ?>

    <?php 
        if(!isset($_GET['id'])){
            redirect('products.php');
        }

        $data = filteration($_GET);

        $product_res = select("SELECT * FROM `products` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

        if(mysqli_num_rows($product_res)==0){
            redirect('products.php');
        }

        $product_data = mysqli_fetch_assoc($product_res);
    ?>

    

    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold"><?php echo $product_data['name'] ?></h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="products.php" class="text-secondary text-decoration-none">PRODUCTS</a> 
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
             <div id="productCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <?php

                        $product_img = PRODUCTS_IMG_PATH."thumbnail.jpg";
                        $img_q = mysqli_query($con,"SELECT * FROM `product_images` 
                            WHERE `product_id`='$product_data[id]'");

                        if(mysqli_num_rows($img_q)>0)
                        {
                            $active_class = 'active';

                            while($img_res = mysqli_fetch_assoc($img_q))
                            {
                                echo"
                                    <div class='carousel-item $active_class'>
                                        <img src='".PRODUCTS_IMG_PATH.$img_res['image']."' class='d-block w-100 rounded'>
                                    </div>
                                ";
                                $active_class='';
                            }
                        }
                        else{
                            echo"<div class='carousel-item active'>
                                <img src='$product_img' class='d-block w-100'>
                            </div>";
                        }

                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                </div>

            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-3 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php 
                        
                            echo<<<price
                                <h4>₹$product_data[price] per night</h4> 
                            price;

                            echo<<<rating
                                <div class="mb-3">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                            rating;

                            $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f 
                                INNER JOIN `product_features` rfea ON f.id = rfea.features_id 
                                WHERE rfea.product_id = '$product_data[id]'");

                            $features_data = "";
                            while($fea_row = mysqli_fetch_assoc($fea_q)){
                                $features_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                    $fea_row[name] 
                                </span>";
                            }

                            echo<<<features
                                <div class="mb-3">
                                    <h6 class="mb-1">Features</h6>
                                    $features_data
                                </div>
                            features;

                            $fac_q = mysqli_query($con,"SELECT f.name FROM `facilities` f 
                                INNER JOIN `product_facilities` rfac ON f.id = rfac.facilities_id 
                                WHERE rfac.product_id = '$product_data[id]'");

                            $facilities_data ="";
                            while($fac_row = mysqli_fetch_assoc($fac_q)){
                                $facilities_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                    $fac_row[name] 
                                </span>";
                            }

                            echo<<<facilities
                                <div class="mb-3">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>
                            facilities;

                            echo<<<book
                                <a href="confirm_booking.php" class="btn w-100 text-white custom-bg shadow-none mb-1">Book Now</a>
                            book;


                        ?>
                    </div>
                </div>
             </div>


            <div class="col-12 mt-4 px-4"> 
                <div class="mb-4">
                    <h5>Description</h5>
                    <p>
                        <?php echo $product_data['description'] ?>
                    </p>
                </div> 

                <div>
                    <h5 class="mb-3">Reviews & Rating</h5>
                </div>
                <div class="swiper swiper-testimonials mb-4">
    <div class="swiper-wrapper mb-5">
    <?php
         $res = mysqli_query($con,"SELECT * FROM `review` ORDER BY `sr` DESC LIMIT 1");

        while($row = mysqli_fetch_assoc($res))
                {  
                echo<<<data
                  
                            <div class="swiper-slide bg-white p-4">
                                <div class="profile d-flex align-items-center mb-3">
                                <img src="images/features/wifi.jpeg" width="30px">
                                <h6 class="m-0 ms-2">$row[name] </h6> 
                                </div>
                                <p>
                                $row[message]
                                </p>
                            </div>
                            <div class="swiper-pagination"></div>
                       
                data;
                }?>
 </div>
            </div>
    </div>        

<?php require('inc/footer.php'); ?>

</body>
</html>