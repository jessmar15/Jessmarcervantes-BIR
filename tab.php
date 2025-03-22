<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Time Selection</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Add your custom styles here */
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
        border-radius: 10px;
        padding: 20px;
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
        background-color: #dee2e6;
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
      <ul class="nav nav-tabs">
        <li class="nav-item col-6 text-center">
          <a class="nav-link active" data-toggle="tab" href="#timeIn">Time In</a>
        </li>
        <li class="nav-item col-6 text-center">
          <a class="nav-link" data-toggle="tab" href="#timeOut">Time Out</a>
        </li>
      </ul>
      <div class="tab-content">
        <div id="timeIn" class="tab-pane fade show active"><br>
          <h3>Time In</h3>
            <form>
                <div class="form-group">
                    <label for="rfidInput">RFID Card:</label>
                    <input type="text" class="form-control" id="myTextbox" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div id="timeOut" class="tab-pane fade"><br>
          <h3>Time Out</h3>
          <form>
                <div class="form-group">
                    <label for="rfidInput">RFID Card:</label>
                    <input type="text" class="form-control" id="myTextbox" autocomplete="off">
                </div>
                <button type="hidden" class="btn btn-primary" value="submit">Submit</button>
            </form>
        </div>
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
    document.getElementById("myTextbox").focus();
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

</body>
</html>
