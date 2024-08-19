<?php
$checkAuth = UserLoginAuth()
?>



<div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php 
                       if($checkAuth){
                        echo ' <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="'.route('user/main.php').'" >Profile</a>
                        </li>';
                       }
                       ?>
                    
                      <?php 

                      if(!$checkAuth){
                        echo '  <li class="nav-item">
                            <a class="nav-link" href="'.route('auth/login.php').'">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="'.route('auth/register.php').'">Register</a>
                        </li> ';
                      }
                      ?>
                       <?php 
                       if($checkAuth){
                        echo '  <li class="nav-item">
                            <a class="nav-link" href="'.route('blogs/blogs.php').'">Blogs</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" href="'.route('auth/logout.php').'">Log out</a>
                        </li>
                        ';
                       }
                       ?>
                      
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>