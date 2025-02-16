<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
    <h3 class="mb-0 h-font">SADGURU TENT FURNITURE HOUSE</h3>
    <a href="logout.php" class="btn bg-light btn-sm">log out</a>
</div>
<div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
      <nav class="navbar navbar-expand-lg navbar-dark">
          <div class="container-fluid flex-lg-column align-items-stretch">
              <h4 class="mt-2 text-light">Admin Panel</h4>
              <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropDown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropDown">
                  <ul class="nav nav-pills flex-column">
                    
                    <li class="nav-item ">
                      <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item ">
                    <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#bookingLinks">
                      <span>Bookings</span>
                      <span><i class="bi bi-caret-down-fill"></i></span>
                    </button>
                    <div class="collapse show px-3 small mb-1" id="bookingLinks">
                      <ul class="nav nav-pills flex-column rounded border border-secondary">
                        <li class="nav-item">
                          <a class="nav-link text-white" href="booking_record.php">Booking Records</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link text-white" href="booking_details.php">Booking Details</a>
                        </li>
                      </ul>
                    </div>
                    </li>
                    <li class="nav-item ">
                      <a class="nav-link text-white" href="users.php">Users</a>
                    </li> 
                    <li class="nav-item ">
                      <a class="nav-link text-white" href="user_queries.php">USer Queries</a>
                    </li>  

                    <li class="nav-item ">
                      <a class="nav-link text-white" href="products.php">products</a>
                    </li>
                     <li class="nav-item ">
                      <a class="nav-link text-white" href="features_facilities.php">Features & Facilities</a>
                    </li>
 
                    <li class="nav-item ">
                      <a class="nav-link text-white" href="carousal.php">Carousel</a>
                    </li>
                    <li class="nav-item ">
                      <a class="nav-link text-white" href="setting.php">Settings</a>
                    </li>
                    

                  </ul>
              </div>       
          </div>
      </nav>
</div>