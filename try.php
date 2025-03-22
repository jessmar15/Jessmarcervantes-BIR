<?php
include "conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Date Range and Employee Selection</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .search-box {
      position: relative;
    }
    .search-box input[type="text"] {
      width: 100%;
      padding: 10px;
      box-sizing: border-box;
    }
    .search-box select {
      display: none;
      width: 100%;
      height: 200px;
      overflow-y: auto;
      position: absolute;
      top: 100%;
      left: 0;
      z-index: 1;
      background-color: white;
      border: 1px solid #ced4da;
      border-top: none;
    }
    .search-box select.show {
      display: block;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="my-4">Reports</h2>
  <form method="post" action="">
  <div class="row">
    <div class="form-group col-sm-4">
      <label for="employee">Search Employee:</label>
      <div class="search-box">
        <input type="text" id="searchEmployee" class="form-control" placeholder="Search employee..." autocomplete="off">
        <select name="employee" id="employee" class="form-control" required size="10">
          <option value="">--Select Employee--</option>
          <?php
          // Fetch employee list
          $stmt = $conn->query("SELECT id, firstname, lastname FROM employee ORDER BY lastname, firstname");
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['lastname']) . ", " . htmlspecialchars($row['firstname']) . "</option>";
          }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group col-sm-3">
      <label for="startDate">Start Date:</label>
      <input type="date" name="startDate" class="form-control" id="startDate" required>
    </div>
    <div class="form-group col-sm-3">
      <label for="endDate">End Date:</label>
      <input type="date" name="endDate" class="form-control" id="endDate" required>
    </div>
    <div class="form-group col-sm-2">
    <label for="button">&nbsp;</label>
      <button type="submit" class="btn btn-primary btn-block">Generate</button>
    </div>
  </div>
</form>





  <button onclick='printResults()' class='btn btn-secondary mb-2'>Print</button>
  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $employeeId = $_POST['employee'];
      $startDate = $_POST['startDate'];
      $endDate = $_POST['endDate'];

      // Fetch data based on the selected employee and date range
      $sql = "
      SELECT 
          e.firstname, e.lastname, i.date as timein_date, i.time_in, o.date as timeout_date, o.time_out
      FROM 
          employee e
      LEFT JOIN 
          timein i ON e.rfid_card = i.rfid_card AND i.date BETWEEN :startDate AND :endDate
      LEFT JOIN 
          timeout o ON e.rfid_card = o.rfid_card AND o.date BETWEEN :startDate AND :endDate
      WHERE 
          e.id = :employeeId
      ORDER BY 
          i.date, o.date";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate, 'employeeId' => $employeeId]);

      if ($stmt->rowCount() > 0) {
          // Fetch employee details for display
          $employee = $stmt->fetch(PDO::FETCH_ASSOC);
          echo "
          <div id='results'>
            <h2><center>BIR RDO 057</center></h2>
            <h6><center>Employee Timesheet</center></h6>
            <h5>Employee: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . htmlspecialchars($employee['firstname']) . " " . htmlspecialchars($employee['lastname']) . "</h5>
            <h5>Date Range: &nbsp;&nbsp;&nbsp;&nbsp;" . htmlspecialchars($startDate) . " to " . htmlspecialchars($endDate) . "</h5>
            <table class='table table-bordered mt-4'>
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                </tr>
              </thead>
              <tbody>";
          // Reset the pointer to the first result
          $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate, 'employeeId' => $employeeId]);
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "
                <tr>
                  <td>" . htmlspecialchars($row['timein_date']) . "</td>
                  <td>" . htmlspecialchars($row['time_in']) . "</td>
                  <td>" . htmlspecialchars($row['time_out']) . "</td>
                </tr>";
          }
          echo "
              </tbody>
            </table>
          </div>";
      } else {
          echo "<p class='mt-4'>No records found for the selected employee and date range.</p>";
      }
  }
  ?>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
