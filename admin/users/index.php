<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/session.php"; global $_USER; ?>
<?php

if (isset($_GET['submit'])) {
    $admins = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/admins.json"), true);

    if (isset($_GET["delete-user"])) {
        $newlist = [];

        foreach ($admins as $admin) {
            if ($admin !== $_GET["delete-user"]) {
                $newlist[] = $admin;
            }
        }

        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/admins.json", json_encode($newlist, JSON_PRETTY_PRINT));
        header("Location: /admin/users");
        die();
    }

    if (isset($_GET["add-user"])) {
        $admins[] = $_GET["add-user"];
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/admins.json", json_encode($admins, JSON_PRETTY_PRINT));
        header("Location: /admin/users");
        die();
    }
}

?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/header.php"; ?>

<br>
<div class="container">
    <h1>Administrators Management</h1>
    <p>Administrators added to this list are able to login to this admin panel using their GitHub account. Make sure you trust the person before giving them administrative permissions.</p>

    <ul class="list-group">
        <?php foreach (json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/admins.json"), true) as $user): ?>
        <li class="list-group-item">
            <form>
                <span style="vertical-align: middle;padding-top:10px;">
                    <a href="https://github.com/<?= $user ?>" target="_blank"><?= $user ?></a>
                    <?php if ($user === $_USER): ?>
                        <span class="badge bg-warning rounded-pill">You!</span>
                    <?php endif; ?>
                    <?php if ($user === "Minteck"): ?>
                        <span class="badge bg-danger rounded-pill">Immutable</span>
                    <?php endif; ?>
                </span>
                <input name="delete-user" type="hidden" value="<?= $user ?>">
                <input name="submit" type="hidden">
                <button type="submit" class="btn btn-danger" style="float:right;vertical-align: middle;"
                    <?php if ($user === $_USER || $user === "Minteck"): ?> disabled<?php endif; ?>
                >Remove</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
    <br>

    <button type="button" id="admin-add-s0" class="btn btn-outline-primary" onclick="document.getElementById('admin-add-s0').style.display='none';document.getElementById('admin-add-s1').style.display='';document.getElementById('admin-add-s2').focus();">Add another administrator</button>
    <div class="card" style="max-width:550px;display:none;" id="admin-add-s1">
        <form class="card-body">
            <h4 class="card-title">Add administrator</h4>
            <p>This will give this user full control over this website, including permission to add or remove other administrators. <b>Make sure you trust this user.</b></p>
            <p>
                <input id="admin-add-s2" name="add-user" type="text" class="form-control" placeholder="GitHub user name">
            </p>
            <input name="submit" type="hidden">
            <button type="submit" class="btn btn-success">Add</button> <button onclick="document.getElementById('admin-add-s1').style.display='none';document.getElementById('admin-add-s0').style.display='';" type="button" class="btn btn-outline-danger">Cancel</button>
        </form>
    </div>
</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/footer.php"; ?>