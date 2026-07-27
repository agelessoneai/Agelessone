<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // Send each account back to its own portal without carrying a stale
        // permission banner into an otherwise valid dashboard page.
        return redirect()->route($this->homeRoute($user->role));
    }

    private function homeRoute(string $role): string
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'security' => 'security.dashboard',
            'site_supervisor' => 'supervisor.dashboard',
            'sales' => 'sales.dashboard',
            'inventory_manager' => 'office-inventory.index',
            'workshop_manager' => 'workshops.index',
            'accounts' => 'accounts.expenses.index',
            default => 'user.dashboard',
        };
    }
}
