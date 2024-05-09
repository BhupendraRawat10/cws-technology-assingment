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
                <li class="breadcrumb-item active" aria-current="page"><a href="#"> Edit Game   </a></li>
            </ol>
        </nav>
          <div class="section-body">
                <div class="card">
                  <form id="petrolpump_store">
                    <input type="text" name="id" id="" value="{{$data->id}}" hidden>
                    <div class="card-header bg-primary">
                      <h4 class="text-white"> Edit Game  </h4>
                    </div>
                    <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="ro_code" class="text-dark">Game Name  <span class="text-danger">*</span> </label>
                            {{-- <input name="game_name" type="text" class="form-control" placeholder=" " value="{{$data->game_fk_id }}"> --}}
                            <select class="form-control" id="dropdown" name="game_name">
                              @foreach ($game as $game)
                                  <option value="{{ $game->id }}" {{ $game->id == $data->game_fk_id ? 'selected' : '' }}>
                                      {{ $game->name }}
                                  </option>
                              @endforeach
                          </select>
                          
                        </div>
                        <div class="col-md-6">
                          <label for="name" class="text-dark"> Result <span class="text-danger">*</span></label>
                          <input name="Result" type="text" class="form-control"  min="2000" max="2099" value="{{$data->result}}">

                      </div>
                        <div class="col-md-6">
                          <label for="name" class="text-dark"> Date <span class="text-danger">*</span></label>
                          <input name="date" type="date" class="form-control"  min="2000" max="2099" value="{{$data->date }}">

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
    $('#petrolpump_store').on('submit', function(e) {
        e.preventDefault()
        let fd = new FormData(this);
        fd.append('_token', "{{ csrf_token() }}");
        $.ajax({
            url: "{{ route('update_GameResult_data') }}",
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
