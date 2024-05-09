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
                <li class="breadcrumb-item active" aria-current="page"><a href="#"> About Game Result </a></li>
            </ol>
        </nav>
          <div class="section-body">
                <div class="card">
                  <form id="data_store">
                    <div class="card-header bg-primary">
                      <h4 class="text-white">About Game Result </h4>
                    </div>
                    <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="city" class="text-dark mt-1"> Select Game   <span class="text-danger">*</span></label>
                            <select class="form-control" id="dropdown" name="game_fk_id">
                              <option value="">Select Game</option>
                              @foreach ($game as $game)
                                  <option value="{{ $game->id }}">{{ $game->name }}</option>
                              @endforeach
                          </select>
                          
                        </div>
                       
                        <div class="col-md-6">
                            <label for="city" class="text-dark mt-1"> Result   <span class="text-danger">*</span></label>
                            <input type="text" name="Result" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="text-dark mt-1"> Date   <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control">
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
    $('#data_store').on('submit', function(e) {
        e.preventDefault()
        let fd = new FormData(this);
        fd.append('_token', "{{ csrf_token() }}");
        $.ajax({
            url: "{{ route('add_GameResult') }}",
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
