
  <title>Manage Event</title>

<body class="bg-image-cover-blue">

  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <div class="tm-main">
    <div class="tm-background-section">
    <?php include('nav.php'); ?> 
      <div id="next-container" class="container text-center tm-background-container">
        <div class="tm-background">
          <main>
            <section class="mb-5">
              <div class="container">
                <h2 class="mb-4">Add Event</h2>
                <form class="bg-light-alpha p-5" action="<?= FRONT_ROOT ?> event/add" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input class="form-control" type="text" name="name" required>
                  </div>
                  <div class="form-group">
                    <label for="">Category</label>
                    <select class="form-control __height-initial" name="category" required>
                      <?php foreach ($categories as $key => $value) { ?>
                        <option value='<?= $value->getId() ?>'?> <?= $value->getName(); ?> </option>
                      <?php } ?>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary ml-auto d-block">Add</button>
                </form>
              </div>
            </section>
        
            <section  class="mb-5">
              <div class="container">
                <h2 class="mb-4">List</h2>
                <?php if (!empty($events)){ ?>
                  <table id="listado" class="table bg-light-alpha">
                    <thead class="bg-primary">
                      <th>ID</th>
                      <th>Name</th>
                      <th>Category</th>
                      <th>Delete</th>
                    </thead>
                    <tbody>
                    <?php foreach ($events as $key => $value) { ?>
                      <form action="<?= FRONT_ROOT ?> event/delete" method="POST">
                      <input type="number" name="idProducto" value="<?= $value->getId() ?>" hidden>
                        <tr>
                          <td><?php echo $value-> getId(); ?></td>
                          <td><?php echo $value-> getName(); ?></td>
                          <td><?php echo $value-> getCategory()->getName(); ?></td>
                          <td><button type="submit" class="btn btn-danger cursor-pointer" id="inputProductoEliminar"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                        </tr>
                      </form>
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
                          <h5 id="mymodal" class="modal-title" id="exampleModalLongTitle">Edit Events</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div id="mymodal" class="modal-body">
                        <form id="form" action="<?= FRONT_ROOT ?> event/modify" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="">Id</label>
                            <input class="form-control" type="text" name="id" required>
                          </div>
                          <div class="form-group">
                            <label for="">Name</label>
                            <input class="form-control" type="text" name="name" required>
                          </div>
                          <div class="form-group">
                              <label for="">Category</label>
                              <select class="form-control __height-initial" name="category" required>
                                <?php foreach ($categories as $key => $value) { ?>
                                  <option value='<?= $value->getId() ?>'?> <?= $value->getName(); ?> </option>
                                <?php } ?>
                              </select>
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
                        echo '<h4> NO EVENTS LOADED. </h4>';
                    } ?>
           </div>
          </div>
        </div>
      </div>
    </div> <!-- .container -->
  </div> <!-- .main -->