<title>Cart</title>
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
        <form action="<?= FRONT_ROOT ?>home/searchView" method="GET" class="form-inline tm-search-form __flex-center">
          <div class="form-group tm-search-box">
            <input type="text" name="keyword" class="form-control tm-search-input" placeholder="Type your keyword ...">
            <input type="submit" value="Search" class="form-control tm-search-submit">
          </div>
        </form>
      </div>

      <div class="site-section py-5" >
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12">
            <div class="site-blocks-table">
            <?php if (!empty($purchaseLines)){ 
                $total = 0; ?>
              <table class="table table-bordered" style="text-align:center;">
                <thead class="text-white bg-primary">
                  <tr>
                    <th class="product-name">Date</th>
                    <th class="product-name">Event</th>
                    <th class="product-name">Seat Type</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>

                   <?php foreach ($purchaseLines as $key => $value) { ?>
                    <form action="<?= FRONT_ROOT ?>purchaseLine/delete" method="POST">
                    <input type="number" name="id" value="<?= $value->getId() ?>" hidden>
                      <tr>
                        <td><?= $value->getEventSeat()->getCalendar()->getDate() ?></td>
                        <td><?= $value->getEventSeat()->getCalendar()->getEvent()->getName() ?></td>
                        <td><?= $value->getEventSeat()->getSeatType()->getName() ?></td>
                        <td><?= $value->getEventSeat()->getPrice() ?></td>
                        <td><?= $value->getQuantity() ?></td>
                        <td><?= $value->getTotal() ?></td>
                        <td><button type="submit" class="btn btn-danger cursor-pointer" id="inputProductoEliminar"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                      </tr>
                    </form>
                      <?php $total += $value->getTotal();
                           } 
                      }else { ?>
                                <h4  style="text-align:center;"> No Tickets on the cart <h4>
                          <?php  } ?>	
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6">
                <a href="<?= FRONT_ROOT ?>Home/index" class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="text-black h4" for="coupon">Coupon</label>
                <p>Enter your coupon code if you have one.</p>
              </div>
              <div class="col-md-8 mb-3 mb-md-0">
                <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary btn-sm">Apply Coupon</button>
              </div>
            </div>
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                  <?php if(!isset($total)){ 
                      $total = 0;
                   } ?>
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <span class="text-black">Subtotal</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">$<?= $total ?></strong>
                  </div>
                </div>
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">$<?= $total ?></strong>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                  <?php if(!empty($purchaseLines)) { ?>
                    <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='<?= FRONT_ROOT ?>checkout/checkoutView'">Proceed To Checkout</button>
                   <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    
    </div> <!-- .container -->

  </div> <!-- .main -->