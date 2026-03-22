<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

abstract class Controller
{
    /**
     * Return the mobile view if the request is from a mobile device
     * and the mobile view exists, otherwise return the desktop view.
     */
    protected function mobileView(string $view, array $data = []): View
    {
        $isMobile   = request()->attributes->get('isMobile', false);
        $mobileView = 'mobile.' . $view;

        if ($isMobile && view()->exists($mobileView)) {
            return view($mobileView, $data);
        }

        return view($view, $data);
    }
}
