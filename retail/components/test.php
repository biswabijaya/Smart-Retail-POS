<?php if (isset($_POST['submit'])) {
      include 'config.php';

      $name=$_POST['name'];
      $paytm=$_POST['ptm'];
      $bug=$_POST['bug'];
		  $insertrecord = mysqli_query($mysqli, "INSERT INTO `bugs` (`id`, `name`, `paytm`, `bugs`) VALUES (NULL, '$name', '$paytm', '$bug')");

}?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Bug Bountry</title>
    <style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700);

body {
  background: white;
  color:#999;
  font-family:Roboto;
}

h1{
  font-weight:100;
  font-size:21pt;
  color:#E43;
}

p{font-weight:300;}

.warning-content {
	position:absolute;
  top:1%;
  width:100%;
  height:300px;
  text-align:center;
  margin:0;

}

input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=number], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}
</style>
  </head>
  <body>
  <div class="warning-content">
      <img src="srm.png" alt="SRM University">
  <h1>SRM University Haryana Student Portal</h1>

  <p> Students can receive Rs 10-1000 PAYTM Reward through Bug Bountry Program</p>

  <div style="margin:5%; border-radius: 5px;background-color: #f2f2f2;padding: 20px; ">

    <?php if (isset($_POST['submit'])) {
    ?>
      <p> Thank You </p>
    <?php } else {?>
    <form method="post">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" maxlength="25" placeholder="Within 25 letters">
    <label for="ptm">Paytm No. / Email id for Reward</label>
    <input type="text" id="ptm" name="ptm" maxlength="100" placeholder="+91 XXXXX XXXXX or abc@xyz.com">
    <label for="bug">Bug Details</label>
    <input type="text" id="bug" name="bug" maxlength="250" placeholder="Bug details within 50-60 words ">
    <input type="submit" value="Submit" name="submit">
    <?php } ?>
  </form>
  </div>



  </div>

  </body>
</html>
