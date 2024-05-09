@include('admin.include.header')
<title>
 Add Data
</title>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary text-white-all">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Dashboard </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#"> Add New Game </a></li>
            </ol>
        </nav>
          <div class="section-body">
                <div class="card">
                  <form id="data_store">
                    <div class="card-header bg-primary">
                      <h4 class="text-white">About add game </h4>
                    </div>
                    <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="city" class="text-dark mt-1"> Name   <span class="text-danger">*</span></label>
                            <input type="text" name="Name" class="form-control">
                        </div>
                       
                        <div class="col-md-6">
                            <label for="city" class="text-dark mt-1"> Open time   <span class="text-danger">*</span></label>
                      
                             <input type="time" id="timeInput" onchange="displayAMPM()" class="form-control">
                             <p id="result" ></p>
                                                    </div>
                       
                      
                       
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
 
<script>
  function displayAMPM() {
      // Get the value of the time input
      const timeInput = document.getElementById("timeInput");
      const selectedTime = timeInput.value;

      // Convert the time to AM/PM format
      const timeArray = selectedTime.split(":");
      let hours = parseInt(timeArray[0], 10);
      const minutes = timeArray[1];

      const ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12; // Handle midnight (12:00 AM)

      // Display the result
      const resultElement = document.getElementById("result");
      resultElement.textContent = ` ${hours}:${minutes} ${ampm}`;
  }
</script>

 <script>
    $('#data_store').on('submit', function(e) {
        e.preventDefault()
        let fd = new FormData(this);
        fd.append('_token', "{{ csrf_token() }}");
        let ampmValue = document.getElementById('result').innerText;
          fd.append('time', ampmValue);  
        $.ajax({
            url: "{{ route('admin.add_game') }}",
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
