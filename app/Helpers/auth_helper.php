<?php

use CodeIgniter\Session\Session;

/**
 * Cek apakah user adalah superadmin (root)
 */
function is_superadmin()
{
    return session()->get('is_root') === true;
}
