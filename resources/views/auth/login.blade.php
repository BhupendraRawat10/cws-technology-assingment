<title>
  Login Page
</title>
{{-- @include('include.header'); --}}
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/app.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/bundles/bootstrap-social/bootstrap-social.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">

  <link rel="stylesheet" href="{{ asset('public/assets/bundles/izitoast/css/iziToast.min.css') }}">

  {{-- <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' /> --}}
</head>
<section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <form id="form_submit">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                
               
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
@include('include.footer');
<script>
    $(function() {
        $('#form_submit').on('submit', function(e) {
            e.preventDefault();
            let fd = new FormData(this);
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('login_submit') }}",
                type: "POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("#load").show();
                },
                success: function(result) {
                    console.log(result);
                    if (result.status) {
                        iziToast.success({
                            message: result.msg,
                            position: 'topRight'
                        });

                        setTimeout(function() {
                            window.location.href = result.location;
                        }, 500);

                    } else {
                        iziToast.error({
                            message: result.msg,
                            position: 'topRight'
                        });
                    }
                },
                complete: function() {
                    $("#load").hide();
                },
                error: function(jqXHR, exception) {}
            });
        })
    });
</script>