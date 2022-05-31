

<title>Musiteck</title>

<body>

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

      <div class="row tm-albums-container grid">
      <?php if (!empty($artists)){
        foreach ($artists as $key => $value) { ?>
          <div id="myImg" class="col-sm-6 col-12 col-md-6 col-lg-3 col-xl-3 tm-album-col">
            <figure class="effect-sadie">
              <img src="<?= $value[0]->getPhoto() ?>" alt="Image">
              <a href="<?= FRONT_ROOT ?>shop/shopViewArtist/<?= $value[0]->getId() ?>">
              <figcaption>
              <p>  <?= $value[0]->getName() ?> </p>
              </figcaption>
              </a>
            </figure>
          </div>
      <?php } 
			} else {
					echo '<h4> NO ARTIST TO SHOW! </h4>';
			}	?>	
    </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="tm-tag-line">
          <h2 class="tm-tag-line-title">Music is your powerful energy.</h2>
          </div>
        </div>
      </div>

      <?php if (!empty($calendars)){ ?>
          <div class="row mb-5">
            <div class="col-xl-12">
              <div class="media-boxes">
          <?php foreach ($calendars as $key => $value) { ?>
                <div class="media">
                  <img src="<?= IMG_PATH ?>insertion-140x140-03.jpg" alt="Image" class="mr-3">
                    <div class="media-body tm-bg-gray"> 
                      <div class="tm-description-box">
                        <h5 class="tm-text-blue"><?= $value->getEvent()->getName() ?></h5>
                        <p class="mb-0">This is an awesome event of <?= $value->getEvent()->getCategory()->getName(); ?> full of energy. You will love every moment you are in this event at <?= $value->getEventLocation()->getName() ?>.</p>
                      </div>
                      <div class="tm-buy-box">
                      <a href="<?= FRONT_ROOT ?>shop/shopViewCalendar/<?= $value->getId() ?>" class="tm-bg-blue tm-text-white tm-buy">buy</a>
                      </div>
                    </div>
                  </div>
          <?php } ?>  
              </div>
          </div>
        </div>
         <?php } else {
					echo 'NO EVENTS TO SHOW!';
			} ?>

      <div class="row tm-mb-big tm-subscribe-row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 tm-bg-gray tm-subscribe-form">
          <h3 class="tm-text-pink tm-mb-30">Subscribe our updates!</h3>
          <p class="tm-mb-30">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi semper, ligula et pretium porttitor, leo orci accumsan ligula.</p>
          <form action="index.html" method="POST">
            <div class="form-group mb-0">
              <input type="text" class="form-control tm-subscribe-input" placeholder="Your Email">
              <input type="submit" value="Submit" class="tm-bg-pink tm-text-white d-block ml-auto tm-subscribe-btn">
            </div>
          </form>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 img-fluid pl-0 tm-subscribe-img"></div>
      </div>

      <div class="row tm-mb-medium">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
          <h4 class="mb-4 tm-font-300">Latest Albums</h4>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Sed fringilla consectetur</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Mauris porta nisl quis</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Quisque maximus quam nec</a>
          <a href="#" class="tm-text-blue-dark d-block">Class aptent taciti sociosqu ad</a>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
          <h4 class="mb-4 tm-font-300">Our Pages</h4>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Nam dapibus imperdiet</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Primis in faucibus orci</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Sed interdum blandit dictum</a>
          <a href="#" class="tm-text-blue-dark d-block">Donec non blandit nisl</a>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
          <h4 class="mb-4 tm-font-300">Quick Links</h4>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Nullam scelerisque mauris</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Vivamus tristique enim non orci</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Luctus et ultrices posuere</a>
          <a href="#" class="tm-text-blue-dark d-block">Cubilia Curae</a>
        </div>
      </div>
    </div> <!-- .container -->

  </div> <!-- .main -->
