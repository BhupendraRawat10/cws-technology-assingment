<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Form</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
  }
  
  .container_data {
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  label {
    display: block;
    margin-bottom: 8px;
  }

  input[type="text"],
  input[type="email"],
 
  input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  input[type="file"]{
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  textarea{
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  input[type="radio"] {
    display: none;
  }

  input[type="radio"] + label {
    display: inline-block;
    margin-right: 10px;
    padding: 8px 16px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
  }

  input[type="radio"]:checked + label {
    background-color: #4CAF50;
    color: white;
  }

  input[type="submit"] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 15px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  input[type="submit"]:hover {
    background-color: #45a049;
  }
  #load {
    display: none; /* Hide the loader by default */
    /* Add other styles like position, background, color, etc. */
}

</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
</head>
@include('include.header')
<body>
  <div id="load">Loading...</div>

<div class="container_data">
  <h2>Registration Form</h2>

  <form id="form_submit">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
      <div class="col-md-6">
        <label for="first_name">First Name:</label>
        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter The First Name" required>
      </div>
      <div class="col-md-6">
        <label for="last_name">Last Name:</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter the Last Name" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <label for="phone_number">Phone  Number:</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter the Phone Number" required>
      </div>
      <div class="col-md-6">
        <label for="dob">Dob:</label>
        <input type="date" class="form-control" id="dob" name="dob" required>
      </div>
    </div>
    
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter the email Id " required>

    
    <label for="email">Address:</label>
    <textarea name="address" id="address" cols="30" rows="5" class="textdata" placeholder="Enter the address" required></textarea>

    <div class="row">
      <div class="col-md-6">
        <label for="resume_upload">Resume upload:</label>
        <input type="file" class="form-control" id="resume_upload" name="resume_upload" accept=".docx,.pdf" required>
      </div>
      <div class="col-md-6">
        <label for="image">Image:</label>
        <input type="file" id="imageInput" class="form-control" accept="image/jpeg, image/png" onchange="handleImageSelect(event)" required>
        <img id="croppedImage" style="display: none;">
      </div>
    </div>
    <label class="gender">Gender:</label>
    <input type="radio" id="male" name="gender" value="male" >
    <label for="male">Male</label>
  
    <input type="radio" id="female" name="gender" value="female" >
    <label for="female">Female</label>
  
    <input type="radio" id="other" name="gender" value="other" >
    <label for="other">Other</label>

    <input type="submit" value="Submit">
    
  </form>
</div>
@include('include.footer');

 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

 <script>
   var cropper;
 
   function handleImageSelect(event) {
     var input = event.target;
     var file = input.files[0];
 
     if (file) {
       if (file.size <= 2 * 1024 * 1024 && (file.type === 'image/jpeg' || file.type === 'image/png')) {
         var reader = new FileReader();
 
         reader.onload = function (e) {
           var image = document.getElementById('croppedImage');
           image.style.display = 'block';
           image.src = e.target.result;
 
           if (cropper) {
             cropper.replace(e.target.result);
           } else {
             cropper = new Cropper(image, {
               aspectRatio: 1,
               viewMode: 1,
               autoCropArea: 1,
               crop: function(event) {
                 console.log(event.detail.x);
                 console.log(event.detail.y);
                 console.log(event.detail.width);
                 console.log(event.detail.height);
               }
             });
           }
         };
 
         reader.readAsDataURL(file);
       } else {
         alert('Please select a JPG or PNG image within 2MB.');
         resetImage();
       }
     }
   }
 
   function resetImage() {
     document.getElementById('imageInput').value = '';
     document.getElementById('croppedImage').style.display = 'none';
     if (cropper) {
       cropper.destroy();
     }
   }
 
   $(function() {
     $('#form_submit').on('submit', function(e) {
       e.preventDefault();
       let fd = new FormData(this);
       $("#load").show();
       if (cropper) {
         var canvas = cropper.getCroppedCanvas();
         canvas.toBlob(function(blob) {
           fd.append('croppedImage', blob);
           $.ajax({
             url: "{{ route('register_submit') }}",
             type: "POST",
             data: fd,
             dataType: 'json',
             processData: false,
             contentType: false,
             beforeSend: function() {
               $("#load").show();
             },
             success: function(result) {
               if (result.status) {
                 iziToast.success({
                   message: result.message,
                   position: 'topRight'
                 });
                 $("#load").hide();
                 setTimeout(function() {
                   window.location.href = result.location;
                 }, 2000);
               } else {
                 iziToast.warning({
                   message: result.message,
                   position: 'topRight'
                 });
                 $("#load").hide();

               }
             },
             complete: function() {
               $("#load").hide();
             },
             error: function(jqXHR, exception) {}
           });
         });
       }
     });
   });
 </script>
 

 <script>
  document.getElementById('resume_upload').addEventListener('change', function() {
      var file = this.files[0];
      var fileSize = file.size;
      var fileType = file.type;
      var validFileTypes = ["application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf"];
      var maxSize = 2 * 1024 * 1024; // 2MB in bytes

      if (!validFileTypes.includes(fileType)) {
          alert('Invalid file format. Please upload a Docx or Pdf file.');
          this.value = ''; 
      } else if (fileSize > maxSize) {
          alert('File size exceeds the maximum limit of 2MB.');
          this.value = '';
      }
  });
</script>
 <script>
  var dobInput = document.getElementById('dob');
  
  dobInput.addEventListener('change', function() {
    var selectedDate = new Date(this.value);
    var currentDate = new Date();
    
    var minDate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());
    
    if (selectedDate > minDate) {
      alert("You must be at least 18 years old to submit the form.");
      dobInput.value = ''; 
    }
  });

  document.getElementById('dobForm').addEventListener('submit', function(event) {
    var selectedDate = new Date(dobInput.value);
    var currentDate = new Date();
    var minDate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());
    
    if (selectedDate > minDate) {
      event.preventDefault();
      alert("You must be at least 18 years old to submit the form.");
      dobInput.value = ''; 
    }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var phoneNumberInput = document.getElementById("phone_number");
  
    phoneNumberInput.addEventListener("input", function(event) {
      var formattedPhoneNumber = phoneNumberInput.value.replace(/\D/g, '');
      
      if (formattedPhoneNumber.length > 10) {
        formattedPhoneNumber = formattedPhoneNumber.slice(0, 10);
      }
  
      phoneNumberInput.value = formattedPhoneNumber;
    });
  });
  </script>

</body>
</html>
