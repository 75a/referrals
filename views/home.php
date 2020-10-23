<?php

use app\locales\English;

?>
<h2>It's the home page</h2>
<p>Language test: <?= $languageTest ?></p>
<p>Other language test: <?= English::translate("Language") ?></p>