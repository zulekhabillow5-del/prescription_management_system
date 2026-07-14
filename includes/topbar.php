<div class="bg-white shadow-sm rounded-4 p-4 mb-4">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold mb-1">
                <?= isset($pageTitle) ? $pageTitle : "Dashboard"; ?>
            </h2>

            <p class="text-muted mb-0">
                Welcome back,
                <strong><?= htmlspecialchars($_SESSION['doctor_name']); ?></strong>
            </p>

        </div>

        <div class="d-flex align-items-center">

            <div class="me-4">

                <i class="bi bi-bell fs-3 text-primary"></i>

            </div>

            <div class="text-end">

                <h5 class="mb-0 fw-bold">
                    <?= htmlspecialchars($_SESSION['doctor_name']); ?>
                </h5>

                <small class="text-muted">
                    Doctor
                </small>

            </div>

        </div>

    </div>

</div>