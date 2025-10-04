<?= $this->extend('layouts/main'); ?>

<?= $this->section('container'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Employee</h5>

                    <?= $this->include('pages/admin/employee/create'); ?>
                </div>

                <div class="mt-4 table-responsive">
                    <table id="table" class="table  table-striped text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Employee ID</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Name</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Address</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Action</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $i => $row) { ?>
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0"><?= ++$i; ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0"><?= $row['employee_id']; ?></h6>
                                        <span class="fw-normal"><?= $row['departement']['departement_name']; ?></span>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1"><?= $row['name']; ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal"><?= $row['address']; ?></p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <?= view('pages/admin/employee/qrcode', [
                                            'data' => $row
                                        ]); ?>

                                        <?= view('pages/admin/employee/edit', [
                                            'data' => $row
                                        ]); ?>

                                        <!-- Delete Button -->
                                        <button
                                            title="Delete Data"
                                            class="btn btn-sm btn-danger"
                                            onclick="Swal.fire({
                                                title: 'Are you Sure?',
                                                icon: 'question',
                                                text: 'Data will be deleted.',
                                                showCancelButton: true
                                            }).then((e) => {
                                                if ( e.isConfirmed ) {
                                                    window.location.href = '<?= base_url('admin/employee/delete/' . $row['id']); ?>'
                                                }
                                            })">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(function() {
        const table = new DataTable('#table', {
            ordering: false
        })
    })
</script>
<?= $this->endSection(); ?>