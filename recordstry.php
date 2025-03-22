<?php
include "conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Date Range Selection</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <h2 class="my-4">Select Date Range</h2>
  <form method="post" action="">
    <div class="form-group">
      <label for="startDate">Start Date:</label>
      <input type="date" name="startDate" class="form-control" id="startDate" required>
    </div>
    <div class="form-group">
      <label for="endDate">End Date:</label>
      <input type="date" name="endDate" class="form-control" id="endDate" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $startDate = $_POST['startDate'];
      $endDate = $_POST['endDate'];

      // Fetch data based on the selected date range
      $sql = "
      SELECT 
          e.firstname, e.lastname, i.date as timein_date, i.time_in, o.date as timeout_date, o.time_out
      FROM 
          employee e
      LEFT JOIN 
          timein i ON e.rfid_card = i.rfid_card AND i.date BETWEEN :startDate AND :endDate
      LEFT JOIN 
          timeout o ON e.rfid_card = o.rfid_card AND o.date BETWEEN :startDate AND :endDate
      ORDER BY 
          e.lastname, e.firstname, i.date, o.date";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);

      if ($stmt->rowCount() > 0) {
          echo "
          <table class='table table-bordered mt-4'>
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Time In Date</th>
                <th>Time In</th>
                <th>Time Out Date</th>
                <th>Time Out</th>
              </tr>
            </thead>
            <tbody>";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "
              <tr>
                <td>" . htmlspecialchars($row['firstname']) . "</td>
                <td>" . htmlspecialchars($row['lastname']) . "</td>
                <td>" . htmlspecialchars($row['timein_date']) . "</td>
                <td>" . htmlspecialchars($row['time_in']) . "</td>
                <td>" . htmlspecialchars($row['timeout_date']) . "</td>
                <td>" . htmlspecialchars($row['time_out']) . "</td>
              </tr>";
          }
          echo "
            </tbody>
          </table>";
      } else {
          echo "<p class='mt-4'>No records found for the selected date range.</p>";
      }
  }
  ?>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
