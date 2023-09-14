<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class UserController
{
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('user.index');
    }
}
