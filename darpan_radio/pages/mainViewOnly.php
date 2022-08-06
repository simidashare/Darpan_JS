<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ){
    header("location: ../index.php");
    exit;
  }else{
      include "../database.php";
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Darpan Radio - Administration</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

    <link id="pagestyle" href="../assets/css/darpan-db.min.css" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <div class="navbar-brand m-0" href="#" target="_blank">
                <img class="navbar-brand-img" />
                <span class="ms-1 font-weight-bold navbar-brand-img">Darpan Radio</span>
            </div>
        </div>
        <hr class="horizontal dark mt-0" />
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="../pages/main.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="far fa-calendar-alt text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Roster</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../pages/settings.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-cog text-warning text-sm opacity-10"></i>

                        </div>
                        <span class="nav-link-text ms-1">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer mx-3">
            <div class="card card-plain shadow-none" id="signOut"></div>
            <a href="../logout.php" class="btn btn-dark btn-lg w-100 mb-3">Sign Out</a>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl d-flex align-items-center"
            id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h5 class="font-weight-bolder nav-link text-white mb-0" style="font-size: larger">
                        Administration
                    </h5>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <div class="nav-link text-white font-weight-bold px-0">
                                <span class="d-sm-inline d-none"><?php echo  $_SESSION["broadcastername"] ?></span>
                            </div>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center d-none" id="mobile-menu2">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fas fa-bars fixed-plugin-button-nav cursor-pointer" id="bars"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="editPromotWraper"></div>
        <div class="container-fluid py-4">
            <div id="rosterWrapper" class="row d-flex justify-content-center">
                <div class="col-8">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h3>Roster</h3>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">

                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Broadcaster
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">
                                                Date
                                            </th>
                                            <th class="text-uppercase text-primary text-xl font-weight-bolder opacity-7 ps-2"
                                                id="rosterControl">
                                                <span href="javascript:;" id="addRoster"></span>
                                                <span
                                                    class="text-uppercase text-secondary text-xl font-weight-bolder opacity-7 ">
                                                </span>
                                                <a href="javascript:;" id="searchRoster">
                                                    <i class="fas fa-search fixed-plugin-button-nav cursor-pointer me-2 text-secondary"
                                                        aria-hidden="true"></i><small
                                                        class="text-secondary">Search</small></a>
                                                <span
                                                    class="text-uppercase text-primary text-xl font-weight-bolder opacity-7 ps-3">
                                                </span>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody id="message">
                                    </tbody>
                                </table>

                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-lg justify-content-center align-self-center"
                                        id="paginator">
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer pt-3">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4"></div>
                    </div>
                </div>
            </footer>
        </div>
    </main>

    <div class="fixed-plugin">
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0"></h5>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>


            <div class="d-flex justify-content-start mx-6 my-3">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="far fa-calendar-alt text-warning text-sm opacity-10"></i>

                </div>
                <a href="../pages/main.php">
                    <h5 class="py-2 ms-1">Roster</h5>
                </a>
            </div>
            <div class="d-flex justify-content-start mx-6 my-3">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-user-cog text-warning text-sm opacity-10"></i>
                </div>
                <a href="../pages/settings.php">
                    <h5 class="py-2 ms-1">Settings</h5>
                </a>
            </div>
            <div class="d-flex justify-content-center my-6">
                <a href="../logout.php" class="btn btn-dark btn-lg w-90 mb-3">Sign Out</a>
            </div>
        </div>
    </div>
    </div>


    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/darpan-db2.min.js" defer></script>
</body>

</html>
