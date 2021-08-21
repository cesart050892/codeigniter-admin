<?= $this->extend('app/layout/auth') ?>

<?= $this->section('title') ?>
<title> ERP | Login </title>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<body class="hold-transition login-page">
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<style>
  body {
    /* background: #3a7bd5 !important;
    background-image: -webkit-radial-gradient(bottom, circle cover, #00d2ff 0%, #3a7bd5 80%) !important; */
    background: rgb(40, 80, 150);
    background: radial-gradient(circle, rgba(40, 80, 150, 1) 0%, rgba(0, 50, 120, 1) 90%);
    /* background: linear-gradient(rgba(0, 0, 0, 1), rgba(0, 30, 50, 1)) !important; */

    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
  }

  .bg-img__ {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: url('../utils/img/login-page.jpg');
    background-size: cover;
    overflow: hidden;
    z-index: -1;
  }

  .loader-container {
    width: 100%;
    height: 100vh;
    position: fixed;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .loader {
    width: 50px;
    height: 50px;
    border: 5px solid;
    color: #3a7bd5;
    border-radius: 50%;
    border-top-color: transparent;
    animation: loader 1s linear infinite;
  }

  @keyframes loader {
    0% {
      color: #181818;
    }

    50% {
      color: #2d88c3;
    }

    75% {
      color: #f7b017;
    }

    100% {
      color: #ec3b1f;
    }

    to {
      transform: rotate(360deg);
    }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form autocomplete="off">
                    <div class="input-group mb-3">
                        <input type="user" class="form-control" placeholder="User">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
<?= $this->endSection() ?>