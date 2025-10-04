<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendace System</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/favicon.png'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css'); ?>" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-4 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body" id="card-body">
                                <form id="form-search" method="POST" action="">
                                    <div style="margin-bottom: 40px;">
                                        <h3 class="fw-bold text-center">Attendance System</h3>
                                    </div>
                                    <div class="mb-4">
                                        <label for="employee_id" class="form-label">Employee ID</label>
                                        <input type="text" name="employee_id" class="form-control" id="employee_id" autocomplete="off" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label">Description (Optional)</label>
                                        <textarea rows="3" style="resize: none;" name="description" class="form-control" id="description" autocomplete="off"></textarea>
                                    </div>

                                    <button id="scan-qrcode" type="button" class="btn btn-success w-100 py-8 fs-4 mb-2 rounded-2" data-bs-toggle="modal" data-bs-target="#scanModal">
                                        <i class="ti ti-barcode"></i>
                                        <span>Scan QRcode</span>
                                    </button>
                                    <!-- Scan QRcode Modal -->
                                    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="addModalLabel">Scan QRcode</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="scan-qrcode-container"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button id="btn-submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
                                        <?= $this->include('components/spinner'); ?>
                                        <div id="text">
                                            <i class="ti ti-send"></i>
                                            <span>Submit</span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <style>
        #scan-qrcode-container {
            width: 100% !important;
            height: 300px !important;
            overflow: hidden;
            position: relative;
        }

        #scan-qrcode-container video,
        #scan-qrcode-container canvas {
            width: 100% !important;
            height: 300px !important;
            object-fit: cover;
            /* agar video tidak melar */
        }
    </style>

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

    <script>
        let html5QrcodeScanner

        $(function() {
            // Scan QRcode
            $('#scan-qrcode').on('click', function() {
                html5QrcodeScanner = new Html5Qrcode("scan-qrcode-container");

                const config = {
                    fps: 10,
                    qrbox: 300
                };

                html5QrcodeScanner.start({
                        facingMode: "environment"
                    },
                    config,
                    qrCodeMessage => {
                        // Scan Success
                        $('#employee_id').val(qrCodeMessage)
                        $('.modal').modal('hide')
                        html5QrcodeScanner.stop()
                    },
                    errorMessage => {}
                ).catch(err => {
                    if (err.name === "NotAllowedError" || err.name === "PermissionDeniedError") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Camera permission denied!',
                            timer: 2000
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to access camera!',
                            timer: 2000
                        })
                    }
                })
            })

            $('#scanModal').on('hidden.bs.modal', function() {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop()
                }
            })
        })

        // Check Employee ID
        $('#form-search').on('submit', function(e) {
            e.preventDefault()

            const formData = new FormData(e.target)

            $.ajax({
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: () => {
                    $('#btn-submit').find('#spinner').show()
                    $('#btn-submit').find('#text').hide()
                    $('#btn-submit').prop('disabled', true)
                },
                complete: () => {
                    $('#btn-submit').find('#spinner').hide()
                    $('#btn-submit').find('#text').show()
                    $('#btn-submit').prop('disabled', false)
                },
                success: (response) => {
                    if (response?.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response?.message,
                            timer: 2000
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response?.message,
                            timer: 2000
                        })
                    }
                },
                error: (e) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                        timer: 2000
                    })
                }
            })
        })
    </script>
</body>

</html>