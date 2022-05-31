<?php if (isset($_SESSION['user'])) {
	$cuenta = $_SESSION['user'];
}else{
    $cuenta = null;
} ?>
    <div class="container tm-navbar-container">
    <div class="row">
        <div class="col-xl-12">
        <nav class="navbar navbar-expand-sm">
            <?php if($cuenta) { ?>
            <?php if ($cuenta->getRole() === 'admin') {	?>
            <nav id="nav-primary" class="navbar">
                <button id="nav-btn" type="button" class="btn btn-outline-light btn-lg " data-toggle="collapse" href="#navCollapse" role="button" aria-expanded="false" aria-controls="navCollapse">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="collapse multi-collapse" id="navCollapse">
                    <ul>
                        <li class="nav-item">
                            <a href="<?= FRONT_ROOT ?>artist/artistView" class="nav-link tm-nav-link btn-primary">Manage Artist</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= FRONT_ROOT ?>event/eventView" class="nav-link tm-nav-link btn-primary">Manage Event</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= FRONT_ROOT ?>category/categoryView" class="nav-link tm-nav-link btn-primary">Manage Categories</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= FRONT_ROOT ?>eventLocation/eventLocationView" class="nav-link tm-nav-link btn-primary">Manage Locations</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= FRONT_ROOT ?>seatType/seatTypeView" class="nav-link tm-nav-link btn-primary">Manage Seat Types</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= FRONT_ROOT ?>calendar/calendarView" class="nav-link tm-nav-link btn-primary" >Manage Calendar</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php } ?>
            <?php } ?>
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="<?= FRONT_ROOT ?>home/index" class="nav-link tm-nav-link tm-text-white">Home</a>
            </li>
            <li class="nav-item">
                <a href="<?= FRONT_ROOT ?>purchaseLine/purchaseLineView" class="fas fa-shopping-cart nav-link tm-nav-link tm-text-white " style="font-size: 2em"></a>
            </li>
            <li class="nav-item">
                <a href="<?= FRONT_ROOT ?>User/logout" class="nav-link tm-nav-link tm-text-white">Logout</a>
            </li>
            </ul>
        </nav>
        </div>
    </div>

    </div>

