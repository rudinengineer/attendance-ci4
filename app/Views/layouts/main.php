<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendace System</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/favicon.png'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css'); ?>" />

    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">

    <?= $this->renderSection('style'); ?>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <?= $this->include('components/sidebar'); ?>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <?= $this->include('components/navbar'); ?>
            <!--  Header End -->

            <?= $this->renderSection('container'); ?>

        </div>
    </div>

    <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/sidebarmenu.js'); ?>"></script>
    <script src="<?= base_url('assets/js/app.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/apexcharts/dist/apexcharts.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/simplebar/dist/simplebar.js'); ?>"></script>
    <script src="<?= base_url('assets/js/dashboard.js'); ?>"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Datatable -->
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (session('success')) { ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= session('success'); ?>',
                timer: 2500
            })
        </script>
    <?php } ?>

    <?php if (session('error')) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= session('error'); ?>',
                timer: 2500
            })
        </script>
    <?php } ?>

    <?= $this->renderSection('script'); ?>
</body>

</html>