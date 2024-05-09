@include('admin.include.header')
<title>
  Customer DataTable
</title>
<!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb bg-primary text-white-all">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Dashboard </a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user-friends"></i> About Game Details </li>
              </ol>
          </nav>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h4 class="text-white"> About Game Details</h4>
                    <div class="card-header-action">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="recentWorksTable">
                        <thead>
                          <tr>
                            <th>S No.</th>
                            <th>Game</th>
                            <th>Time</th>
                            <th>Status</th>
                  
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      
          </div>
        </section>
@include('admin.include.footer')

<script>
  $(function() {
      $.fn.tableload = function() {
          $('#recentWorksTable').dataTable({
              "scrollX": true,
              "processing": true,
              pageLength: 10,
              "serverSide": true,
              "bDestroy": true,
              'checkboxes': {
                  'selectRow': true
              },
              "ajax": {
                url: "{{ route('admin.show_all_game_data') }}",
                  "type": "POST",
                  "data": function(d) {
                      d._token = "{{ csrf_token() }}";
                  },
                  dataFilter: function(data) {
                      var json = jQuery.parseJSON(data);
                      json.recordsTotal = json.recordsTotal;
                      json.recordsFiltered = json.recordsFiltered;
                      json.data = json.data;
                      return JSON.stringify(json);;
                  }
              },
              "order": [
                  [0, 'DESC']
              ],
              "columns": [
                  {
                      "width": "10%",
                      "targets": 0,
                      "name": "id",
                      'searchable': true,
                      'orderable': true
                  },
            
                {
                    "width": "10%",
                    "targets": 2,
                    "name": "ro_code",
                    'searchable': true,
                    'orderable': true
                },
             
                  {
                      "width": "10%",
                      "targets": 3,
                      "name": "city",
                      'searchable': true,
                      'orderable': true
                  },
                  {
                      "width": "10%",
                      "targets": 3,
                      "name": "city",
                      'searchable': true,
                      'orderable': true
                  },
                  {
                      "width": "10%",
                      "targets": 4,
                      "name": "action",
                      'searchable': true,
                      'orderable': true
                  },
              ]
          });
      }
      $.fn.tableload();
      $('body').on("click", ".customerDelete", function(e) {
                var id = $(this).data('id');
                let fd = new FormData();
                // console.log(id);
                fd.append('id', id);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to delete this data ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                              url: "{{ route('admin.delete_game') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        iziToast.success({
                                        message: result.message,
                                        position: 'topRight'
                                    });

                                        setTimeout(function(){
                                          $.fn.tableload();
                                          // window.location.reload();
                                        }, 2000);
                                    } else {
                                        toast.error(result.msg);
                                    }
                                })
                                .fail(function(jqXHR, exception) {
                                    console.log(jqXHR.responseText);
                                })
                        },
                        no: function() {},
                    }
                })
            });
  });
</script>
<script>

  $(document).ready(function () {


    $('body').on("click", ".checkboxdata", function(e) {
                var id = $(this).data('id');
                let fd = new FormData();
                // console.log(id);
                fd.append('id', id);
                fd.append('_token', '{{ csrf_token() }}');
           
                            $.ajax({
                              url: "{{ route('admin.checkboxdata') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        iziToast.success({
                                        message: result.message,
                                        position: 'topRight'
                                    });

                                        setTimeout(function(){
                                          $.fn.tableload();
                                          // window.location.reload();
                                        }, 2000);
                                    } else {
                                        toast.error(result.msg);
                                    }
                                })
                                .fail(function(jqXHR, exception) {
                                    console.log(jqXHR.responseText);
                                })
                      
                 
            });
            });
</script>
