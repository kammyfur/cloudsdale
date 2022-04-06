<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/session.php"; global $_USER; ?>
<?php

if (isset($_GET['submit'])) {
    if (isset($_GET["system-id"])) {
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/pluralkit.json", json_encode([
                "system" => $_GET['system-id']
        ], JSON_PRETTY_PRINT));
        header("Location: /admin/pluralkit");
        die();
    }
}

?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/header.php"; ?>

<br>
<div class="container">
    <h1>PluralKit Configuration</h1>

    <p><b>Current System:</b> <?php

        $config = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/pluralkit.json"), true);
        $data = @file_get_contents("https://api.pluralkit.me/v2/systems/$config[system]");

        if (isset($data) && $data !== false):
            $parsed = json_decode($data, true);
        ?>
        <img src="<?= $parsed["avatar_url"] ?>" id="system-icon"><?= $parsed["name"] ?> (<code><?= $parsed["id"] ?></code>)
            <?php else: ?>
        <span class="text-danger">Not found, please make sure the ID is entered correctly</span>
            <?php endif; ?></p>
    <form class="input-group mb-3" style="max-width: 500px;">
        <input name="system-id" value="<?= $config['system'] ?>" type="text" class="form-control" placeholder="System ID">
        <input type="hidden" name="submit">
        <button class="btn btn-primary" type="submit">Save and apply</button>
    </form>
</div>

<style>
    #system-icon {
        border-radius: 999px;
        width: 24px;
        vertical-align: middle;
        background: lightgray;
        margin-right: 5px;
    }
</style>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/admin/footer.php"; ?>