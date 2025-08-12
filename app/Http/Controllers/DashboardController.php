<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics and data.
     */
    public function index(): JsonResponse
    {
        try {
            // Get real-time statistics
            $stats = [
                'totalUsers' => User::count(),
                'activeUsers' => User::where('is_active', true)->count(),
                'totalRoles' => Role::count(),
                'totalPermissions' => Permission::count(),
            ];

            // Get recent activities (last 10 user logins, creations, etc.)
            $recentActivities = $this->getRecentActivities();

            // Get user growth data for charts
            $userGrowth = $this->getUserGrowthData();

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => $stats,
                    'recentActivities' => $recentActivities,
                    'userGrowth' => $userGrowth,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading dashboard data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent activities from the system.
     */
    private function getRecentActivities(): array
    {
        // For now, return some basic activities
        // In a real app, you would have an activities/logs table
        $activities = [];
        
        // Get recent user creations
        $recentUsers = User::latest()->take(3)->get();
        foreach ($recentUsers as $user) {
            $activities[] = [
                'id' => 'user_' . $user->id,
                'action' => 'New user account created: ' . $user->name,
                'timestamp' => $user->created_at->diffForHumans(),
                'type' => 'success',
                'icon' => 'user-plus'
            ];
        }

        // Get recent role updates
        $recentRoles = Role::latest()->take(2)->get();
        foreach ($recentRoles as $role) {
            $activities[] = [
                'id' => 'role_' . $role->id,
                'action' => 'Role updated: ' . $role->display_name,
                'timestamp' => $role->updated_at->diffForHumans(),
                'type' => 'info',
                'icon' => 'shield'
            ];
        }

        // Sort by timestamp (most recent first)
        usort($activities, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        return array_slice($activities, 0, 5); // Return top 5 activities
    }

    /**
     * Get user growth data for charts.
     */
    private function getUserGrowthData(): array
    {
        // Get user count by month for the last 6 months
        $userGrowth = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $userCount = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            
            $userGrowth[] = [
                'month' => $date->format('M Y'),
                'users' => $userCount,
                'date' => $date->format('Y-m')
            ];
        }

        return $userGrowth;
    }
}
