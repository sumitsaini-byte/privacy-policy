<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
 
<?php require('inc/links.php'); ?>
<title><?php echo $settings_r['site_title'] ?>-PRODUCTS</title>


</head>
<body class="bg-light">
   
    <?php 
    require('inc/header.php'); 
    
    $rentin_default="";
    $rentout_default="";


    if(isset($_GET['rent_availability']))
    {
    $frm_data = filteration($_GET);

    $rentin_default = $frm_data['rentin'];
    $rentout_default = $frm_data['rentout'];

    }
    ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">OUR PRODUCTS</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">

                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">Filters</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropDown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropDown">
                         <!-- rent availability --> 
                         <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                <span>RENT AVAILABILITY</span>
                                <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                <label class="form-label">Rent-in</label>
                                <input type="date" class="form-control shadow-none mb-3" value="<?php echo $rentin_default ?>" id="rentin" onchange="chk_avail_filter()">
                                <label class="form-label">Rent-out</label>
                                <input type="date" class="form-control shadow-none" value="<?php echo $rentout_default ?>" id="rentout" onchange="chk_avail_filter()">
                            </div>

                            <!-- Facilities --> 
                            <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>FACILITIES</span>
                                    <button id="facilities_btn" onclick="facilities_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                <?php 
                                
                                    $facilities_q = selectAll('facilities');
                                    while($row = mysqli_fetch_assoc($facilities_q))
                                    {
                                        echo<<<facilities
                                            <div class="mb-2">
                                                <input type="checkbox" onclick="fetch_products()" name="facilities" value="$row[id]" class="form-check-input shadow-none me-1" id="$row[id]" >
                                                <label class="form-check-label" for="$row[id]">$row[name]</label>
                                            </div>
                                        facilities;
                                    }

                                ?>                                                          

                           
                        </div>       
                    </div>
                </nav>

            </div>


            <div class="col-lg-9 col-md-12 px-4" id="products-data">  
                

    <script>

    let products_data = document.getElementById('products-data');

    let rentin = document.getElementById('rentin');
    let rentout = document.getElementById('rentout');
    let chk_avail_btn = document.getElementById('chk_avail_btn');


    let facilities_btn = document.getElementById('facilities_btn');

    
    function fetch_products()
    {
        let chk_avail = JSON.stringify({
            rentin: rentin.value,
            rentout: rentout.value
        });

      

        let facility_list = {"facilities":[]};

        let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
        if(get_facilities.length>0)
        {
            get_facilities.forEach((facility)=>{
                facility_list.facilities.push(facility.value);
            });
            facilities_btn.classList.remove('d-none');
        }
        else{
            facilities_btn.classList.add('d-none');
        }
        facility_list = JSON.stringify(facility_list);

        let xhr = new XMLHttpRequest();
        xhr.open("GET","ajax/products.php?fetch_products&chk_avail="+chk_avail+"&facility_list="+facility_list,true);

        xhr.onprogress = function(){
          products_data.innerHTML = `<div class="spinner-border text-info mb-3 d-block mx-auto" id="loader" role="status">
                  <span class="visually-hidden">Loading.....</span>   
                </div>`;
        }

        xhr.onload = function(){
          products_data.innerHTML = this.responseText;
        }

        xhr.send();
    }

    function chk_avail_filter(){
        if(rentin.value!='' && rentout.value !=''){
            fetch_products();
            chk_avail_btn.classList.remove('d-none');
        }
    }

    function chk_avail_clear(){
        rentin.value='';
        rentout.value='';
        chk_avail_btn.classList.add('d-none');
        fetch_products();               
    }


    function facilities_clear(){
        let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
        get_facilities.forEach((facility)=>{
                facility.checked=false;
            });
            facilities_btn.classList.add('d-none');
        fetch_products();
    }
   
    window.onload = function(){

        fetch_products();
    }

    </script>

<?php require('inc/footer.php'); ?>

</body>
</html>