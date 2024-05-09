@include('admin.include.header')
<title>
 Add Data
</title>
<style>
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
  .col-md-6{
    margin-top:10px;
  }

  input[type="radio"]:checked + label {
    background-color: #4CAF50;
    color: white;
  }
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary text-white-all">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Dashboard </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#"> Edit User   </a></li>
            </ol>
        </nav>
          <div class="section-body">
                <div class="card">
                  <form id="datastore">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" name="id" id="" value="{{$data->id}}" hidden>
                    <div class="card-header bg-primary">
                      <h4 class="text-white"> Edit User  </h4>
                    </div>
                    <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="ro_code" class="text-dark">First Name  <span class="text-danger"></span> </label>
                            <input name="first_name" type="text" class="form-control" placeholder=" " value="{{$data->name}}">
                        </div>
                        <div class="col-md-6">
                          <label for="name" class="text-dark">Last Name <span class="text-danger"></span></label>
                          <input name="last_name" type="text" class="form-control"  min="2000" max="2099" value="{{$data->last_name}}">

                      </div>
                        <div class="col-md-6">
                            <label for="ro_code" class="text-dark">Phone Number  <span class="text-danger"></span> </label>
                            <input name="phone_number" id="phone_number" type="text" class="form-control" placeholder=" " value="{{$data->phone_number}}">
                        </div>
                        <div class="col-md-6">
                          <label for="name" class="text-dark">Dob  <span class="text-danger"></span></label>
                          <input type="date" class="form-control" id="dob" name="dob" value="{{$data->dob}}">

                      </div>
                        <div class="col-md-6">
                            <label for="ro_code" class="text-dark">Email  <span class="text-danger"></span> </label>
                            <input name="email" type="text" class="form-control" placeholder=" " value="{{$data->email}}">
                        </div>
                        <div class="col-md-6">
                          <label for="name" class="text-dark">Address  <span class="text-danger"></span></label>
                      <textarea name="address" id="" cols="30" rows="5">{{$data->address}}</textarea>

                      </div>
                      <div class="col-md-6">
                        <label for="ro_code" class="text-dark">Resume  <span class="text-danger"></span> </label>
                        <input type="file" class="form-control" id="resume_upload" name="resume_upload" accept=".docx,.pdf" value="{{$data->resume}}">
                    </div>
                
                  <div class="col-md-6">
                    <label for="image">Image:</label>
                    <input type="file" id="imageInput" class="form-control" accept="image/jpeg, image/png" onchange="handleImageSelect(event)" />
                    <br>
                    <img id="croppedImage" src="#" alt="Cropped Image"  name="image" style="display: none;">
                  </div>
                  <label class="gender mt-3">Gender:</label>
                  <input type="radio" id="male" name="gender" value="male" {{$data->gender === 'male' ? 'checked' : ''}}>
                  <label for="male">Male</label>
                  
                  <input type="radio" id="female" name="gender" value="female" {{$data->gender === 'female' ? 'checked' : ''}}>
                  <label for="female">Female</label>
                  
                  <input type="radio" id="other" name="gender" value="other" {{$data->gender === 'other' ? 'checked' : ''}}>
                  <label for="other">Other</label>
                        <div class="col-md-6 mt-4">
                          <button class="btn btn-primary px-4 mt-3"> Submit </button>
                        </div>
                    </div>
                    </div>
                  </form>
                </div>
          </div>
        </section>
 @include('admin.include.footer')
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
 <script>
  $('#datastore').on('submit', function(e) {
      e.preventDefault()
      let fd = new FormData(this);
      fd.append('_token', "{{ csrf_token() }}");
      $.ajax({
          url: "{{ route('admin.update') }}",
          type: "POST",
          data: fd,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function(result) {
              if (result.status) {
                  iziToast.success({
                      message: result.message,
                      position: 'topRight'
                  });
                  setTimeout(function() {
                      window.location.href = result.location;
                  }, 2000);
              } else {
                  iziToast.warning({
                      message: result.message,
                      position: 'topRight'
                  });
              }
          },
          error: function(jqXHR, exception) {}
      });
  });
</script>
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
    $('#datastore').on('submit', function(e) {
      e.preventDefault();
      let fd = new FormData(this);
      $("#load").show();
      if (cropper) {
        var canvas = cropper.getCroppedCanvas();
        canvas.toBlob(function(blob) {
          fd.append('croppedImage', blob);
          $.ajax({
            url: "{{ route('admin.update') }}",
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
  // Get all radio buttons
  const radioButtons = document.querySelectorAll('input[type="radio"][name="gender"]');
  
  // Add event listener to each radio button
  radioButtons.forEach(button => {
    button.addEventListener('change', function() {
      // Check if any radio button is selected
      const anySelected = [...radioButtons].some(button => button.checked);
      
      // If any radio button is selected, do something (e.g., alert)
   
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
