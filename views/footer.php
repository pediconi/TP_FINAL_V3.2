<footer id="myFooter">
  <div class="col-xl-12">
    <p class="text-center p-4">Copyright &copy; <span class="tm-current-year">2018</span> Musiteck - Web Design</p>
  </div>  
</footer>
      
<!-- load JS -->
<script src="<?= JS_PATH ?>jquery-3.2.1.slim.min.js"></script> <!-- https://jquery.com/ -->
  <script src="<?= JS_PATH ?>bootstrap.min.js"></script>         <!-- https://getbootstrap.com/ -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
  <script src="<?= JS_PATH ?>tail.select.js"></script>   
  <script>
    $('#datepicker').datepicker({
      format: 'yyyy/mm/dd',
      uiLibrary: 'bootstrap4'
    });
    const span=$('#datepicker')[0].nextSibling;
    span.style.backgroundColor='#298eec'
    console.log(span);
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script>
  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})</script>
  
  <script>
    $(document).ready(function() {
      $('.js-example-basic-multiple').select2();
  });
  </script>
  <script type="text/javascript">
    function form_submit() {
      document.getElementById("form").submit();
    }    
  </script>
  <script>
    /* DOM is ready
    ------------------------------------------------*/
    $(function () {

      if (renderPage) {
        $('body').addClass('loaded');
      }

      $('.tm-current-year').text(new Date().getFullYear());  // Update year in copyright
    });

    const navbar = document.querySelector('.tm-navbar-container'),
          next_container = document.getElementById('next-container'),
          navbar_height = navbar.clientHeight + navbar.style.marginTop + navbar.style.marginBottom;

    next_container.style.marginTop = `${navbar_height}px`; 

  </script>
  <script>
    $(function() {
      $('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy/mm/dd',
        autoHide: true,
        zIndex: 2048,
      });
    });
  </script>
</body>
</html>