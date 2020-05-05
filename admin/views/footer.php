      </div>
    </main>



    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="../dist/js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="../dist/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="../dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../dist/js/main.js"></script>

    <script type="text/javascript" src="../dist/datatable/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../dist/datatable/js/dataTables.bootstrap4.min.js"></script>
    <!-- <script type="text/javascript" src="../dist/js/toastr.js"></script> -->

    <!-- VIEW DETAILS -->
    <script type="text/javascript">   
      $(document).ready(function() {
        // CANDIDATE
        $('.view_candidate_data').click(function(){
          var candy = $(this).data('id');

          $.ajax({
            url: "models/getcandy.php",
            method: "POST",
            data: {candy:candy},
            success: function(data){
              $('#candidate_result').html(data);
              $('#candidate_viewmodal').modal('show');
            }
          });
        });
        // CANDIDATE

        // VOTER
        $('.view_voter_data').click(function(){
          var voty = $(this).data('id');

          $.ajax({
            url: "models/getvoter.php",
            method: "POST",
            data: {voty:voty},
            success: function(data){
              $('#voter_result').html(data);
              $('#voter_viewmodal').modal('show');
            }
          });
        });
        // VOTER
      });

    </script>
    <!-- VIEW DETAILS -->

    <!-- HOVER ON DROPDOWN -->
    <script type="text/javascript">
      $(document).ready(function(){
        $(".dropdown, .btn-group").hover(function(){
          var dropdownMenu = $(this).children(".dropdown-menu");

          if(dropdownMenu.is(":visible")){
            dropdownMenu.parent().toggleClass("open");
          }
        });
      });
    </script>
    <!-- HOVER ON DROPDOWN -->

    <!-- DATATABLE -->
    <script type="text/javascript">
      $(document).ready(function() {
        $('#dataTable').DataTable({
        // If you want to disable some features, use the following code.
        // "pageLength": 5,
        // "paging": true,
        // "lengthChange": false,
        // "searching": false,
        // "ordering": true,
        // "info": true,
        // "autoWidth": true
        });
      });
    </script>

    <!-- DATATABLE -->

    <!-- CUSTOM FILE FOR CUSTOM SELECT DROPDOWN-->
    <script type="text/javascript">
      // Add the following code if you want the name of the file appear on select
      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
    </script>
    <!-- CUSTOM FILE FOR CUSTOM SELECT DROPDOWN-->

    <!-- TOAST RELATED -->
    <script type="text/javascript">
      $(document).ready(function(){
        $('.toast').toast('show');
      });

      window.setTimeout(function () {
        $(".toast").fadeTo(500, 0).slideUp(500, function () {
          $(this).remove();
        });
      }, 5000);
    </script>
    <!-- TOAST RELATED -->

  </body>
</html>
