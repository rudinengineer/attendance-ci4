<?php $request = \Config\Services::request(); ?>
<?= $this->extend('layouts/main'); ?>

<?= $this->section('container'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Report Attendance</h5>
                    <div class="w-100 d-flex justify-content-end">
                        <form action="" method="get" class="d-flex gap-2 align-items-center">
                            <div>
                                <input name="date" type="date" value="<?= $request->getGet('date') ? htmlspecialchars($request->getGet('date')) : date('Y-m-d'); ?>" class="form-control form-control-sm">
                            </div>
                            <div>
                                <select name="departement_id" class="form-select form-select-sm">
                                    <option disabled selected>Select Departement</option>
                                    <?php foreach ($departement as $row) { ?>
                                        <option value="<?= $row['id']; ?>" <?= $request->getGet('departement_id') == $row['id'] ? 'selected' : ''; ?>><?= $row['departement_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-success">apply</button>
                            </div>
                        </form>
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
                                    <h6 class="fw-semibold mb-0">Attendance ID</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Employee ID</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Employee</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Clock In</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Clock Out</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Total Work Hours</h6>
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
                                        <h6 class="fw-semibold mb-1"><?= $row['attendance_id']; ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1"><?= $row['employee']['employee_id']; ?></h6>
                                        <span class="fw-normal"><?= $row['employee']['departement']['departement_name']; ?></span>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1"><?= $row['employee']['name']; ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1">
                                            <div><?= date_format(date_create($row['clock_in']), 'H:i:s'); ?></div>
                                            <div><?= date_format(date_create($row['clock_in']), 'd-m-Y'); ?></div>
                                        </h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1">
                                            <?php if ($row['clock_out']) { ?>
                                                <div><?= date_format(date_create($row['clock_out']), 'H:i:s'); ?></div>
                                                <div><?= date_format(date_create($row['clock_out']), 'd-m-Y'); ?></div>
                                            <?php } else { ?>
                                                <span>-</span>
                                            <?php } ?>
                                        </h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <?php
                                        $start = new \DateTime($row['clock_in']);
                                        $end = new \DateTime($row['clock_out']);
                                        $total_work_hours = "";

                                        if ($row['clock_out']) {
                                            $diff = $start->diff($end);
                                            if ($diff->h > 0) {
                                                $total_work_hours = $diff->h . ' jam ';
                                            } else if ($diff->i) {
                                                $total_work_hours .= $diff->i . ' menit ';
                                            } else if ($diff->s) {
                                                $total_work_hours = $diff->s . ' detik';
                                            } else {
                                                $total_work_hours = '-';
                                            }
                                        } else {
                                            $total_work_hours = '-';
                                        }
                                        ?>
                                        <h6 class="fw-semibold mb-1"><?= $total_work_hours; ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <a href="<?= base_url('admin/report/' . $row['attendance_id']); ?>">
                                            <button title="History" class="btn btn-sm btn-success">
                                                <i class="ti ti-history"></i>
                                            </button>
                                        </a>
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