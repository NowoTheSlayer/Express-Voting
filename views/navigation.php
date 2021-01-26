<body>

  <nav class="navbar navbar-expand-md navbar-dark" style="background-color:teal">
    <div class="container">
      <a class="navbar-brand" href="#">Express Vote</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-flex justify-content-end" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <div>
              <img src="images/profile.jpg" style="width:40px;" alt="Voter Image" class="rounded-circle">
              <span class="nav-text ml-2 mr-5 text-light"><?= $voter_data['firstname'] . ' ' . $voter_data['lastname']; ?></span>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> LOGOUT</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  </nav>

  <main class="container">