<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Private/Express Vote/core/init.php';

if (!isadmin_logged_in()) {
  header('Location: login.php');
}

include 'views/head.php';
include 'views/navigation.php';
?>

<!-- Page Content  -->

<div class="container">
  <section class="content-header">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
      <li class="breadcrumb-item" class="active">Dashboard</li>
    </ul>
  </section>

  <div class="card-deck text-light">
    <div class="card bg-primary">
      <div class="card-body text-center">
        <?php
        $query = $db->query("SELECT * FROM position");
        echo '<h3 class="text-light">' . mysqli_num_rows($query) . "</h3>";
        ?>
        <p class="card-text">No. of Positions</p>
      </div>
      <a href="posts.php" class="small-box-footer text-center">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>

    <div class="card bg-warning">
      <div class="card-body text-center">
        <?php
        $query = $db->query("SELECT * FROM candidates");
        echo '<h3 class="text-light">' . mysqli_num_rows($query) . "</h3>";
        ?>
        <p class="card-text">No. of Candidates</p>
      </div>
      <a href="candidates.php" class="small-box-footer text-center">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>

    <div class="card bg-success">
      <div class="card-body text-center">
        <?php
        $query = $db->query("SELECT * FROM voters");
        echo '<h3 class="text-light">' . mysqli_num_rows($query) . "</h3>";
        ?>
        <p class="card-text">Total Voters</p>
      </div>
      <a href="voters.php" class="small-box-footer text-center">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>

    <div class="card bg-danger">
      <div class="card-body text-center">
        <?php
        $query = $db->query("SELECT * FROM votes GROUP BY voters_id");
        echo '<h3 class="text-light">' . mysqli_num_rows($query) . "</h3>";
        ?>
        <p class="card-text">Voters Voted</p>
      </div>
      <a href="votes.php" class="small-box-footer text-center">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="row mt-2">
    <div class="col-12">
      <h3>Votes Tally</h3>
    </div>
  </div>

  <?php
  $query = $db->query("SELECT * FROM position");
  $inc = 2;
  while ($row = mysqli_fetch_assoc($query)) :
    $inc = ($inc == 2) ? 1 : $inc + 1;
    if ($inc == 1) echo "<div class='row'>";
    echo "
        <div class='col-6'>
          <div class='box box-solid'>
            <div class='box-header with-border'>
              <h4 class='box-title'><b>" . $row['post'] . "</b></h4>
            </div>
            <div class='box-body'>
              <div class='chart'>
                <canvas id='" . ($row['post']) . "' style='height:200px'></canvas>
              </div>
            </div>
          </div>
        </div>
      ";
    if ($inc == 2) echo "</div>";
  endwhile;
  if ($inc == 1) echo "<div class='col-6'></div></div>"
  ?>

</div>

<?php
$query = $db->query("SELECT * FROM position");
while ($row = mysqli_fetch_assoc($query)) :
  $sql = "SELECT * FROM candidates WHERE parent_id = '" . $row['parent_id'] . "'";
  $cquery = $db->query($sql);
  $carray = array();
  $varray = array();
  while ($crow = $cquery->fetch_assoc()) {
    array_push($carray, $crow['lastname']);
    $sql = "SELECT * FROM votes WHERE candidate_id = '" . $crow['id'] . "'";
    $vquery = $db->query($sql);
    array_push($varray, $vquery->num_rows);
  }
  $carray = json_encode($carray);
  $varray = json_encode($varray);
?>
  <script>
    $(function() {
      var rowid = '<?php echo $row['parent_id']; ?>';
      var description = '<?php echo $row['post']; ?>';
      var barChartCanvas = $('#' + description).get(0).getContext('2d')
      var barChart = new Chart(barChartCanvas)
      var barChartData = {
        labels: <?php echo $carray; ?>,
        datasets: [{
          label: 'Votes',
          fillColor: 'rgba(60,141,188,0.9)',
          strokeColor: 'rgba(60,141,188,0.8)',
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: <?php echo $varray; ?>
        }]
      }
      var barChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
      }

      barChartOptions.datasetFill = false
      var myChart = barChart.HorizontalBar(barChartData, barChartOptions)
      //document.getElementById('legend_'+rowid).innerHTML = myChart.generateLegend();
    });
  </script>
<?php endwhile; ?>
<?php include 'views/footer.php'; ?>