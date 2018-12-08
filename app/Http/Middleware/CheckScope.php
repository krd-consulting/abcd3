<?php

namespace App\Http\Middleware;

use App\Scope;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckScope
{
    public function handle($request, Closure $next, $scope)
    {
        // A user with a universal scope does not need a direct/indirect association with a resource in order to access that resource.
        if(Auth::user()->scope == 'universal')
            return $next($request);

        // For users who do not meet the scope requirements for accessing a type of resource.
        if(!Auth::user()->hasScopeOfAtleast($scope))
            abort(403, "This type of resource is out of bounds for the user who has a $scope scope." );

        $message = "This specific resource may not exist or is not available to the user with a $scope scope.";

        // For users who meet the scope requirements but the individual resource is not accessible to the user.
        switch($scope) {
            case 'team':
                // Abort unless the user is associated with the requested team.
                abort_unless(
                    Auth::user()->hasTeam($request->route('id')),
                    404,
                    $message
                );
                break;

            case 'program':
                // Abort unless the user is associated with the requested program.
                abort_unless(
                    Auth::user()->hasProgram($request->route('id')),
                    404,
                    $message
                );
                break;

            default:
                // Abort unless the user is associated with the requested file.
                abort_unless(
                    Auth::user()->hasFile($request->route('id')),
                    404,
                    $message
                );
                break;
        }

        return $next($request);
    }
}
