<?php header("Content-Type: text/html"); if (str_ends_with($_SERVER["REQUEST_URI"], "/")) $_SERVER["REQUEST_URI"] = substr($_SERVER["REQUEST_URI"], 0, -1); if (str_contains($_SERVER["REQUEST_URI"], "..")) die(); ?>
<h1>Available endpoints at <?= $_SERVER['REQUEST_URI'] ?></h1>

<ul>
    <?php foreach (scandir($_SERVER["DOCUMENT_ROOT"] . $_SERVER['REQUEST_URI']) as $i1): if (is_dir($_SERVER["DOCUMENT_ROOT"] . $_SERVER['REQUEST_URI'] . "/" . $i1) && !str_starts_with($i1, ".")): ?>
        <li><a href="<?= $_SERVER['REQUEST_URI'] ?>/<?= $i1 ?>"><?= $_SERVER['REQUEST_URI'] ?>/<?= $i1 ?></a><ul>

                <?php foreach (scandir($_SERVER["DOCUMENT_ROOT"] . $_SERVER['REQUEST_URI'] . "/" . $i1) as $i2): if (is_dir($_SERVER["DOCUMENT_ROOT"] . $_SERVER['REQUEST_URI'] . "/" . $i1 . "/" . $i2) && !str_starts_with($i2, ".")): ?>
                    <li><a href="<?= $_SERVER['REQUEST_URI'] ?>/<?= $i1 ?>/<?= $i2 ?>"><?= $_SERVER['REQUEST_URI'] ?>/<?= $i1 ?>/<?= $i2 ?></a></li>

                <?php endif; endforeach; ?>
            </ul></li>
    <?php endif; endforeach; ?>

</ul>