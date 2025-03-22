<?php

include 'conn.php';
include 'session.php';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
$success = isset($_SESSION['success']) ? $_SESSION['success'] : "";
$edited = isset($_SESSION['edited']) ? $_SESSION['edited'] : "";


// Clear the session variables
unset($_SESSION['error']);
unset($_SESSION['success']);
unset($_SESSION['edited']);


    if (!empty($error) || !empty($edited)) {
         echo "<script>";
            if (!empty($edited)) {
                echo "Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Service successfully edited!',
                    showConfirmButton: false,
                    timer: 2000
                });";
            }
        echo "</script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIR Attendance Monitoring</title>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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
position:relative;
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
        <a class="nav-link " href="dashboard.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-speedometer2" viewBox="0 2 16 16">
          <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
          <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3"/>
        </svg>&nbsp;&nbsp;&nbsp;
      Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="employee.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard" viewBox="0 2 16 16">
          <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5"/>
          <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z"/>
        </svg>&nbsp;&nbsp;&nbsp;
        Employee</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="records.php">
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
      <h2>All Employee Records</h2>
      <div class="row">

<div class="container mt-5">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="startDate">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
            </div>
            <div class="form-group col-md-4">
                <label for="endDate">End Date</label>
                <input type="date" class="form-control" id="endDate" name="endDate" required>
            </div>
            <div class="form-group col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </div>
        </div>
    </form>

    <button onclick='printResults()' class='btn btn-secondary mb-4'>Print</button>

    <?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['startDate']) && isset($_POST['endDate'])) {
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];

  // Fetch data based on the selected date range
  $sql = "
  SELECT 
      e.firstname, e.lastname, i.date as timein_date, i.time_in, o.time_out
  FROM 
      employee e
  LEFT JOIN 
      timein i ON e.rfid_card = i.rfid_card AND i.date BETWEEN :startDate AND :endDate
  LEFT JOIN 
      timeout o ON e.rfid_card = o.rfid_card AND o.date = i.date
  WHERE 
      (i.date IS NOT NULL OR o.date IS NOT NULL)
  ORDER BY 
      i.date";

  $stmt = $conn->prepare($sql);
  $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);

  if ($stmt->rowCount() > 0) {
      echo "
      <div id='results'>
        <h2><center>BIR RDO 057</center></h2>
        <h6><center>All Employee Timesheet from " . htmlspecialchars($startDate) . " to " . htmlspecialchars($endDate) . "</center></h6>
        <table class='table table-bordered mt-4'>
          <thead>
            <tr>
              <th>Employee</th>
              <th>Date</th>
              <th>Time In</th>
              <th>Time Out</th>
            </tr>
          </thead>
          <tbody>";
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $time_in = $row['time_in'] ? date('h:i:s A', strtotime($row['time_in'])) : 'N/A';
          $time_out = $row['time_out'] ? date('h:i:s A', strtotime($row['time_out'])) : 'N/A';

          echo "
            <tr>
              <td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td>
              <td>" . htmlspecialchars($row['timein_date']) . "</td>
              <td>" . htmlspecialchars($time_in) . "</td>
              <td>" . htmlspecialchars($time_out) . "</td>
            </tr>";
      }
      echo "
          </tbody>
        </table>
      </div>";
  } else {
      echo "<p class='mt-4'>No records found for the selected date range.</p>";
  }
}
?>

</div>
    </div>

    </div>
  </div>

  <!-- Bootstrap JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    var currentPage = 0;
    var rowsPerPage = 10;
    var table = document.getElementById("myTable");
    var rows = table.getElementsByTagName("tr");

    function showPage(page) {
        var start = page * rowsPerPage + 1;
        var end = start + rowsPerPage;

        for (var i = 1; i < rows.length; i++) {
            if (i >= start && i < end) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }

    function nextPage() {
        if ((currentPage + 1) * rowsPerPage < rows.length - 1) {
            currentPage++;
            showPage(currentPage);
            updatePagination();
        }
    }

    function previousPage() {
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage);
            updatePagination();
        }
    }

    function updatePagination() {
    var totalPages = Math.ceil((rows.length - 1) / rowsPerPage);
    var paginationHTML = "";

    var startPage = Math.max(0, currentPage - 4);
    var endPage = Math.min(startPage + 9, totalPages - 1);

    for (var i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            paginationHTML += "<li class='page-item active'><a class='page-link' href='#' onclick='goToPage(" + i + ")'>" + (i + 1) + "</a></li>";
        } else {
            paginationHTML += "<li class='page-item'><a class='page-link' href='#' onclick='goToPage(" + i + ")'>" + (i + 1) + "</a></li>";
        }
    }

    document.getElementById("pageNumbers").innerHTML = paginationHTML;
}


    function goToPage(page) {
        currentPage = page;
        showPage(currentPage);
        updatePagination();
    }

    function searchFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    showPage(currentPage);
    updatePagination();

    //delete button
    document.querySelectorAll(".delete-button").forEach(button => {
    button.addEventListener("click", function() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Get the ID of the row to be deleted from the data-id attribute of the button
                let deleteId = button.getAttribute('data-id');
                
                // Make an AJAX request to the PHP script
                fetch('employee_delete.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        delete_id: deleteId
                    }),
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "success") {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your data has been deleted.",
                            icon: "success"
                        }).then(() => {
                            // Optionally, reload the page or update the UI
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to delete the data.",
                            icon: "error"
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: "Error!",
                        text: "An error occurred while deleting the data.",
                        icon: "error"
                    });
                });
            }
        });
    });
});


    //to clear search text
    document.getElementById('clearSearch').addEventListener('click', function() {
    document.getElementById('searchInput').value = '';
    location.reload();
    });

</script>

<script>
  $(document).ready(function() {
    $('#searchEmployee').on('focus', function() {
      $('#employee').addClass('show');
    }).on('blur', function() {
      setTimeout(function() {
        $('#employee').removeClass('show');
      }, 200);
    }).on('keyup', function() {
      var searchText = $(this).val().toLowerCase();
      $('#employee option').each(function() {
        var optionText = $(this).text().toLowerCase();
        if (optionText.indexOf(searchText) > -1) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });

    $('#employee').on('change', function() {
      var selectedOption = $(this).find('option:selected');
      $('#searchEmployee').val(selectedOption.text());
      $('#employee').removeClass('show');
    });
  });

  function printResults() {
    var printContents = document.getElementById('results').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
  }
</script>
</body>
</html>
