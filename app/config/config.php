<?php

// Base URL
define('BASE_URL', 'http://localhost/laboratory_management/');

// App Settings
define('APP_NAME', 'Smart Laboratory Management System');
define('APP_VERSION', '1.0.0');

// Session Settings
define('SESSION_TIMEOUT', 3600); // 1 hour

// Upload Settings
define('UPLOAD_PATH', __DIR__ . '/../../storage/uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB

// Timezone
date_default_timezone_set('Asia/Jakarta');
