      </div>
      </main>



      <!-- SCRIPTS -->
      <!-- JQuery -->
      <script type="text/javascript" src="../dist/js/jquery-3.4.1.min.js"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
      <!-- Bootstrap tooltips -->
      <script type="text/javascript" src="../dist/js/popper.min.js"></script>
      <!-- Bootstrap core JavaScript -->
      <script type="text/javascript" src="../dist/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="../dist/js/main.js"></script>

      <script type="text/javascript" src="../dist/datatable/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="../dist/datatable/js/dataTables.bootstrap4.min.js"></script>
      <!-- iCheck 1.0.1 -->
      <script src="../plugins/iCheck/icheck.min.js"></script>
      <!-- Moment JS -->
      <script src="../bower_components/moment/moment.js"></script>
      <!-- ChartJS -->
      <script src="../bower_components/chart.js/Chart.js"></script>
      <!-- ChartJS Horizontal Bar -->
      <script src="../bower_components/chart.js/Chart.HorizontalBar.js"></script>
      <!-- daterangepicker -->
      <script src="../bower_components/moment/min/moment.min.js"></script>
      <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
      <!-- datepicker -->
      <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
      <!-- bootstrap time picker -->
      <script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
      <!-- Slimscroll -->
      <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
      <!-- FastClick -->
      <script src="../bower_components/fastclick/lib/fastclick.js"></script>
      <!-- AdminLTE App -->
      <script src="../dist/js/adminlte.min.js"></script>
      <!-- Active Script -->
      <script>
        $(function() {
          /** add active class and stay opened when selected */
          var url = window.location;

          // for sidebar menu entirely but not cover treeview
          $('ul.sidebar-menu a').filter(function() {
            return this.href == url;
          }).parent().addClass('active');

          // for treeview
          $('ul.treeview-menu a').filter(function() {
            return this.href == url;
          }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

        });
      </script>
      <!-- <script type="text/javascript" src="../dist/js/toastr.js"></script> -->

      <!-- VIEW DETAILS -->
      <script type="text/javascript">
        $(document).ready(function() {
          // CANDIDATE
          $('.view_candidate_data').click(function() {
            var candy = $(this).data('id');

            $.ajax({
              url: "models/getcandy.php",
              method: "POST",
              data: {
                candy: candy
              },
              success: function(data) {
                $('#candidate_result').html(data);
                $('#candidate_viewmodal').modal('show');
              }
            });
          });
          // CANDIDATE

          // VOTER
          $('.view_voter_data').click(function() {
            var voty = $(this).data('id');

            $.ajax({
              url: "models/getvoter.php",
              method: "POST",
              data: {
                voty: voty
              },
              success: function(data) {
                $('#voter_result').html(data);
                $('#voter_viewmodal').modal('show');
              }
            });
          });
          // VOTER

          // USER
          $('.view_user_data').click(function() {
            var usy = $(this).data('id');

            $.ajax({
              url: "models/getusers.php",
              method: "POST",
              data: {
                usy: usy
              },
              success: function(data) {
                $('#user_result').html(data);
                $('#user_viewmodal').modal('show');
              }
            });
          });
          // USER
        });
      </script>
      <!-- VIEW DETAILS -->

      <!-- HOVER ON DROPDOWN -->
      <script type="text/javascript">
        $(document).ready(function() {
          $(".dropdown, .btn-group").hover(function() {
            var dropdownMenu = $(this).children(".dropdown-menu");

            if (dropdownMenu.is(":visible")) {
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
        $(document).ready(function() {
          $('.toast').toast('show');
        });

        window.setTimeout(function() {
          $(".toast").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
          });
        }, 5000);
      </script>
      <!-- TOAST RELATED -->

      </body>

      </html>