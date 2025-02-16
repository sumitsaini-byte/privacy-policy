<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
<style>
    .box{
        border-top-color: var(--teal) !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<?php require('inc/links.php'); ?>
<title><?php echo $settings_r['site_title'] ?> - ABOUT</title>

</head>
<body class="bg-light">
   
    <?php require('inc/header.php'); ?>
    
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
        Welcome to Sadguru Tent Furniture House, your trusted partner for high-quality furniture and décor rentals for weddings, events, and special occasions. We specialize in providing elegant sofas, chairs, tables, carpets, and more to make your event unforgettable. Whether you're planning a wedding, corporate gathering, or private celebration, our extensive inventory offers a range of styles to suit any theme.

With years of experience and a commitment to excellence, we ensure every rental item is meticulously maintained and delivered on time to create the perfect atmosphere for your guests. At Sadguru Tent Furniture House, we believe in making your dream event a reality with premium service and stylish solutions tailored to your needs.
        </p>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Owner</h3>
                <p>
                Founded by Balram Saini, our business is built on a passion for creating memorable events and a commitment to exceptional service. With years of experience in providing premium furniture rentals for weddings and special events, Balram Saini has dedicated his life to helping people bring their dream gatherings to life. From elegant sofa chairs to exquisite decor, each piece in our collection is chosen with care, ensuring style, comfort, and quality for every occasion.

At Sadguru Tent Furniture House, we believe that every event deserves the perfect setting, and we’re here to help make that happen. Our team is dedicated to making your experience seamless and enjoyable, from the initial consultation to the final setup. Let us bring warmth, style, and elegance to your special day.
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-lg-1 order-md-1 order-1">
                <img src="images/about/owner/IMG_23017.jpg" class="w-100">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-mg-6 mb-4 px-4">
                <div class="bg-white rounded shadow text-center p-4 border-top border-4 box">
                    <img src="images/about/hotel.svg" width="70px">
                    <h4 class="mt-3">20+ Products</h4>
                </div>
            </div>
            <div class="col-lg-3 col-mg-6 mb-4 px-4">
                <div class="bg-white rounded shadow text-center p-4 border-top border-4 box">
                    <img src="images/about/customers.svg" width="70px">
                    <h4 class="mt-3">200+ Customer</h4>
                </div>
            </div>
            <div class="col-lg-3 col-mg-6 mb-4 px-4">
                <div class="bg-white rounded shadow text-center p-4 border-top border-4 box">
                    <img src="images/about/rating.svg" width="70px">
                    <h4 class="mt-3">150+ Reviews</h4>
                </div>
            </div>
            <div class="col-lg-3 col-mg-6 mb-4 px-4">
                <div class="bg-white rounded shadow text-center p-4 border-top border-4 box">
                    <img src="images/about/staff.svg" width="70px">
                    <h4 class="mt-3">30+ Staff</h4>
                </div>
            </div>
        </div>

    </div>

    <h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>
    <div class="container px-4">
        <div class="swiper mySwiper ">
            <div class="swiper-wrapper mb-5">
                <?php
                // $about_q = "SELECT * FROM `team_details`";
                $about_r = selectAll('team_details');
                $path =ABOUT_IMG_PATH;
                while($row = mysqli_fetch_assoc($about_r)) {
                    echo <<<data
                    <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="$path$row[picture]" class ="w-100">
                    <h5 class="mt-2">$row[name]</h5>
                  </div>
                  data;
                 }
                ?> 
            </div>
            <div class="swiper-pagination"></div>
          </div>
    </div>
    <?php require('inc/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 40,
            pagination: {
            
            el: ".swiper-pagination",
            dynamicBullets: true,
          },
          breakpoints: {
              320: {
                  slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
      </script>
</body>
</html>