<?php

include "conn.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIR</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  
  <style>
    /* Add your custom styles here */
    body{
        background-image: url('img/mybg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: 'Poppins', sans-serif;
    }
    .tabcontent {
      display: none;
      padding: 20px;
      border-top: 1px solid #dee2e6;
    }
    .tabcontent.active {
      display: block;
    }
    .container{
        border: 2px solid #dee2e6;
        padding: 20px;
        background: rgba( 255, 255, 255, 0.8 );
        box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
        backdrop-filter: blur( 8.5px );
        -webkit-backdrop-filter: blur( 8.5px );
        border-radius: 10px;
        border: 1px solid rgba( 255, 255, 255, 0.18 );
    }
    .containers{
        padding: 20px;
        background: #fff#FFFFFF00;
        width: 50%;
    }
    #clock {
      text-align: center;
      font-size: 36px;
      margin-bottom: 20px;
    }
    .date {
      text-align: center;
      font-size: 20px;
      margin-bottom: 20px;
    }
    .timeDate{
        width: 25%;
        border-radius: 10px;
    }
  </style>
</head>
<body>

<br>

<div class="container">
<?php
// Set the timezone to Philippines
date_default_timezone_set('Asia/Manila');

// Get the current date
$currentDate = date('Y-m-d');

// Format the date
$formattedDates = date("l - F j, Y", strtotime($currentDate));

// Display the current date

?>

    <center>
    <div class="timeDate text-center">
        <div id="clock"></div>
        <div class="date"><?php echo $formattedDates; ?></div>
    </div>
    </center>

  <div class="row">
    <div class="col">
        <a href="index.php"><button type="button" class="btn btn-secondary">Time In</button></a>
        <a href="indexout.php"><button type="button" class="btn btn-primary">Time Out</button></a>
        <br><br>
        <h4>Time Out</h4>
            <form  method="post" action="">
                <div class="form-group">
                    <label for="rfidInput">RFID Card:</label>
                    <input type="text" name="rfid_card_timeout" class="form-control" id="myTextboxIn" autocomplete="off">
                </div>
            </form>
    </div>
  </div>
</div><br>

<?php

