<?php
define('SESSION_TIMEOUT', 5 * 3600);
ini_set('session.gc_maxlifetime', SESSION_TIMEOUT);
session_set_cookie_params(SESSION_TIMEOUT);
session_start();
