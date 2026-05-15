<?php

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Get session prefix based on role
 * This allows multiple users with different roles to login simultaneously
 */
function getSessionPrefix($role = null) {
    if ($role === null) {
        // Don't use getCurrentRole() here to avoid circular reference
        if (isset($_SESSION['active_role'])) {
            $role = $_SESSION['active_role'];
        } else {
            $role = null;
        }
    }
    
    $prefixes = [
        'user' => 'user_',
        'admin' => 'admin_',
        'kepala_lab' => 'kepala_'
    ];
    
    return $prefixes[$role] ?? 'user_';
}

/**
 * Check if any role is logged in
 */
function isLoggedIn() {
    // Check if any role session exists
    return isset($_SESSION['user_user_id']) || 
           isset($_SESSION['admin_user_id']) || 
           isset($_SESSION['kepala_user_id']);
}

/**
 * Check if specific role is logged in
 */
function isRoleLoggedIn($role) {
    $prefix = getSessionPrefix($role);
    return isset($_SESSION[$prefix . 'user_id']);
}

/**
 * Get current active role
 * Returns the role that is currently active in this session
 */
function getCurrentRole() {
    // Return the active role if set
    if (isset($_SESSION['active_role'])) {
        return $_SESSION['active_role'];
    }
    
    // Fallback: check which role session exists
    if (isset($_SESSION['user_user_id'])) return 'user';
    if (isset($_SESSION['admin_user_id'])) return 'admin';
    if (isset($_SESSION['kepala_user_id'])) return 'kepala_lab';
    return null;
}

/**
 * Set session data for specific role
 */
function setRoleSession($role, $userData) {
    $prefix = getSessionPrefix($role);
    $_SESSION[$prefix . 'user_id'] = $userData['id'];
    $_SESSION[$prefix . 'name'] = $userData['name'];
    $_SESSION[$prefix . 'email'] = $userData['email'];
    $_SESSION[$prefix . 'role'] = $userData['role'];
    $_SESSION[$prefix . 'nim_nip'] = $userData['nim_nip'];
    
    // Set active role
    $_SESSION['active_role'] = $role;
}

/**
 * Clear session data for specific role
 */
function clearRoleSession($role) {
    $prefix = getSessionPrefix($role);
    unset($_SESSION[$prefix . 'user_id']);
    unset($_SESSION[$prefix . 'name']);
    unset($_SESSION[$prefix . 'email']);
    unset($_SESSION[$prefix . 'role']);
    unset($_SESSION[$prefix . 'nim_nip']);
    
    // Clear active role if it matches
    if (isset($_SESSION['active_role']) && $_SESSION['active_role'] === $role) {
        unset($_SESSION['active_role']);
    }
}

/**
 * Get user ID for current active role
 */
function getUserId() {
    $role = getCurrentRole();
    if (!$role) return null;
    
    $prefix = getSessionPrefix($role);
    return $_SESSION[$prefix . 'user_id'] ?? null;
}

/**
 * Get role for current active session
 */
function getUserRole() {
    $role = getCurrentRole();
    if (!$role) return null;
    
    $prefix = getSessionPrefix($role);
    return $_SESSION[$prefix . 'role'] ?? null;
}

/**
 * Get user name for current active role
 */
function getUserName() {
    $role = getCurrentRole();
    if (!$role) return null;
    
    $prefix = getSessionPrefix($role);
    return $_SESSION[$prefix . 'name'] ?? null;
}

/**
 * Get user email for current active role
 */
function getUserEmail() {
    $role = getCurrentRole();
    if (!$role) return null;
    
    $prefix = getSessionPrefix($role);
    return $_SESSION[$prefix . 'email'] ?? null;
}

/**
 * Get user NIM/NIP for current active role
 */
function getUserNimNip() {
    $role = getCurrentRole();
    if (!$role) return null;
    
    $prefix = getSessionPrefix($role);
    return $_SESSION[$prefix . 'nim_nip'] ?? null;
}

/**
 * Check if current user has specific role
 */
function hasRole($role) {
    return getUserRole() === $role;
}

/**
 * Check if current user has any of the specified roles
 */
function hasAnyRole($roles) {
    return in_array(getUserRole(), $roles);
}

/**
 * Get all logged in roles
 */
function getLoggedInRoles() {
    $roles = [];
    if (isset($_SESSION['user_user_id'])) $roles[] = 'user';
    if (isset($_SESSION['admin_user_id'])) $roles[] = 'admin';
    if (isset($_SESSION['kepala_user_id'])) $roles[] = 'kepala_lab';
    return $roles;
}

/**
 * Switch to different role session
 */
function switchRole($role) {
    if (isRoleLoggedIn($role)) {
        $_SESSION['active_role'] = $role;
        return true;
    }
    return false;
}
