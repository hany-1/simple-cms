<?php

namespace App\Classes;

use Illuminate\Support\Facades\Auth;

class Menu
{
    public static function renderMenu($items)
    {
        $content = '';
        if (Auth::check()) {
            foreach ($items as $item) {
                if (isset($item['submenu']) && $item['submenu']) {
                    $content .= '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $item['title'] . '</a>';
                    // $content .= '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $item['title'] . '</a>';
                    $content .= '<ul class="dropdown-menu">';
                    foreach ($item['submenu'] as $submenu) {
                        $content .= '<li><a class="dropdown-item"' . (isset($submenu['new-tab']) && $submenu['new-tab'] ? 'target="_blank"' : '') . ' href=' . route($submenu['page']) . '>' . $submenu['title'] . '</a></li>';
                    }
                    $content .= '</ul></li>';
                } else {
                    $content .= '<li class="nav-item"><a class="nav-link ' . (request()->is(str_replace('.', '/', $item['page-group']) . "*") ? "active" : "") . '"' . (isset($item['new-tab']) && $item['new-tab'] ? 'target="_blank"' : '') . ' href=' . route($item['page']) . '>' . $item['title'] . '</a></li>';
                }
            }
        }
        echo $content;
    }
}
