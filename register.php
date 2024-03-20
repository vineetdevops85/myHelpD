<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $team_name = $_POST['team_name'];
    $created_at = date('Y-m-d H:i:s'); // Current timestamp

    // Insert the new team member into the users table
    $sql = "INSERT INTO users (username, email, password, role, team_name,  created_at) VALUES ('$username', '$email', '$password', '$role', '$team_name', '$created_at')";

    if ($conn->query($sql) === TRUE) {
      $successMessage = "Team Member added successfully";
    } else {
      $errorMessage = "Something went wrong, please contact Admin";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>RuangAdmin - Register</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Register Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                  </div>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" id="username" name="username" required placeholder="Enter Full Name">
                    </div>
                    <!-- <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" class="form-control" id="exampleInputLastName" placeholder="Enter Last Name">
                    </div> -->
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" id="email" name="email" required aria-describedby="emailHelp"
                        placeholder="Enter Email Address">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label>Team Name</label>
                      <select id="team_name" name="team_name" required class="form-control">
                        <option value="T3">Tier-3</option>
                        <option value="T4">Tier-4</option>
                    </select>
                    <div class="form-group">
                      <label>Role</label>
                      <select id="role" name="role" required class="form-control">
                        <option value="admin">Admin</option>
                        <option value="customer">Normal</option>
                    </select>
                    </div>
                    <?php
                    // Display success or error message
                    if (!empty($successMessage)) {
                        echo "<p class='alert alert-success'>$successMessage</p>";
                    } elseif (!empty($errorMessage)) {
                        echo "<p class='alert alert-danger'>$errorMessage</p>";
                    }
                    ?>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" value="Register">Register</button>
                    </div>
                    <hr>
                    <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Register with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small" href="login.html">Already have an account?</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Register Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>