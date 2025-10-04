<button title="Show QRcode" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#qrcode-modal-<?= $data['id'] ?>">
    <i class="ti ti-qrcode"></i>
</button>

<!-- QRcode Modal -->
<div class="modal fade" id="qrcode-modal-<?= $data['id']; ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">QRcode</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 d-flex justify-content-center">
                    <?php
                    $qrcode = new \SimpleSoftwareIO\QrCode\BaconQrCodeGenerator();
                    ?>
                    <div>
                        <?= $qrcode->size(300)->generate($data['employee_id']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>