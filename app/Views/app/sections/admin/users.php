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
        <button type="button" class="btn btn-primary modal-btn" data-toggle="modal" data-target="#staticBackdrop">User Add</button>
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

  var state = false
  //------- Document Ready -------------
  $(function() {
    $('#staticBackdrop').on('hidden', function() {
      renderCreate()
    });

    $('.custom-file-input').change(function() {
      image = this.files[0]
      name = image['name']
      type = image['type']
      size = image['size']
      formats = ['image/jpeg', 'image/png']
      //return console.log(name)
      if (type != formats[0] && type != formats[1]) {
        $('.custom-file-input').val('')
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong with the format!'
        })
      } else if (size > 2000000) {
        $('.custom-file-input').val('')
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong with size!'
        })
      } else {
        var img = new FileReader
        img.readAsDataURL(image)
        $(img).on('load', function(e) {
          var route = e.target.result
          $('#imgThumb').attr('src', route)
          $('.custom-file-label').text(name)
        })
      }
    })
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
        data: "nick",
        title: "Nickname"
      },
      {
        data: null,
        title: "Photo",
        render: function(data) {
          return `<img src='${baseUrl}${data.img}' style='width:40px' alt="text"'>`
        }
      },
      {
        data: null,
        title: "Actions",
        render: function(data) {
          return `
          <div class='text-center'>
          <div class='btn-group'>
          <button class='btn btn-warning btn-sm' onClick="fnEdit(${data.id})">
          <i class="fas fa-edit"></i>
          </button>
          <button class='btn btn-danger btn-sm' onClick="fnDelete(${data.id})">
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

  function fnDelete(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.get(baseUrl + '/api/v1/users/delete/' + id, () => {
          table.ajax.reload(null, false);
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        });
      }
    })
  }
  var state = false;
  $('#form-main').submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: baseUrl + "/api/v1/users",
      data: new FormData(this),
      processData: false,
      contentType: false,
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
              field = $('#fEmail')
              field.addClass('is-invalid')
              html = `<div class="invalid-feedback">
                ${key[val]}
              </div>`
              field.closest('div').append(html);
            } else if (val === 'username') {
              state = true
              field = $('#fNick')
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

  function fnEdit(id) {
    $.ajax({
      type: "GET",
      url: baseUrl + "/api/v1/users/show/" + id,
      success: function(response) {
        user = response.data
        renderEdit(user)
        $('#staticBackdrop').modal('show')
      }
    });
  }

  $('.modal-btn').on('click', function() {
    renderCreate()
    $('#staticBackdrop').modal('show')
  });

  function renderEdit(data) {
    submit = $('.submit').text('Update').removeClass('btn-primary').addClass('btn-warning to-update')
    title = $('.modal-title').text('Edit User')
    header = $('.modal-header').css({
      background: '#ffc107',
      color: '#000'
    })
    $('.invalid-feedback').remove()
    name = $('#iName').val(data.name)
    surname = $('#iSurname').val(data.surname)
    email = $('#fEmail').val(data.email)
    username = $('#fNick').val(data.nick)
    pass = $('#fPass').val('').prop('placeholder', 'Password')
    image = $('#fImage').val('')
    label = $('.custom-file-label').text('Choose Image...')
    thumb = $('#imgThumb').prop('src', data.img)
    state = true
  }

  function renderCreate(data) {
    
    submit = $('.submit').text('Create').removeClass('btn-warning').addClass('btn-primary')
    title = $('.modal-title').text('Create User')
    header = $('.modal-header').css({
      background: '#007bff',
      color: '#fff'
    })
    $("form input").removeClass("is-invalid");
    $('.invalid-feedback').remove()
    state = false
    name = $('#iName').val('').prop('placeholder', 'Name')
    surname = $('#iSurname').val('').prop('placeholder', 'Surname')
    email = $('#fEmail').val('').prop('placeholder', 'Email')
    username = $('#fNick').val('').prop('placeholder', 'Nick')
    pass = $('#fPass').val('').prop('placeholder', 'Password')
    image = $('#fImage').val('')
    label = $('.custom-file-label').text('Choose Image...')
    thumb = $('#imgThumb').prop('src', '/img/default/profile.jpg')
  }

  function update(){

  }
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
        <form id="form-main" autocomplete="off">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="iName">Name</label>
              <input type="text" class="form-control" id="iName" name="name">
            </div>
            <div class="form-group col-md-6">
              <label for="iSurname">Surname</label>
              <input type="text" class="form-control" id="iSurname" name="surname">
            </div>
          </div>
          <div class="form-group">
            <label for="inputAddress2">Email</label>
            <input type="email" class="form-control" id="fEmail" name="email">
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Nickname</label>
              <input type="text" class="form-control" id="fNick" name="username" >
            </div>
            <div class="form-group col-md-6">
              <label for="fPass">Password</label>
              <input type="password" class="form-control" id="fPass" name="password" >
            </div>
          </div>
          <div class="custom-file my-2">
            <input accept="image/*" type="file" class="custom-file-input" id="fImage" name="image">
            <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
          </div>
          <img src="img/default/profile.jpg" id="imgThumb" class="rounded mx-auto d-block" alt="Responsive image" style="width:100px">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary submit">Understood</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>