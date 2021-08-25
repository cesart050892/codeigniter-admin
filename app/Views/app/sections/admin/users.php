<?= $this->extend('app/layout/main') ?>

<?= $this->section('title') ?>
<title>AdminLTE 3 | Users Admin</title>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- DataTables-->
<link rel="stylesheet" type="text/css" href="<?= base_url('plugins/datatables-min/css/datatables.min.css') ?>" />
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
<style>
  /* table {
    cursor: pointer;
  } */
  .selected-row {
    font-weight: 700;
    /* text-transform: uppercase; */
    /* cursor: auto; */
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users Admin</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Users Admin</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">User Add</button>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <table id="table1" class="table table-hover table-bordered table-striped display nowrap" style="width:100%">
        </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        Footer
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- DataTables  & Plugins -->
<script type="text/javascript" src="<?= base_url('plugins/datatables-min/js/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('plugins/datatables-min/js/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('plugins/datatables-min/js/datatables.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
  //------- Document Ready -------------
  $(function() {

  });

  //------- DataTable -------------

  var table = $("#table1").DataTable({
    ajax: {
      type: "GET",
      url: baseUrl + '/api/v1/users',
      dataSrc: function(response) {
        return response.data;
      },
    },
    columns: [
      // { data: "id", title: "Id" },
      {
        data: null,
        title: "Users",
        render: function(data) {
          return `${data.fullname}`;
        },
      },
      {
        data: "username",
        title: "Nickname"
      },
      {
        data: null,
        title: "Photo",
        render: function(data) {
          return `<img src='${baseUrl}${data.img}' style='width:40px'>`
        }
      },
      {
        data: null,
        title: "Actions",
        render: function(data) {
          return `
          <div class='text-center'>
          <div class='btn-group'>
          <button class='btn btn-warning btn-sm' onClick="btnEdit(${data.id})">
          <i class="fas fa-edit"></i>
          </button>
          <button class='btn btn-danger btn-sm' onClick="btnDelete(${data.id})">
          <i class="fas fa-trash"></i>
          </button>
          </div>
          </div>`;
        },
      },
    ],
    columnDefs: [{
      className: "text-center select-checbox",
      targets: "_all",
    }, ],
    language: {
      url: baseUrl + "/utils/spanish.json"
    },
    responsive: true,
  });

  //------- Functions -------------

  function renderModal() {
    $('.modal-header').css({
      'background': '#3c8dbc',
      'color': white
    })
  }
  var state = false;
  $('form').submit(function(e) {
    e.preventDefault();
    data = $(this).serialize();
    data += `&pass_confirm=${$('#inputPassword4').val()}`
    $.ajax({
      type: "POST",
      url: baseUrl + "/api/auth/signup",
      data: data,
      dataType: "json",
      success: function(response) {
        $('#staticBackdrop').modal('hide')
        table.ajax.reload(null, false);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        let key = xhr.responseJSON.messages
        if (!state) {
          for (const val in key) {
            if (val === 'email') {
              state = true
              field = $('#inputAddress2')
              field.addClass('is-invalid')
              html = `<div class="invalid-feedback">
                ${key[val]}
              </div>`
              field.closest('div').append(html);
            } else if (val === 'username') {
              state = true
              field = $('#inputEmail4')
              field.addClass('is-invalid')
              html = `<div class="invalid-feedback">
                ${key[val]}
              </div>`
              field.closest('div').append(html);
            } else {
              console.log('error in database')
            }
          }
        }
      }
    });
  });
</script>
<?= $this->endSection() ?>


<?= $this->section('modal') ?>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #3c8dbc; color : white">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="iName">Name</label>
              <input type="text" class="form-control" id="iName" name="name" value="Jose Antonio">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Surname</label>
              <input type="text" class="form-control" id="iSurname" name="surname" value="Perez Padro">
            </div>
          </div>
          <div class="form-group">
            <label for="inputAddress2">Email</label>
            <input type="email" class="form-control" id="inputAddress2" name="email" value="prdprz@email.com">
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Nickname</label>
              <input type="text" class="form-control" id="inputEmail4" name="username" value="presc">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Password</label>
              <input type="password" class="form-control" id="inputPassword4" name="password" value="admin">
            </div>
          </div>
          <div class="custom-file my-2">
            <input type="file" class="custom-file-input" id="validatedCustomFile" required="">
            <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
          </div>
          <img src="img/default/profile.jpg" class="rounded mx-auto d-block" alt="Responsive image" style="width:200px">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Understood</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>