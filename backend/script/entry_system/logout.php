<?php

setcookie("unique_id", '', time()-3600, "/");
header("Location: /page/entry_system/authorization");