@include('admin.include.header')
<title>
  Customer DataTable
</title>
<style>
  /* Remove background opacity of modal backdrop */
.modal.fade .modal-backdrop.show {
    opacity: 0;
}

</style>
<!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb bg-primary text-white-all">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Dashboard </a>
                  </li>
              </ol>
          </nav>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h4 class="text-white"> User Details</h4>
                    <div class="card-header-action">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="recentWorksTable">
                        <thead>
                          <tr>
                            <th>S No.</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Dob</th>
                            <th>Gender</th>
                            <th>Resume Download</th>
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
          <!-- Modal -->


        </section>
        <!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- User details will be populated here -->
      </div>
    </div>
  </div>
</div>
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
                url: "{{ route('admin.index') }}",
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
                  {
                      "width": "10%",
                      "targets": 4,
                      "name": "action",
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
                    content: 'Sure you want to delete this User Data ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                              url: "{{ route('admin.delete_user') }}",
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
            $('body').on("click", ".mydatashow", function(e) {
    var id = $(this).data('id');

    // Send AJAX request to fetch user details
    $.ajax({
        url: "{{ route('admin.showdata') }}",
        type: 'POST',
        data: {id: id, _token: '{{ csrf_token() }}'},
        dataType: "JSON",
    })
    .done(function(result) {
        if (result.status) {
            // Open modal and populate with user details
            openUserModal(result.user);
        } else {
            iziToast.error({
                message: result.message,
                position: 'topRight'
            });
        }
    })
    .fail(function(jqXHR, exception) {
        console.log(jqXHR.responseText);
    });
});

function openUserModal(userDetails) {
    // Populate modal with user details
    $('#userModal').modal('show');
    
    var modalContent = `
        <table class="table">
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Profile</td>
                <td><img src="public/${userDetails.image}" alt="User Image" width="80"></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td>${userDetails.name}</td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td>${userDetails.last_name}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>${userDetails.email}</td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td>${userDetails.phone_number}</td>
            </tr>
            <tr>
                <td>Date Of Birth</td>
                <td>${userDetails.dob}</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>${userDetails.gender}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>${userDetails.address}</td>
            </tr>
        </table>
    `;
    
    $('#userModal .modal-body').html(modalContent);
}




  });
</script>

