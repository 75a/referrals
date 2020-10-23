<?php
/** @var $this \app\core\View */

?>

<h1>Profile</h1>
<p>Your e-mail: <strong><?= $email ?></strong></p>
<p>Your name: <strong><?= $fullname ?></strong></p>
<p>Your reflink: <strong><a href="http://localhost:8080/r?code=<?= $reflink ?>">http://localhost:8080/r?code=<?= $reflink ?></a></strong></p>
<p>Your points: <strong><?= $points ?></strong></p>