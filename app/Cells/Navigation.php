<?php
/**
 * Navigation cell
 */

namespace App\Cells;

class Navigation
{
    /**
     * Main navigation
     * Top
     */
    public function mainNavigation() : string
    {
        return view('template/main_navigation');
    }

    /**
     * Footer navigation
     */
    public function footerNavigation() : string
    {
        return 'Footer Navigation';
    }
}
