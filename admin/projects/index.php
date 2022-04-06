<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/session.php"; global $_USER; ?>
<?php

$projects = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json"), true);

if (isset($_GET['submit'])) {
    if (isset($_GET["showcase-yes"])) {
        if (isset($projects[(int)$_GET["showcase-yes"]])) {
            $projects[(int)$_GET["showcase-yes"]]["showcase"] = true;
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json", json_encode($projects, JSON_PRETTY_PRINT));
            header("Location: /admin/projects");
            die();
        }
    }

    if (isset($_GET["showcase-no"])) {
        if (isset($projects[(int)$_GET["showcase-no"]])) {
            $projects[(int)$_GET["showcase-no"]]["showcase"] = false;
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json", json_encode($projects, JSON_PRETTY_PRINT));
            header("Location: /admin/projects");
            die();
        }
    }

    if (isset($_GET["add-project"]) && isset($_GET["add-project-src"])) {
        $projects[] = [
            "name" => $_GET["add-project"],
            "description" => $_GET["add-project"],
            "icon" => "about:blank",
            "source" => $_GET["add-project-src"],
            "showcase" => false
        ];
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json", json_encode($projects, JSON_PRETTY_PRINT));
        header("Location: /admin/projects");
        die();
    }

    if (isset($_GET["delete-project"])) {
        if (isset($projects[(int)$_GET["delete-project"]])) {
            unset($projects[(int)$_GET["delete-project"]]);
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json", json_encode($projects, JSON_PRETTY_PRINT));
            header("Location: /admin/projects");
            die();
        }
    }

    if (isset($_GET["edit-project"]) && isset($_GET["edit-project-name"]) && isset($_GET["edit-project-source"]) && isset($_GET["edit-project-icon"]) && isset($_GET["edit-project-description"])) {
        if (isset($projects[(int)$_GET["edit-project"]])) {
            $projects[(int)$_GET["edit-project"]]["name"] = $_GET["edit-project-name"];
            $projects[(int)$_GET["edit-project"]]["description"] = $_GET["edit-project-description"];
            $projects[(int)$_GET["edit-project"]]["icon"] = $_GET["edit-project-icon"];
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json", json_encode($projects, JSON_PRETTY_PRINT));
            header("Location: /admin/projects");
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
            Project Name:<br>
            <input name="edit-project-name" class="form-control" type="text" value="<?= $project["name"] ?>">
        </p>
        <p>
            Project VCS Repository:<br>
            <input name="edit-project-source" class="form-control" type="text" value="<?= $project["source"] ?>">
        </p>
        <p>
            Icon URL (can be relative):<br>
            <input name="edit-project-icon" class="form-control" type="text" value="<?= $project["icon"] ?>">
        </p>
        <p>
            Project Description (can contain HTML tags):<br>
            <textarea name="edit-project-description" class="form-control font-monospace" type="text"><?= $project["description"] ?></textarea>
        </p>
        <input name="submit" type="hidden">
        <input name="edit-project" type="hidden" value="<?= (int)$_GET["edit-project"] ?>">
        <button type="submit" class="btn btn-primary">Save and apply changes</button>
    </form>

    <?php else: ?>
    <h1>Projects Management</h1>
    <p>Projects added to this list are publicly shown on the website's Projects page and (for select projects) on the homepage.</p>

    <ul class="list-group">
        <?php foreach (json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json"), true) as $index => $project): ?>
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
            <?php if ($project["showcase"]): ?>
                <form style="display:inline;float:right;margin-right:10px;">
                    <input name="showcase-no" type="hidden" value="<?= $index ?>">
                    <input name="submit" type="hidden">
                    <button type="submit" class="btn btn-outline-danger">Hide on homepage</button>
                </form>
            <?php else: ?>
                <form style="display:inline;float:right;margin-right:10px;">
                    <input name="showcase-yes" type="hidden" value="<?= $index ?>">
                    <input name="submit" type="hidden">
                    <button type="submit" class="btn btn-outline-success">Show on homepage</button>
                </form>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <br>

    <button type="button" id="admin-add-s0" class="btn btn-outline-primary" onclick="document.getElementById('admin-add-s0').style.display='none';document.getElementById('admin-add-s1').style.display='';document.getElementById('admin-add-s2').focus();">Create another project</button>
    <div class="card" style="max-width:550px;display:none;" id="admin-add-s1">
        <form class="card-body">
            <h4 class="card-title">Create project</h4>
            <p>Once added, this project will be shown on the Projects page.</p>
            <p>
                <input id="admin-add-s2" name="add-project" type="text" class="form-control" placeholder="Project name">
                <input id="admin-add-s2a" name="add-project-src" type="text" class="form-control" placeholder="VCS repository">
            </p>
            <p>You are able to add additional details after creating the project.</p>
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