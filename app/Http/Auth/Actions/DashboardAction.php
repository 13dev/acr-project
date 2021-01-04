<?php


namespace App\Http\Auth\Actions;

use App\Domain\Album\Album;

class DashboardAction
{
    public function __invoke()
    {
        return view('dashboard', [
            'albums' => Album::all()
        ]);
    }
}
