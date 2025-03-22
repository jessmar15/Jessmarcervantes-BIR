<?php
include "conn.php";
include 'session.php';

if (isset($_GET['id'])) {
    // Retrieve the ID from the URL parameter
    $id = $_GET['id'];

    // Prepare and execute the SQL statement to fetch the row with the given ID
    $sql = "SELECT * FROM employee WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Fetch the row as an associative array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

} else {
    echo "ID parameter is missing in the URL.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIR Attendance Monitoring</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    /* Add your custom styles here */
    body {
      padding-top: 56px; /* Adjust according to your navbar height */
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
overflow-x:hidden;
    }
    .side-nav {
      height: 100%;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1;
      background: #fff;
      box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
      backdrop-filter: blur( 19px );
      -webkit-backdrop-filter: blur( 19px );
      border-radius: 10px;
      border: 1px solid rgba( 255, 255, 255, 0.18 );
      padding-top: 60px; /* Adjust according to your navbar height */
    }
    .side-nav .nav-link {
      color: #000; /* White text color for side nav links */
    }
    .side-nav .nav-link:hover {
      background-color: #74b7ff; /* Darken background color on hover */
      color: #fff;
      border-radius: 30px 0px 0px 30px;
    }
    .side-nav .nav-link.active {
      background-color: #74b7ff; /* Active color for the current page */
      color: #fff !important; /* White text color for active link */
      border-radius: 30px 0px 0px 30px;
    }
    .main-content {
position: relative;
left:8%;
      padding: 20px;
    }
    .navbar {
      background:  #007bff;
      backdrop-filter: blur( 20px );
      -webkit-backdrop-filter: blur( 20px );
      border: 1px solid rgba( 255, 255, 255, 0.18 );
    }
    .navbar-brand b{
      color: #fff; /* Dark text color for navbar brand */
    }
    .navbar-nav .nav-link {
      color: #fff; /* Dark text color for navbar links */
    }
    .navbar-nav .nav-link:hover {
      color: #fff; /* Primary color for navbar links on hover */
    }
    input[readonly] {
    color: #555; /* Change text color */
    cursor: not-allowed; /* Change cursor */
    /* You can add more styles as needed */
}
  </style>
</head>
<body>
  
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="#"><b>BIR RDO 057</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto"><li class="nav-item">
          <a class="nav-link" href="#" style="color: #fff;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
          </svg>
          <i>&nbsp;<?php echo $_SESSION['username']; ?></i></a>
        </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <li class="nav-item">
          <a class="nav-link" href="#" style="color: #fff;"><b>
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
          </svg>
          &nbsp;Logout</b></a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Side Navigation -->
  <div class="side-nav">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-speedometer2" viewBox="0 2 16 16">
          <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
          <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3"/>
        </svg>&nbsp;&nbsp;&nbsp;
      Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="employee.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard" viewBox="0 2 16 16">
          <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5"/>
          <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z"/>
        </svg>&nbsp;&nbsp;&nbsp;
        Employee</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="records.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar3" viewBox="0 2 16 16">
          <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
          <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
        </svg>&nbsp;&nbsp;&nbsp;
        Records</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="reports.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-download" viewBox="0 2 16 16">
          <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
          <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
        </svg>&nbsp;&nbsp;&nbsp;
        Reports</a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container">
      <h2>Employee Details</h2><br>
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
          <div class="card-body">
    <h5 class="card-title">Personal Details</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Employee RFID Number</label>
                <input type="text" class="form-control" value="<?php echo $row["rfid_card"]; ?>" id="formGroupExampleInput2" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Department</label>
                <input type="text" class="form-control" value="<?php echo $row["department"]; ?>" id="formGroupExampleInput2" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Firstname</label>
                <input type="text" class="form-control" value="<?php echo $row["firstname"]; ?>" id="formGroupExampleInput2" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Middlename</label>
                <input type="text" class="form-control" value="<?php echo $row["middlename"]; ?>" id="formGroupExampleInput2" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Lastname</label>
                <input type="text" class="form-control" value="<?php echo $row["lastname"]; ?>" id="formGroupExampleInput2" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Age</label>
                <input type="text" class="form-control" value="<?php echo $row["age"]; ?>" id="formGroupExampleInput2" readonly>
            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="employee.php"><button class="btn btn-primary">&nbsp;Back</button></a>
    </div>
</div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
