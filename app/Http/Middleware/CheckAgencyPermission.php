<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agency;

class CheckAgencyPermission
{
    public function handle(Request $request, Closure $next)
    {
        // 🔒 Controllo autenticazione
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Devi autenticarti per accedere.');
        }

        $agencyUuid = $request->route('agencyUuid');

        $agency = Agency::where("uuid", $agencyUuid)->first();

        if (!$agency) {
            abort(404, 'Agency not found');
        }

        if (Auth::id() !== $agency->id_user_owner) {
            abort(403, "You don't have the permission to access this agency");
        }

        return $next($request);
    }
}
