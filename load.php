<?php

ob_start();

session_start();

// configuration
require(dirname(__FILE__).'/config/config.php');

// scabros-core init
require(COREROOT.'core.php');

// extra functions
require(SYSROOT.'lib/functions.php');