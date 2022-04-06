<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/session.php"; global $_USER; ?>
<?php

$projects = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/contact.json"), true);

if (isset($_GET['submit'])) {
    if (isset($_GET["add-project"]) && isset($_GET["add-project-src"])) {
        $projects[] = [
            "name" => $_GET["add-project"],
            "link" => $_GET["add-project-src"],
            "icon" => "about:blank"
        ];
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/contact.json", json_encode($projects, JSON_PRETTY_PRINT));
        header("Location: /admin/contact");
        die();
    }

    if (isset($_GET["delete-project"])) {
        if (isset($projects[(int)$_GET["delete-project"]])) {
            unset($projects[(int)$_GET["delete-project"]]);
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/contact.json", json_encode($projects, JSON_PRETTY_PRINT));
            header("Location: /admin/contact");
            die();
        }
    }

    if (isset($_GET["edit-project"]) && isset($_GET["edit-project-name"]) && isset($_GET["edit-project-source"]) && isset($_GET["edit-project-icon"])) {
        if (isset($projects[(int)$_GET["edit-project"]])) {
            $projects[(int)$_GET["edit-project"]]["name"] = $_GET["edit-project-name"];
            $projects[(int)$_GET["edit-project"]]["link"] = $_GET["edit-project-source"];
            $projects[(int)$_GET["edit-project"]]["icon"] = $_GET["edit-project-icon"];
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/contact.json", json_encode($projects, JSON_PRETTY_PRINT));
            header("Location: /admin/contact");
            die();
        }
    }
}

?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/header.php"; ?>

<br>
<div class="container">
    <?php if (isset($_GET['change']) && isset($_GET['edit-project']) && isset($projects[(int)$_GET["edit-project"]])): $project = $projects[(int)$_GET["edit-project"]]; ?>

    <h1>Edit <b><?= $project["name"] ?></b> (<code><?= (int)$_GET["edit-project"] ?></code>)</h1>

    <form>
        <p>
            Social Network Name:<br>
            <input name="edit-project-name" class="form-control" type="text" value="<?= $project["name"] ?>">
        </p>
        <p>
            Link:<br>
            <input name="edit-project-source" class="form-control" type="text" value="<?= $project["link"] ?>">
        </p>
        <p>
            Icon URL (can be relative):<br>
            <input name="edit-project-icon" class="form-control" type="text" value="<?= $project["icon"] ?>">
        </p>
        <input name="submit" type="hidden">
        <input name="edit-project" type="hidden" value="<?= (int)$_GET["edit-project"] ?>">
        <button type="submit" class="btn btn-primary">Save and apply changes</button>
    </form>

    <?php else: ?>
    <h1>Contact Info Management</h1>
    <p>Contact info added to this list is publicly shown on the website's Contact page and will lead users to containg you.</p>

    <ul class="list-group">
        <?php foreach (json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/contact.json"), true) as $index => $project): ?>
        <li class="list-group-item">
            <span style="vertical-align: middle;padding-top:10px;">
                <img src="<?= $project["icon"] ?>" class="project-icon"> <?= $project["name"] ?>
            </span>
            <form style="display:inline;float:right;">
                <input name="delete-project" type="hidden" value="<?= $index ?>">
                <input name="submit" type="hidden">
                <button type="submit" class="btn btn-danger">Remove</button>
            </form>
            <form style="display:inline;float:right;margin-right:10px;">
                <input name="edit-project" type="hidden" value="<?= $index ?>">
                <input name="change" type="hidden">
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
    <br>

    <button type="button" id="admin-add-s0" class="btn btn-outline-primary" onclick="document.getElementById('admin-add-s0').style.display='none';document.getElementById('admin-add-s1').style.display='';document.getElementById('admin-add-s2').focus();">Add another contact method</button>
    <div class="card" style="max-width:550px;display:none;" id="admin-add-s1">
        <form class="card-body">
            <h4 class="card-title">Add contact method</h4>
            <p>Once added, this contact method will be shown on the Contact page.</p>
            <p>
                <input id="admin-add-s2" name="add-project" type="text" class="form-control" placeholder="Social network name">
                <input id="admin-add-s2a" name="add-project-src" type="text" class="form-control" placeholder="Link">
            </p>
            <p>You are able to add additional details after adding the contact method.</p>
            <input name="submit" type="hidden">
            <button type="submit" class="btn btn-success">Create</button> <button onclick="document.getElementById('admin-add-s1').style.display='none';document.getElementById('admin-add-s0').style.display='';" type="button" class="btn btn-outline-danger">Cancel</button>
        </form>
    </div>
    <?php endif; ?>
</div>

<style>
    .project-icon {
        border-radius: 999px;
        width: 24px;
        vertical-align: middle;
        background: lightgray;
        margin-right: 5px;
    }
</style>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/footer.php"; ?>