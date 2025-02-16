

<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid px-lg-4 mt-4">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_r['site_title']  ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link me-2" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link me-2" href="products.php">Products</a>
            </li>         
            <li class="nav-item">
            <a class="nav-link me-2" href="facilities.php">Facilities</a>
            </li>         
            <li class="nav-item">
            <a class="nav-link me-2" href="contact.php">Contact Us</a>
            </li>       
            <li class="nav-item">
            <a class="nav-link me-2" href="about.php">About</a>
            </li>       
        </ul>
        <div class="d-flex"> 
            <?php
                if(isset($_SESSION['login']) && $_SESSION['login']==true)
                {
                    $path = USERS_IMG_PATH;
                    echo<<<data
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                <img src="$path$_SESSION[uPic]" style="width: 25px; height: 25px;" class="me-1">
                                $_SESSION[uName]
                            </button>
                            <ul class="dropdown-menu dropdown-menu-lg-end">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    data;
                }
                else
                {
                    echo<<<data
                        <button type="button" style="width: 100px; height: 40px; " class="btn btn-outline-dark shadow-none me-2"  data-bs-display="static" aria-expanded="false" onclick="navigateToPage()">Admin</button>
                        <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginModal"> 
                            Login
                        </button>
                        <button type="button" class="btn btn-outline-dark shadow-none " data-bs-toggle="modal" data-bs-target="#registerModal"> 
                            Register
                        </button>
                    data;
                }
            ?>
            
        </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="login-form">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center">
                <i class="bi bi-person me-2 fs-3"></i>User Login
                </h5>
                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Email / Mobile</label>
                    <input type="text" name="email_mob" required class="form-control shadow-none">
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="pass" required class="form-control shadow-none">
                </div>
                <div class=" d-flex align-items-center justify-content-between mb-2">
                    <button type="submit" class="btn btn-dark shadow-none">LOGIN</button>
                    <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0 " data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal"> 
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="register-form">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center">
                <i class="bi bi-person-square fs-3 me-2"></i>
                User Registration
                </h5>
                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                Note : Your details must match with your ID (Aadhaar card, passport , driving licence , etc. )
                that will be required during rent-in. 
                </span>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" class="form-control shadow-none" required>
                            </div>    
                        <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control shadow-none" required>
                            </div>
                        <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Phone number</label>
                                <input name="phonenum" type="number" class="form-control shadow-none" required>
                            </div>    
                        <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Picture</label>
                                <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
                            </div>
                        <div class="col-md-12 p-0 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-cont crol shadow-none" rows="1" required></textarea>
                            </div>
                        <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">PIN code</label>
                                <input name="pincode" type="number
                                 " class="form-control shadow-none" required>
                            </div>     
                        <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Password</label>
                                <input name="pass" type="password" class="form-control shadow-none" required>
                            </div>    
                        <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input name="cpass" type="password" class="form-control shadow-none" required>
                            </div>   
                        </div>
                </div>
                <div class="text-center my-1">
                    <button type="submit" class="btn btn-dark shadow-none">REGISTER</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="forgot-form">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center">
                <i class="bi bi-person me-2 fs-3"></i> 
                </h5>
            </div>
            <div class="modal-body">
                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                Note : A link will be sent to your email to reset your password! 
                </span>
                <div class="mb-4">
                    <label class="form-label">Email / Mobile</label>
                    <input type="email" name="email" required class="form-control shadow-none">
                </div>
                <div class="mb-2 text-end">
                    <button type="button" class="btn shadow-none p-0 me-2" data-bs-toggle="modal" data-bs-target="#loginModal"data-bs-dismiss="modal"> 
                        CANCEL
                    </button>
                    <button type="submit" class="btn btn-dark shadow-none">SEND LINK</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
        function navigateToPage() {
                      window.open('admin/index.php', '_blank');

        }
    </script>