// Time Out
if (isset($_POST['rfid_card_timeout'])) {
    $rfid_card = $_POST['rfid_card_timeout'];

    if (empty($rfid_card)) {
        die("RFID card value is required.");
    }

    // Step 1: Check if there is a corresponding record in the timein table for the given rfid_card and date
    $checkTimeInStmt = $conn->prepare('SELECT COUNT(*) FROM timein WHERE rfid_card = :rfid_card AND date = :date');
    $checkTimeInStmt->execute([
        'rfid_card' => $rfid_card,
        'date' => date('Y-m-d')
    ]);
    $timeInExists = $checkTimeInStmt->fetchColumn();

    if ($timeInExists) {
        // Step 2: Find the employee with the given RFID card
        $stmt = $conn->prepare('SELECT id FROM employee WHERE rfid_card = :rfid_card');
        $stmt->execute(['rfid_card' => $rfid_card]);
        $employee = $stmt->fetch();

        if ($employee) {
            $employee_id = $employee['id'];
            $date = date('Y-m-d');
            $time_out = date('H:i:s');

            // Step 3: Check if an entry already exists for the same rfid_card and date in the timeout table
            $checkStmt = $conn->prepare('
                SELECT COUNT(*) FROM timeout WHERE rfid_card = :rfid_card AND date = :date
            ');

            $checkStmt->execute([
                'rfid_card' => $rfid_card,
                'date' => $date
            ]);

            $existingEntries = $checkStmt->fetchColumn();

            if ($existingEntries == 0) {
                // Step 4: Insert the date, time, and rfid_card into the timeout table
                $insertStmt = $conn->prepare('
                    INSERT INTO timeout (rfid_card, date, time_out)
                    VALUES (:rfid_card, :date, :time_out)
                ');

                $insertStmt->execute([
                    'rfid_card' => $rfid_card,
                    'date' => $date,
                    'time_out' => $time_out
                ]);

            } else {
                echo "
                <center>
                <div class='containers'>
                <div class='alert alert-danger d-flex align-items-center' role='alert'>
                    <div>
                        Time-in for this RFID card has already been recorded.
                    </div>
                </div>
                </div>
                </center>
                ";
            }
        } else {
            echo "
            <center>
            <div class='containers'>
            <div class='alert alert-danger d-flex align-items-center' role='alert'>
                <div>
                    Employee not found for the provided RFID card.
                </div>
            </div>
            </div>
            </center>
            ";
        }
    } else {
        echo "
        <center>
            <div class='containers'>
            <div class='alert alert-danger d-flex align-items-center' role='alert'>
                <div>
                    No time-in record found for this RFID card today.
                </div>
            </div>
            </div>
            </center>";
    }
}
?>


<div class="container">
<div class="row">

        <div class="col-xl-12">

          <div class="card">
            <div class="card-body">
            <h6 class="card-title">Today's Logged</h6>

            <?php

// Assuming the database connection is established and stored in $conn

// Fetch services
$sql = "SELECT 
            CONCAT(e.firstname, ' ', e.lastname) AS fullname,
            e.department,
            i.time_in,
            o.time_out
        FROM 
            employee e
        LEFT JOIN 
            timein i ON e.rfid_card = i.rfid_card AND i.date = CURDATE()
        LEFT JOIN 
            timeout o ON e.rfid_card = o.rfid_card AND o.date = CURDATE()
        WHERE 
            i.time_in IS NOT NULL
        ORDER BY 
            o.time_out DESC";

$stmt = $conn->prepare($sql);

// Error handling to check if the query preparation was successful
if (!$stmt) {
    die("Query preparation failed: " . $conn->errorInfo()[2]);
}

$stmt->execute();

// Check for execution errors
if ($stmt->errorCode() != '00000') {
    die("Query execution failed: " . $stmt->errorInfo()[2]);
}

if ($stmt->rowCount() > 0) {
    echo "<table id='myTable' class='table'>";
    echo "
        <tr>
            <th>Full Name</th>
            <th>Department</th>
            <th>Time In</th>
            <th>Time Out</th>
        </tr>
    ";


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $timein = $row['time_in'] ? date('h:i:s A', strtotime($row['time_in'])) : 'N/A';
        $timeout = $row['time_out'] ? date('h:i:s A', strtotime($row['time_out'])) : 'N/A';

        echo "<tr>
                <td>" . htmlspecialchars($row["fullname"]) . "</td>
                <td>" . htmlspecialchars($row["department"]) . "</td>
                <td>" . htmlspecialchars($timein) . "</td>
                <td>" . htmlspecialchars($timeout) . "</td>
              </tr>";

    }
    echo "</table>";
} else {
    echo "
    <table id='myTable' class='table'>
    <tr>
        <th>Full Name</th>
        <th>Department</th>
        <th>Time In</th>
        <th>Time Out</th>
    </tr>
    <tr>
      <td>--</td>
      <td>--</td>
      <td>--</td>
      <td>--</td>
    </tr>";
}

?>


            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="previousPage()">Previous</a>
                    </li>
                    <li class="page-item" id="pageNumbers"></li>
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="nextPage()">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
      </div>
    </div>
</div>


<!-- Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  // Activate the first tab by default
  $(document).ready(function(){
    $('.nav-tabs a:first').tab('show');
  });
</script>

<script>
  // Focus on the text box when the page loads
  window.onload = function() {
    document.getElementById("myTextboxIn").focus();
  };
</script>

<script>
    function updateClock() {
      var now = new Date();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds();
      var ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12;
      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;
      var time = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
      document.getElementById('clock').innerText = time;
      setTimeout(updateClock, 1000);
    }
    updateClock();
  </script>

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



</body>
</html>
