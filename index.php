<?php
session_start();
if (!isset($_SESSION["login"])) {
  header('Location: login.php');
} else {
  if (!$_SESSION["login"] == true) {
    header('Location: login.php');
  }
}
include("components/header.php");
include("controller/controller.php");
?>

<body>
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">

          <div class="card card-primary bg-theme">
            <div class="card-body p-5">

              <form class="d-flex justify-content-center align-items-center mb-4" action="controller/create.php" method="post" autocomplete="off" autocapitalize="false">
                <div class="form-outline flex-fill">
                  <?php
                  if (isset($_GET["name"])) {
                    echo '<input type="text" name="name" id="form2" class="form-control" value="' . $_GET["name"] . '" autofocus/>';
                  } else {
                    echo '<input type="text" name="name" id="form2" class="form-control" />';
                  }
                  ?>
                  <label class="form-label" for="form2">New task...</label>
                </div>
                <?php
                if (isset($_GET["id"])) {
                  echo '<input type="text" name="id" hidden value="' . $_GET["id"] . '" class="form-control" />';
                }
                ?>
                <button type="submit" class="btn btn-primary ms-2">
                  <?php if (isset($_GET["id"])) {
                    echo 'UPDATE';
                  } else {
                    echo 'ADD';
                  } ?>
                </button>
              </form>
              <?php
              if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger p-2" role="alert">' . $_GET["error"] . '</div>';
              }
              ?>

              <!-- Tabs navs -->
              <ul class="nav nav-tabs mb-4 pb-2" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">All</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Active</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="ex1-tab-3" data-mdb-toggle="tab" href="#ex1-tabs-3" role="tab" aria-controls="ex1-tabs-3" aria-selected="false">Completed</a>
                </li>
              </ul>
              <!-- Tabs navs -->

              <!-- Tabs content -->
              <div class="tab-content" id="ex1-content">
                <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                  <ul class="list-group mb-0" style="overflow-y: auto;max-height: 450px;">
                    <?php
                    $tasks = $controller->GetTasks();
                    foreach ($tasks as $key => $data) {
                      echo '<li class="d-flex list-group-item d-flex align-items-center border-0 mb-2 rounded" style="background-color: #f4f6f7;justify-content: space-between;">';
                      echo '<div>';
                      echo '<input class="form-check-input me-2" onchange="window.location=`controller/update.php?id=' . $data->id . '&status=' . ($data->status == 1 ? "2" : "1") . '`" type="checkbox" value="" aria-label="..." ' . ($data->status == 1 ? "" : "checked") . ' />';
                      if ($data->status == 1) {
                        echo $data->name;
                      } else {
                        echo "<s>" . $data->name . "</s>";
                      }
                      echo "</div>";
                      echo '<div><a href="index.php?id=' . $data->id . '&name=' . $data->name . '" class="btn btn-small btn-trigger p-2 me-2"><i class="fa fa-pencil-alt text-primary"></i></a><a href="controller/delete.php?id=' . $data->id . '" class="btn btn-small btn-trigger p-2"><i class="fa fa-trash text-danger"></i></a></div>';
                      echo "</li>";
                    }
                    ?>
                  </ul>
                </div>
                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                  <ul class="list-group mb-0">
                    <?php
                    $tasks = $controller->GetTasks(1);
                    foreach ($tasks as $key => $data) {
                      echo '<li class="d-flex list-group-item d-flex align-items-center border-0 mb-2 rounded" style="background-color: #f4f6f7;justify-content: space-between;">';
                      echo '<div>';
                      echo '<input class="form-check-input me-2" onchange="window.location=`controller/update.php?id=' . $data->id . '&status=' . ($data->status == 1 ? "2" : "1") . '`" type="checkbox" value="" aria-label="..." ' . ($data->status == 1 ? "" : "checked") . ' />';
                      if ($data->status == 1) {
                        echo $data->name;
                      } else {
                        echo "<s>" . $data->name . "</s>";
                      }
                      echo "</div>";
                      echo '<div><a href="index.php?id=' . $data->id . '&name=' . $data->name . '" class="btn btn-small btn-trigger p-2 me-2"><i class="fa fa-pencil-alt text-primary"></i></a><a href="controller/delete.php?id=' . $data->id . '" class="btn btn-small btn-trigger p-2"><i class="fa fa-trash text-danger"></i></a></div>';
                      echo "</li>";
                    }
                    ?>
                  </ul>
                </div>
                <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                  <ul class="list-group mb-0">
                    <?php
                    $tasks = $controller->GetTasks(2);
                    foreach ($tasks as $key => $data) {
                      echo '<li class="d-flex list-group-item d-flex align-items-center border-0 mb-2 rounded" style="background-color: #f4f6f7;justify-content: space-between;">';
                      echo '<div>';
                      echo '<input class="form-check-input me-2" onchange="window.location=`controller/update.php?id=' . $data->id . '&status=' . ($data->status == 1 ? "2" : "1") . '`" type="checkbox" value="" aria-label="..." ' . ($data->status == 1 ? "" : "checked") . ' />';
                      if ($data->status == 1) {
                        echo $data->name;
                      } else {
                        echo "<s>" . $data->name . "</s>";
                      }
                      echo "</div>";
                      echo '<div><a href="index.php?id=' . $data->id . '&name=' . $data->name . '" class="btn btn-small btn-trigger p-2 me-2"><i class="fa fa-pencil-alt text-primary"></i></a><a href="controller/delete.php?id=' . $data->id . '" class="btn btn-small btn-trigger p-2"><i class="fa fa-trash text-danger"></i></a></div>';
                      echo "</li>";
                    }
                    ?>
                  </ul>
                </div>
              </div>
              <!-- Tabs content -->

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
  <!-- End your project here-->

  <!-- MDB -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript"></script>
</body>

</html>