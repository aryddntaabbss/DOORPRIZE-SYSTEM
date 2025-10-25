<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Participant;
use App\Models\Winner;

abstract class Controller
{
    //
}
class DashboardController extends Controller
{

    public function index()
    {
        $totalParticipants = Participant::count();
        $totalCategories = Category::count();
        $totalWinners = Winner::count();

        return view('dashboard', compact('totalParticipants', 'totalCategories', 'totalWinners'));
    }
}
