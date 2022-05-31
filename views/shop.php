<body>
 <title><?php echo $calendar[0]->getEvent()->getName() ?></title>
  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
     
  <div class="tm-main">
  
    <div class="tm-welcome-section">
    <?php include('nav.php'); ?> 

      <div class="container text-center tm-welcome-container">
        <div class="tm-welcome">
          <i class="fas tm-fa-big fa-music tm-fa-mb-big"></i>
          <h1 class="text-uppercase mb-3 tm-site-name">Musiteck</h1>
          <p class="tm-site-description">best online ticket service</p>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="tm-search-form-container">
        <form action="<?= FRONT_ROOT ?>home/searchView" method="POST" class="form-inline tm-search-form __flex-center">
          <div class="form-group tm-search-box">
            <input type="text" name="keyword" class="form-control tm-search-input" placeholder="Type your keyword ...">
            <input type="submit" value="Search" class="form-control tm-search-submit">
          </div>
        </form>
      </div>
      <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 order-lg-2">
            <div class="p-5">
              <img class="img-fluid rounded-circle" src="<?= IMG_PATH ?>01.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="p-5">
              <h2 class="display-4"> <?php echo $calendar[0]->getEvent()->getName() ?> comes to Argentina!</h2>
              <h5>On <?php echo $calendar[0]->getDate() ?>  at <?php echo $calendar[0]->getEventLocation()->getName() ?> you are going to be able to come and see something you will never forget.</h5>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="p-5">
              <img class="img-fluid rounded-circle" src="<?= IMG_PATH ?>02.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="p-5">
              <h2 class="display-4">With the participation of:</h2>
              <h5>| <?php foreach ($artists as $key => $value) { echo $value[0]->getName(), " | "; } ?></h5>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 order-lg-2">
            <div class="p-5">
              <img class="img-fluid rounded-circle" src="<?= IMG_PATH ?>03.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="p-5">
              <h2 class="display-4">Buy your tickets now!</h2>
              <p>
                <form action="<?= FRONT_ROOT ?>purchaseLine/add" method="POST">
                  <div class="form-group mb-0">
                    <h4 class="tm-mb-20">Event Seats</h4>
                      <select class="form-control __height-initial" name="id" required>
                        <?php foreach ($seatEvents as $key => $value) { ?>
                              <option value='<?= $value->getId() ?>'?> <?= $value->getSeatType()->getName()?>, <?= $value->getPrice(); ?> $ </option>
                            <?php } ?> 
                      </select>
                      </div>
                      <div class="form-group">
                      <br><h4 class="tm-mb-20">Quantity</h4>
                        <input class="form-control" type="text" name="quantity" required>
                      </div>
                      <input type="submit" value="Add To Cart" class="tm-bg-pink tm-text-white d-block ml-auto tm-subscribe-btn">
                  </div>
                </form>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
      
    </div> <!-- .container -->

  </div> <!-- .main -->