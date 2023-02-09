<!DOCTYPE html>
<html>
  <head>
    <style>
	div.round2 {
  border: 2px solid black;
  border-radius: 8px;
  padding: 15px;
  margin: auto;
  width: 65%;
}

.counter-container {
        display: inline-block;
        vertical-align: top;
        margin: 20px;
      }
      .green {
        color: green;
      }
      .grey {
        color: grey;
      }
	.center {
  margin: auto;
  width: 50%;
  padding: 10px;
}
    </style>
  </head>
  <body>
    <?php
      // Connect to database
	  
	  $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "counter_db";

      $conn = new mysqli($servername, $username, $password, $dbname);


      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
		
      // Retrieve counter statuses from database
      $sql = "SELECT counter_id,curr, status FROM counters";
      $result = $conn->query($sql);
      $counters = array();
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $counters[$row["counter_id"]] = $row["status"];
        }
      }
		
      // Update counter status if a form was submitted
      if (isset($_POST["counter_id"]) && isset($_POST["status"])) {
        $counter_id = $_POST["counter_id"];
        $status = $_POST["status"];
        $sql = "UPDATE counters SET status='$status' WHERE counter_id='$counter_id'";
        $conn->query($sql);
        $counters[$counter_id] = $status;
      }
    ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container" ><div class = "round2">
  <div class="row">
    
	 <?php
	  if (isset($_POST["take_number"])) {
      // Retrieve current ticket from database
      $sql = "SELECT last FROM tickets";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $last = $row["last"];
        }
      } else {
        echo "No data found";
      }

      // Increment current ticket by 1
      $last++;

      // Update current ticket in database
      $sql = "UPDATE tickets SET last = $last";
      mysqli_query($conn, $sql);
    }

			// Retrieve current ticket and latest serving ticket from database
    $sql = "SELECT last, latest FROM tickets";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $last = $row["last"];
        $latest = $row["latest"];
      }
    } else {
      echo "No data found";
    }


    mysqli_close($conn);
   ?>
    <div class="center">
	
	
	
   <div class="col" >
     <h4>Current serving number: <?php echo $last; ?></span></h4>
    <h4>Latest serving number: <?php echo $latest; ?></span></h4>
	<br>
    <form method="post" class="center">
          <input  type="submit" name="take_number" value="Take Number">
    </form><br><br><br>
    </div>
	
	<?php 

                                                    /* Attempt MySQL server connection. Assuming you are running MySQL*/
                                                    $link = mysqli_connect("localhost", "root", "", "counter_db");
                                                            
                                                    // Check connection
                                                    if($link == false){
                                                        die("ERROR: Could not connect. ".mysqli_connect_error());
                                                    }

                                                    $sql = "SELECT curr, counter_id, status from counters";
                                                    $result = $link-> query($sql);
                                               

                                                                while($row = $result -> fetch_assoc()){

                                                                   
                                                                    $curr = $row['curr'];
																	$counter_id = $row['counter_id'];
																	$status = $row['status'];
                                                                   
                                                            ?>

															Counter <?php echo $counter_id ?>:
													 
													<span class="<?php echo $status == "online" ? "green" : "grey" ?>">
														<?php echo $status ?></span> 
														<p> Current Number  : <?php echo $curr ?> </p>

																<?php }

                                                //close connection
                                               mysqli_close($link);
                                                
                                                ?>
		
		
	</div></div >
	
	
	</div>
       
    </div>
    

  
  
<br><br>
  


    <!-- Display counter statuses and buttons -->
	<div class="center"><div class="round2">
    <?php foreach ($counters as $counter_id => $status): ?>
      <div>
        Counter <?php echo $counter_id ?>:
        <span class="<?php echo $status == "online" ? "green" : "grey" ?>">
          <?php echo $status ?>
        </span>
        <form method="post">
          <input type="hidden" name="counter_id" value="<?php echo $counter_id ?>">
          <input type="hidden" name="status" value="<?php echo $status == "online" ? "offline" : "online" ?>">
          <input type="submit" value="<?php echo $status == "online" ? "Go Offline" : "Go Online" ?>">
		  <input type="submit" name="counter1CompCurr" value="Complete Current Task">
        <br>
        <input type="submit" name="counter1CallNext" value="Call Next">
        </form>
      </div>
    <?php endforeach; ?>
	</div>
	</div>
      
    
	