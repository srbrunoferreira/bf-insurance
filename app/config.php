<?php

// Stores the domain of the site. i.e. https://www.site.com
define('DOMAIN', ($_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
