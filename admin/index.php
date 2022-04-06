<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/session.php"; global $_USER; ?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/header.php"; ?>

<br>
<div class="container">
    <h1>Welcome back <?= $_USER ?>!</h1>
    <br>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">PluralKit</h4>
                    <p class="card-text">Configure PluralKit system ID.</p>
                    <a href="/admin/pluralkit" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Projects</h4>
                    <p class="card-text">Add, edit, delete or showcase projects.</p>
                    <a href="/admin/projects" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Contact Info</h4>
                    <p class="card-text">Add, edit or delete contact information.</p>
                    <a href="/admin/contact" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
    </div>
    <br>

    <p>This website is managed by <?php $admins = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/admins.json"), true); foreach ($admins as $index => $item): ?><b><?= $item ?></b><?php if ($item === $_USER): ?> (you)<?php endif; ?><?php if ($index !== count($admins) - 1): ?><?php if ($index + 1 === count($admins) - 1): ?> and <?php else: ?>, <?php endif; ?><?php endif; ?><?php endforeach; ?>, <a href="/admin/users">edit...</a></p>

    <p class="small text-muted">powered by Pawer Technologies</p>
</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/footer.php"; ?>