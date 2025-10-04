<?= $this->extend('layouts/main'); ?>

<?= $this->section('container'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Departement</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="ti ti-plus"></i>
                        <span>Create Departement</span>
                    </button>

                    <!-- Add Modal -->
                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="" class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addModalLabel">Create Departement</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 form-group">
                                        <label for="name" class="form-label">Departement Name</label>
                                        <input type="text" name="name" id="name" autocomplete="off" required class="form-control">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="max_clock_in_time" class="form-label">Max Clock In Time</label>
                                        <input type="time" name="max_clock_in_time" id="max_clock_in_time" autocomplete="off" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="max_clock_in_out" class="form-label">Max Clock In Out</label>
                                        <input type="time" name="max_clock_in_out" id="max_clock_in_out" autocomplete="off" required class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-4 table-responsive">
                    <table id="table" class="table  table-striped text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Departement Name</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Max Clock In Time</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Max Clock In Out</h6>
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
                                        <h6 class="fw-semibold mb-1"><?= $row['departement_name']; ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal"><?= date_format(date_create($row['max_clock_in_time']), 'H:i'); ?></p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal"><?= date_format(date_create($row['max_clock_in_out']), 'H:i'); ?></p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <button title="Edit Data" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit-modal-<?= $row['id'] ?>">
                                            <i class="ti ti-pencil"></i>
                                        </button>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit-modal-<?= $row['id']; ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" action="<?= base_url('admin/departement/update/' . $row['id']); ?>" class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="addModalLabel">Edit Departement</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3 form-group">
                                                            <label for="name" class="form-label">Departement Name</label>
                                                            <input type="text" name="name" id="name" autocomplete="off" required class="form-control" value="<?= $row['departement_name']; ?>">
                                                        </div>
                                                        <div class="mb-3 form-group">
                                                            <label for="max_clock_in_time" class="form-label">Max Clock In Time</label>
                                                            <input type="time" name="max_clock_in_time" id="max_clock_in_time" autocomplete="off" required class="form-control" value="<?= date_format(date_create($row['max_clock_in_time']), 'H:i'); ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="max_clock_in_out" class="form-label">Max Clock In Out</label>
                                                            <input type="time" name="max_clock_in_out" id="max_clock_in_out" autocomplete="off" required class="form-control" value="<?= date_format(date_create($row['max_clock_in_out']), 'H:i'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

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
                                                    window.location.href = '<?= base_url('admin/departement/delete/' . $row['id']); ?>'
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