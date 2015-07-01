<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assist - Contacts</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!--Adding jquery file-->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body>

  <!-- fixed top navbar -->
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.html">Assist</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <!--
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>-->
      <ul class="nav navbar-nav navbar-right">
        <!--<li><a href="#">Link</a></li>-->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Profile<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">My Account</a></li>
            <li><a href="#">Settings</a></li>
            <!--<li><a href="#">Something else here</a></li>-->
            <li class="divider"></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


  <div class="container bootcards-container push-right">

    <!-- This is where you come in... -->
    <!-- I've added some sample data below so you can get a feel for the required markup -->

    <div class="row" style="padding-bottom:50px">
  
      <div class="col-md-12">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for..." style="height:50px;">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" style="height:50px;">Go!</button>
          </span>
        </div><!-- /input-group -->
      </div>
    </div>
      
    </div>

    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
          <a href="contacts/"><img src="img/index/contacts.png" alt="Contacts"></a>
          <div class="caption">
            <h3 class="text-center">Contacts</h3>
          </div>
        </div>
      </div><!--close-col-->

      <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
          <a><img src="img/index/cars.png" alt="Cars"></a>
          <div class="caption">
            <h3 class="text-center">Cars</h3>
          </div>
        </div>
      </div><!--close-col-->

      <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
          <a><img src="img/index/shares.png" alt="Shares"></a>
          <div class="caption">
            <h3 class="text-center">Shares</h3>
          </div>
        </div>
      </div><!--close-col-->

      <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
          <a><img src="img/index/assets.png" alt="Assets"></a>
          <div class="caption">
            <h3 class="text-center">Assets</h3>
          </div>
        </div>
      </div><!--close-col-->

    </div><!--row-->

  </div><!--container-->
  </body>
</html>
