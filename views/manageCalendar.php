
  <title>Manage Calendar</title>


<body class="bg-image-cover-blue">

  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <div class="tm-main">
  <?php include('nav.php'); ?> 
    <div class="tm-background-section d-block">
      <div id="next-container" class="container text-center tm-background-container">
        <div class="tm-background">
          <main>
            <section class="mb-5">
              <div class="container">
                <h2 class="mb-4">Add Calendar</h2>
                <form class="bg-light-alpha p-5" action="add" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="">Date</label>
                  <div class="well">
                  <div id="datetimepicker1">
                    <input id="datepicker" name="date" required/>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="">Event</label>
                <select class="form-control __height-initial" name="event" required>
                  <?php foreach ($events as $key => $value) { ?>
                    <option value='<?= $value->getId() ?>'?> <?= $value->getName(); ?> </option>
                  <?php } ?>
                </select>
              </div>

              <label for="">Artists</label>
              <div class="form-group">
                <select class="js-example-basic-multiple js-states form-control" id="artists_dropdown" multiple="multiple" name="states[]">
                  <?php foreach ($artists as $key => $value) { ?>
                    <option value='<?= $value->getId() ?>'?> <?= $value->getName(); ?> </option>
                  <?php } ?>
                </select>
              </div>            

              <div class="form-group">
                <label for="">Place</label>
                <div class="input-group mb-3">
                  <select class="form-control __height-initial" name="place" aria-describedby="basic-addon1" >
                    <?php foreach ($eventLocation as $key => $value) { ?>
                      <option value='<?= $value->getId() ?>'?> <?= $value->getName();?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
                      
                      <div class="form-group">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#seats">
                          Manage Seats
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="seats" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Manage Seats</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div id="mymodal" class="modal-body">
                                <?php foreach ($seatType as $key => $value) { ?>  <!-- seatTypes arreglo de objetos seat type-->
                                  <h4><?php echo $value->getName();?><h4>
                                    <div class="input-group mb-3">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text">Price $</span>
                                      </div>
                                      <input type="text" name="seats[<?= $value->getId(); ?>][price]" class="form-control" aria-label="Amount (to the nearest dollar)">
                                      <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                      </div>
                                  </div>
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon1">Capacity</span>
                                    </div>
                                    <input type="text" name="seats[<?= $value->getId(); ?>][capacity]" class="form-control" aria-label="vipFieldcapacity" aria-describedby="basic-addon1">
                                  </div>
                              <?php } ?>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Accept</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    </div>        
                    <button type="submit" class="btn btn-primary">Submit</button> <!-- POR QUE SE PONE AFUERA -->
                  </form>
              </div>
            </section>
        
            <section class="mb-5">
              <div class="container">
                  <h2 class="mb-4">List</h2>
                  <?php if (!empty($calendars)){ ?>
                    <table id="listado" id="tb-1" class="table bg-light-alpha">
                    <thead class="bg-primary">
                      <th scope="col">ID</th>
                      <th scope="col">Date</th>
                      <th scope="col">Event</th>
                      <th scope="col">Place</th>
                    </thead>
                    <tbody>
                    <?php foreach ($calendars as $key => $value) { ?>
                      <tr>
                        <td><?php echo $value-> getId(); ?></td>
                        <td><?php echo $value-> getDate(); ?></td>
                        <td><?php echo $value-> getEvent()->getName(); ?></td>
                        <td><?php echo $value-> getEventLocation()->getName(); ?></td>
                      </tr>
                  <?php } ?>
                  </tbody>
                </table> 
              </div>
              <div class="form-group">
                <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">
                    Edit
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 id="mymodal" class="modal-title" id="exampleModalLongTitle">Edit Calendar</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div id="mymodal" class="modal-body">
                        <form id="form" action="<?= FRONT_ROOT ?> calendar/modify" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                              <label for="">Id</label>
                              <input class="form-control" type="text" name="id" required>
                          </div>
                          <div class="form-group">
                            <label for="">Date</label>
                            <input name="date" type="text" class="form-control" data-toggle="datepicker">
                          </div>

                          <div class="form-group">
                            <label for="">Event</label>
                            <select class="form-control __height-initial" name="event" required>
                              <?php foreach ($events as $key => $value) { ?>
                                <option value='<?= $value->getId() ?>'?> <?= $value->getName(); ?> </option>
                              <?php } ?>
                            </select>
                          </div>

                          <label for="">Artists</label>
                          <div class="form-group">
                            <select class="js-states form-control" id="artists_dropdown2" multiple="multiple" name="states[]">
                              <?php foreach ($artists as $key => $value) { ?>
                                <option value='<?= $value->getId() ?>'?> <?= $value->getName(); ?> </option>
                              <?php } ?>
                            </select>
                          </div>  
                              
                          <div class="form-group">
                            <label for="">Place</label>
                            <div class="input-group mb-3">
                              <select class="form-control __height-initial" name="place" aria-describedby="basic-addon1" >
                                <?php foreach ($eventLocation as $key => $value) { ?>
                                  <option value='<?= $value->getId() ?>'?> <?= $value->getName();?> </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="">Seats</label>
                            <?php foreach ($seatType as $key => $value) { ?>  <!-- seatTypes arreglo de objetos seat type-->
                              <h4><?php echo $value->getName();?><h4>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">Price $</span>
                                  </div>
                                  <input type="text" name="seats[<?= $value->getId(); ?>][price]" class="form-control" aria-label="Amount (to the nearest dollar)">
                                  <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                  </div>
                              </div>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Capacity</span>
                                </div>
                                <input type="text" name="seats[<?= $value->getId(); ?>][capacity]" class="form-control" aria-label="vipFieldcapacity" aria-describedby="basic-addon1">
                              </div>
                          <?php } ?>
                        </div>
                      </form>
                      <div class="modal-footer">
                      <button onclick="form_submit()" type="submit" class="btn btn-success ml-auto d-block">Edit</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </section>
              <?php } else {
                        echo '<h4> No Calendars loaded. </h4>';
                    } ?>            
            </div>
          </div>
        </div>
      </div>
    </div> <!-- .container -->
  </div> <!-- .main -->