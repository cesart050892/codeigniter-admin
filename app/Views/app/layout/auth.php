<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->renderSection('title') ?>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <?= $this->renderSection('css') ?>
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <?= $this->renderSection('style') ?>
</head>
<?= $this->renderSection('body') ?>
<?= $this->renderSection('content') ?>

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('js') ?>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<?= $this->renderSection('script') ?>
</body>

</html>