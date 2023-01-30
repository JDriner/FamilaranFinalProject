    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><a class="navbar-brand" href="<?php echo $home_url; ?>">
                        <img src="../assets/images/logo.png" width="200" alt="" class="d-inline-block align-middle mr-2" style='vertical-align:middle;margin:1px 1px'> </a></h3>
                <strong><a class="navbar-brand" href="<?php echo $home_url; ?>">
                        <img src="../assets/images/logo2.png" width="50" alt="" class="d-inline-block align-middle mr-2" style='vertical-align:middle;margin:1px 1px'> </a></strong>
            </div>

            <ul class="list-unstyled components">
                <li <?php echo $page_title == "Admin Index" ? "class='nav-item active'" : ""; ?>>
                    <a class="nav-link" href="<?php echo $home_url; ?>admin/index.php"><i class="fas fa-home"></i>
                        Home
                    </a></a>
                </li>
                <li <?php
                    echo $page_title == "Client Requests" ? "class='nav-item active'" : ""; ?>>
                    <a class="nav-link" href="<?php echo $home_url; ?>admin/requestMain.php"><i class="fas fa-bell"></i> Client Requests</a>
                </li>
                <li <?php
                    echo $page_title == "View Users" ? "class='nav-item active'" : ""; ?>>
                    <a class="nav-link" href="<?php echo $home_url; ?>admin/userMain.php"><i class="fas fa-user-friends"></i> View Users</a>
                </li>
                <li <?php
                    echo $page_title == "Services" ? "class='nav-item active'" : ""; ?>>
                    <a class="nav-link" href="<?php echo $home_url; ?>admin/serviceMain.php"><i class="fas fa-toolbox"></i> Services</a>
                </li>
                <li>
                    <a href="#reportsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-chart-line"></i> Reports</a>
                    <ul class="collapse list-unstyled" id="reportsSubmenu">
                        <li>
                            <a href="<?php echo $home_url; ?>admin/reportTabular.php"><i class="fas fa-table"></i> Tabular</a>
                        </li>
                        <li>
                            <a href="<?php echo $home_url; ?>admin/reportGraph.php"><i class="fas fa-chart-area"></i> Graphical</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-user"></i> 
                        <?php echo $_SESSION['userFirstName'].' '.$_SESSION['userLastName']; ?>
                    </a>
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <li>
                            <a href="<?php echo $home_url; ?>admin/userViewAccount.php"><i class="fas fa-user"></i> View Account</a>
                        </li>
                        <li>
                            <a href="<?php echo $home_url; ?>logout.php"><i class="fas fa-power-off"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Toggle  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <button type="button" title="Toggle Sidebar" id="sidebarCollapse" class="btn btn-dark">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item">
                            <a class="nav-link" title="View Account" href="<?php echo $home_url; ?>admin/userViewAccount.php"><i class="fas fa-user"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" title="Logout" href="<?php echo $home_url; ?>logout.php"><i class="fas fa-power-off"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>




            <script type="text/javascript">
                $(document).ready(function() {
                    $('#sidebarCollapse').on('click', function() {
                        $('#sidebar').toggleClass('active');
                    });
                });
            </script>

            