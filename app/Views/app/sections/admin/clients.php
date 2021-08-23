<?= $this->extend('app/layout/main') ?>

<?= $this->section('title') ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
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
          <h1>Blank Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
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
        <h3 class="card-title">Title</h3>

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
  const baseUrl = window.location.origin;
  console.log(baseUrl)
  let table = $("#table1").DataTable({
    language: {
      url: baseUrl + "/utils/spanish.json"
    },
    ajax: {
      type: "GET",
      url: baseUrl + '/api/v1/clients',
      dataSrc: function(response) {
        return response.data;
      },
    },
    columnDefs: [{
      className: "text-center select-checbox",
      targets: "_all",
    }, ],
    columns: [
      // { data: "id", title: "Id" },
      {
        data: null,
        title: "Client",
        render: function(data) {
          return `${data.fullname}`;
        },
      },
      {
        data: "email-personal",
        title: "Email"
      },
      {
        data: "phone-personal",
        title: "Phone"
      },
      {
        data: null,
        title: "Actions",
        render: function(data) {
          return `
          <div class='text-center'>
          <div class='btn-group'>
          <button class='btn btn-primary btn-sm' onClick="btnProfile(${data.id})">
          <i class="fas fa-binoculars"></i>
          </button>
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
    responsive: true,
    select: true,
    select: {
      style: 'single',
      blurable: true,
      className: "selected-row"
    }
  });
</script>
<?= $this->endSection('script') ?>