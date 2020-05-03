    <!-- <nav id="sidebar" class="active"> -->
    <nav id="sidebar">
      <h1><a href="index.php" class="logo">E-V</a></h1>
      <ul class="list-unstyled components mb-5">
        <li class="active">
          <a href="#"><span class="fa fa-home"></span> Overview</a>
        </li>
        <li>
            <a href="#"><span class="fa fa-cogs"></span> Settings</a>
        </li>
        <li>
          <a href="#candidateSubmenu" data-toggle="collapse" aria-expanded="false"><span class="fa fa-users"></span> Candidates <i class="fa fa-arrow-down"></i></a>
          <ul class="collapse list-unstyled" id="candidateSubmenu">
            <li>
              <a href="candidates.php?add=1">Add Candidate</a>
            </li>
            <li>
              <a href="candidates.php">View Candidates</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="posts.php"><span class="fa fa-graduation-cap"></span> Posts</a>
        </li>
        <li>
          <a href="#"><span class="fa fa-sticky-note"></span> Ballot</a>
        </li>
        <li>
          <a href="#voterSubmenu" data-toggle="collapse" aria-expanded="false"><span class="fa fa-users"></span> Voters <i class="fa fa-arrow-down"></i></a>
          <ul class="collapse list-unstyled" id="voterSubmenu">
            <li>
              <a href="voters.php?add=1">Add Voter</a>
            </li>
            <li>
              <a href="voters.php">View Voters</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><span class="fa fa-paper-plane"></span> Launch</a>
        </li>
      </ul>

      <!-- <div class="footer">
        <p>
          Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
        </p>
      </div> -->
    </nav>

    <div id="content" class="p-4 p-md-5">

      <button type="button" id="sidebarCollapse" class="btn btn-primary">
        <i class="fa fa-bars"></i>
        <span class="sr-only">Toggle Menu</span>
      </button>