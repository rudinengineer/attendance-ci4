<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    <i class="ti ti-plus"></i>
    <span>Create Employee</span>
</button>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Create Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 form-group">
                    <label for="departement_id" class="form-label">Departement</label>
                    <select name="departement_id" id="departement_id" required class="form-select">
                        <option disabled selected>Select Departement</option>
                        <?php foreach ($departement as $row) { ?>
                            <option value="<?= $row['id']; ?>"><?= $row['departement_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3 form-group">
                    <label for="employee_id" class="form-label">Employee ID</label>
                    <input type="number" name="employee_id" id="employee_id" autocomplete="off" required class="form-control">
                </div>
                <div class="mb-3 form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" autocomplete="off" required class="form-control">
                </div>
                <div class="mb-3 form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea style="resize: none;" rows="3" name="address" id="address" autocomplete="off" required class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>