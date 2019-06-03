<nav id="myHeader" class="navbar navbar-expand-md navbar-light bg-warning">
  <a class="navbar-brand" aria-label="link to index" href="<?php echo site_url("login/index");?>">
  	
	<div class=" mb-2 wineglass left">
		<div class="wine_inside"></div>
	</div>
	<div class=" mb-2 wineglass right">
		<div class="wine_inside"></div>
	</div>

  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">TBD 1 <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">TBD 1</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            TBD Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">TBD 2.1</a>
          <a class="dropdown-item" href="#">TBD 2.2</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">TBD 2.3</a>
        </div>
      </li>
    </ul>
    <div class="my-2 my-lg-0">
        <a href="<?php echo site_url("company/logout/")?>"><button id="logout_button" class="btn btn-primary">Logout!</button></a>
    </div>
  </div>
</nav>
