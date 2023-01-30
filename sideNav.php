    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><a class="navbar-brand" href="<?php echo $home_url; ?>">
                    <img src="assets/images/logo.png"  width="200" alt="" class="d-inline-block align-middle mr-2" style='vertical-align:middle;margin:1px 1px'> </a></h3>
                <strong><a class="navbar-brand" href="<?php echo $home_url; ?>">
                    <img src="assets/images/logo2.png"  width="50" alt="" class="d-inline-block align-middle mr-2" style='vertical-align:middle;margin:1px 1px'> </a></strong>
            </div>



            <ul class="list-unstyled components">         
            <li 
                    <?php echo $page_title == "Admin Index" ? "class='nav-item active'" : ""; ?>>
                    <a class="nav-link" href="<?php echo $home_url; ?>admin/index.php"><i class="fas fa-home"></i>
                        Home
                    </a></a>
                </li>
                <li <?php echo $page_title == "Services" ? "class='nav-item active'" : ""; ?>>
                    <a class="nav-link" href="<?php echo $home_url; ?>userViewMyRequests.php"><i class="fas fa-toolbox"></i> My Requests</a>
                </li>
                <li <?php echo $page_title == "Services" ? "class='nav-item active'" : ""; ?>>
                    <a class="nav-link" href="<?php echo $home_url; ?>userViewMyTransactions.php"><i class="fas fa-clipboard-list"></i> My Transactions</a>
                </li>
            
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $home_url; ?>clientRequest.php"><i class="fas fa-paper-plane"></i></i> Request a Service</a>
                    </li>
            </ul>
            <ul class="list-unstyled components">
                <li>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-user"></i>
                        <?php echo $_SESSION['userFirstName'].' '.$_SESSION['userLastName']; ?>
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="<?php echo $home_url; ?>userViewAccount.php">View Account</a>
                        </li>
                        <li>
                            <a href="<?php echo $home_url; ?>logout.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <!-- Toggle  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item">
                            <a class="nav-link" title="View Account" href="<?php echo $home_url; ?>userViewAccount.php"><i class="fas fa-user"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" title="Logout" href="<?php echo $home_url; ?>logout.php"><i class="fas fa-power-off"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
