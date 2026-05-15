<?php

session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load config
require_once '../app/config/config.php';
require_once '../app/config/database.php';

// Load helpers
require_once '../app/helpers/response_helper.php';
require_once '../app/helpers/auth_helper.php';

// Load core
require_once '../app/core/App.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';

// Initialize app
$app = new App();
