<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitanteController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return User::query()
            ->join('departments','users.department_id','departments.id')
            ->join('model_has_roles', 'users.id', 'model_id')
            ->select('users.id','users.name','profile_photo_path','departments.name as department')
            ->where('model_has_roles.role_id',3)
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name','like',"%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get()
            ->map(function (User $user) {
                return $user;
            });
    }
}
