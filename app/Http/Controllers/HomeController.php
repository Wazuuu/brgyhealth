<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Fetch raw counts
        $totalResidents = Resident::count();

        // 2. Calculate categories
        // Men: Male and Age >= 18
        $menCount = Resident::where('gender', 'male')->where('age', '>=', 18)->count();

        // Women: Female and Age >= 18
        $womenCount = Resident::where('gender', 'female')->where('age', '>=', 18)->count();

        // Children: Age < 18 (Regardless of gender)
        $childrenCount = Resident::where('age', '<', 18)->count();

        // Statuses
        $pregnantCount = Resident::where('is_pregnant', true)->count();
        $sickCount = Resident::where('is_sick', true)->count();

        // 3. Pass data to view
        return view('home', compact(
    'totalResidents', 'menCount', 'womenCount', 
    'childrenCount', 'pregnantCount', 'sickCount'
    ));
    }
}