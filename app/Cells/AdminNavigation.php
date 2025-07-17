<?php
/**
 * Admin Navigation cell
 */

namespace App\Cells;

class AdminNavigation
{
    /**
     * Main navigation
     * Left
     */
    public function leftNavigation() : string
    {
        return view('template/admin_left_navigation');
    }
}
