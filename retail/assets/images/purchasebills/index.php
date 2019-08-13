<?php
include '../../../shopdb.php';

if (!isset($_SESSION['id'])) {
  header("Location: ../../");
}
if (isset ($_GET['width'])) {
    $width=$_GET['width'];
} else {
    $width=200;
}

if (isset ($_GET['height'])) {
    $height=$_GET['height'];
} else {
    $height=200;
}

if (isset ($_GET['name'])) {
    $name=$_GET['name'];
} else {
    $name=time();
}

if (isset ($_GET['dimention'])) {
    $dimention=$_GET['dimention'];
} else {
    $dimention="square";
}

if (isset ($_GET['format'])) {
    $format=$_GET['format'];
} else {
    $format="png";
}
?>

<html>
    <head>
        <title>Upload Image</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../favicon.png" />
        <link rel="icon" href="../../favicon.png" type="image/x-icon">


		<script src="https://youthubaalfoundation.org/account/assets/imageuploader/jquery.min.js"></script>
		<script src="https://youthubaalfoundation.org/account/assets/imageuploader/bootstrap.min.js"></script>
		<script src="https://youthubaalfoundation.org/account/assets/imageuploader/croppie.js"></script>
		<link rel="stylesheet" href="https://youthubaalfoundation.org/account/assets/imageuploader/bootstrap.min.css" />
		<link rel="stylesheet" href="https://youthubaalfoundation.org/account/assets/imageuploader/croppie.css" />
    </head>
    <body>
        <div class="container">
          <br />
      <h3 align="center">Upload Image</h3>
      <br />
      <br />
			<div class="panel panel-default">
  				<div class="panel-heading">Image Upload and Update</div>
  				<div class="panel-body" align="center">
  					<input type="file" name="upload_image" id="upload_image" />
  					<br />

  					<div id="earlier_image">
  					    <?php if(isset($_GET['name'])){
  					        echo '<img src="'.$_GET['name'].'.'.$format.'" class="img-thumbnail" />';
  					    }

  					    ?>
  					</div>
  					<div id="uploaded_image"></div>
  					<br/>
  					<a href="javascript:history.go(-1)"><button class="btn btn-success" onclick="">Go Back</button></a>
  				</div>
  			</div>
  		</div>
    </body>
</html>

<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog" style=" <?php if(isset($_GET['width']) and $_GET['width']>600)  echo 'width: auto; margin: auto;'; ?> ">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Upload & Crop Image</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-12 text-center">
						  <div id="image_demo" style="width:100%; height: auto;" ></div>
  					</div>
  					<div class="col-md-12 text-center">
						  <button class="btn btn-success crop_image">Crop & Upload Image</button>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
    </div>
</div>

<script>
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:<?php echo $width; ?>,
      height:<?php echo $height; ?>,
      type:'<?php echo $dimention; ?>' //circle
    },
    boundary:{
      width: <?php echo $width+100; ?>,
      height:<?php echo $height+100; ?>
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php?name=<?php echo $name; ?>&format=<?php echo $format; ?>",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#earlier_image').hide();
          $('#uploaded_image').html("<h3>Processing....</h3>");
          window.setTimeout(function(){location.reload()},1000);
        }
      });
    })
  });

});
</script>
