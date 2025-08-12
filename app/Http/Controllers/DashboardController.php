<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Load user with roles and permissions
        $user->load(['roles.permissions']);
        
        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => $user
            ]
        ]);
    }
}
