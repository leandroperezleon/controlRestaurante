<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid" >
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fas fa-align-left"></i>
            <span>Cerrar Men&uacute;</span>
        </button>                    
		
		<div class="nav-item dropdown no-arrow" >
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 ml-5"><?php echo  $_SESSION['username'];?></span>            
            <img class="img-profile rounded-circle" src="../../imagen/<?php echo  $_SESSION['username'];?>.jpg" alt="foto usuario">
          </a>
          <!-- Dropdown -->                      
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          		<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          		Logout
        	</a>                
          </div>
        </div>                                      
    </div>
</nav>