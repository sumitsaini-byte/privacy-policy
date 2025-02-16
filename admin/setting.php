<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

require('inc/db-config.php');
require('inc/essentials.php');
adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL - Setting</title>
    <?php require('inc/links.php'); ?>
</head>
  
<body class="bg-light">

<?php require('inc/header.php')?>
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden" id="main-content">
        <h3 class="md-4">SETTINGS</h3>
          
        <!-- General Setting Section -->

        <div class="card border-0 shadow-sm mb-4" >
              <div class="card-body">
                    <div class="d-flex allign-item-center justify-content-between mb-3">
                        <h5 class="card-title m-8"> General Setting</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#genera-s">
                        <i class="bi bi-pencil-square">edit</i>
                        </button>
                    </div>
                <h6 class="card-subtitle mb-1 fm-bold">Site Title</h6>
                <p class="card-text"id="site_title"></p>
                <h6 class="card-subtitle mb-1 fm-bold">About Us</h6>
                <p class="card-text"id="site_about"></p>
              </div>
        </div>

        <!-- General Setting Modal  -->

        <div class="modal fade" id="genera-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="general_s_form">
             <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" >General Setting</h5>
                </div>
             <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Site Title</label>
                    <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none" required>
                </div>  

              <div class="mb-3">
                <label class="form-label fw-bold">About Us</label>
                <textarea name="site_about" id="site_about_inp"class="form-control shadow-none" rows="6" required></textarea>
            </div>

            </div>
            <div class="modal-footer">
                <button type="button" onclick="site_title.value = general_data.site_title, site_about.value = general_data.site_about" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCLE</button>
                <button type="submit" class="btn btn custom-bg text-white shadow-none">SUBMIT</button>
            </div>
         </div>
          </form>
   
          </div>
        </div>

        <!--ShutDown Section -->

        <div class="card sborder-0 shadow-sm mb-4" >
              <div class="card-body">
                    <div class="d-flex allign-item-center justify-content-between mb-3">
                        <h5 class="card-title m-8"> Shutdown Website</h5>
                        <div class="form-check form-switch">
                          <form>
                          <input onchange="upd_shutdown(this.values)" class="form-check-input" type="checkbox" id="shutdown-toggle">
                          </form>
                      </div>
                    </div>
                    <p class="card-text">
                     No Customers Will Be Allowed To Book products, When Shutdown mode is on.
                  </p>
              </div>
        </div>
        <!-- CONTACT DETAILS SECTION -->

        <div class="card border-0 shadow-sm mb-4" >
              <div class="card-body">
                    <div class="d-flex allign-item-center justify-content-between mb-3">
                        <h5 class="card-title m-8"> Contact Setting</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contacts-s">
                        <i class="bi bi-pencil-square">Edit</i>
                        </button>
                </div>
                  <div class="row">
                    <div class="col lg-6">
                      <div class="mb-4">
                        <h6 class="card-subtitle mb-1 fm-bold">Address</h6>
                        <p class="card-text" id="address"></p>
                      </div>
                      <div class="mb-4">
                        <h6 class="card-subtitle mb-1 fm-bold">Google Maps</h6>
                        <p class="card-text" id="gmap"></p>
                      </div>
                      <div class="mb-4">
                        <h6 class="card-subtitle mb-1 fm-bold">Phone Numbers</h6>
                        <p class="card-text mb-1">
                          <i class="bi bi-telephone"></i>
                          <span id="pn1"></span>
                        </p>
                        <p class="card-text">
                          <i class="bi bi-telephone"></i>
                          <span id="pn2"></span>
                        </p>
                      </div>
                      <div class="mb-4">
                        <h6 class="card-subtitle mb-1 fm-bold">E-Mail</h6>
                        <p class="card-text" id="email"></p>
                      </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-4">
                        <h6 class="card-subtitle mb-1 fm-bold">Social Links</h6>
                        <p class="card-text mb-1">
                          <i class="bi bi-facebook me-1"></i>
                          <span id="fb"></span>
                        </p>
                        <p class="card-text mb-1">
                          <i class="bi bi-instagram me-1"></i> 
                          <span id="insta"></span>
                        </p>
                        <p class="card-text mb-1">
                          <i class="bi bi-twitter me-1"></i>
                          <span id="tw"></span>
                        </p>
                    </div>
                    <div class="mb-4">
                        <h6 class="card-subtitle mb-1 fm-bold">iFrame</h6>
                        <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
                    </div>
                    
                  </div>
                </div>
              </div>
        </div>

        <!-- contact detail Modal  -->

          <div class="modal fade" id="contacts-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <form id="contacts_s_form">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" >Contact Setting</h5>
                    </div>
                    <div class="modal-body">
                      <div class="container-fluid p-0">
                          <div class="row">
                            <div class="col md-6">
                              <div class="mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <input type="text" name="address" id="address_inp" class="form-control shadow-none" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label fw-bold">Google Maps Link</label>
                                <input type="text" name="gmap" id="gmap_inp" class="form-control shadow-none" required>
                              </div> 
                              <div class="mb-3">
                                <label class="form-label fw-bold">Phone Numbers (With Country Codes)</label>
                                <div class="input-group mb-3">
                                  <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                  <input type="text" name="pn1" id="pn1_inp" class="form-control shadow-none" required>
                                </div>
                                <div class="input-group mb-3">
                                  <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                  <input type="text" name="pn2" id="pn2_inp" class="form-control shadow-none" >
                                </div>
                              </div>
                              <div class="mb-3">
                                <label class="form-label fw-bold">E-mail</label>
                                <input type="email" name="email" id="email_inp" class="form-control shadow-none" required>
                              </div>
                            
                            </div>
                            <div class="col-md-6">
                              <div class="mb-3">
                                <label class="form-label fw-bold">social links</label>
                                <div class="input-group mb-3">
                                  <span class="input-group-text"> <i class="bi bi-facebook"></i></span>
                                  <input type="text" name="fb" id="fb_inp" class="form-control shadow-none" required>
                                </div>
                                <div class="input-group mb-3">
                                  <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                  <input type="text" name="insta" id="insta_inp" class="form-control shadow-none" required >
                                </div>
                                <div class="input-group mb-3">
                                  <span class="input-group-text">   <i class="bi bi-twitter"></i></span>
                                  <input type="text" name="tw" id="tw_inp" class="form-control shadow-none" >
                                </div>
                              </div>
                              <div class="mb-3">
                                <label class="form-label fw-bold">iFrame Src</label>
                                <input type="text" name="iframe" id="iframe_inp" class="form-control shadow-none" required>
                              </div>

                            </div>
                          </div>  
                    </div>
                    <div class="modal-footer">
                      <button type="button" onclick="contacts_inp(contacts_data)" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                      <button type="submit" class="btn btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <!-- Management Team Setting Section -->

            <div class="card border-0 shadow-sm mb-4" >
              <div class="card-body">
                    <div class="d-flex allign-item-center justify-content-between mb-3">
                        <h5 class="card-title m-8"> Management Team Setting</h5>
                        <button type="button " class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-s">
                        <i class="bi bi-plus-square"></i>ADD
                        </button>
                    </div>

                    <div class="row" id="team-data">
                      <div class="col-md-2 mb-3">
                        <div class="card bg-dark text-white">
                          <img src ="../images/about/team.jpg" class="card-img">
                          <div class="card-img-overlay text-end">
                            <button type="button" class="btn btn-danger btn-sm shadow-none">
                            <i class="bi bi-trash"></i>Delete
                            </button>
                          </div>
                          <p class="card-text text-center px-3 py-2">Random Name</p>
                        </div>
                      </div>
                    </div>
              </div>
            </div>

         <!-- Management Team  Modal  -->

      <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form id="team_s_form">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >Add Team Member</h5>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label class="form-label fw-bold">Name</label>
                      <input type="text" name="member_name" id="member_name_inp" class="form-control shadow-none" required>
                  </div>  
                  <div class="mb-3">
                  <label class="form-label fw-bold">Picture</label>
                  <input type="file" name="member_picture" id="member_picture_inp" accept= ".jpg , .png , .jpeg , .webp "  class="form-control shadow-none" required>

                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" onclick="contacts_inp(contacts_data)" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn custom-bg text-white shadow-none">SUBMIT</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
</div>


<?php require('inc/script.php');?>
<script src="scripts/settings.js"></script>


</body>
</html>