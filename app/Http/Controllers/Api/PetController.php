<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    // GET /api/pets?search=&status=available|pending|adopted|all&sort=latest|name|age|oldest&per_page=12&include=photos
    public function index(Request $req)
    {
        // Parseamos "include=photos,algo"
        $includes = collect(explode(',', (string) $req->query('include')))
            ->filter()
            ->map(fn($s) => trim($s))
            ->toArray();

        $q = Pet::query()
            ->with(['primaryPhoto:id,pet_id,photo_path'])
            ->when(in_array('photos', $includes), fn($qq) => 
                $qq->with('photos:id,pet_id,photo_path,is_primary')
            )
            ->when($req->filled('search'), function ($qq) use ($req) {
                $s = '%' . trim($req->search) . '%';
                $qq->where(fn($w) => $w->where('name', 'like', $s)
                    ->orWhere('breed', 'like', $s)
                    ->orWhere('description', 'like', $s));
            })
            ->when($req->filled('status') && $req->status !== 'all',
                fn($qq) => $qq->where('adoption_status', $req->status)
            );

        // Orden
        $sort = $req->get('sort', 'latest');
        $q->when($sort === 'name',   fn($qq) => $qq->orderByRaw('LOWER(name) asc'))
          ->when($sort === 'age',    fn($qq) => $qq->orderByRaw('age_months IS NULL, age_months asc'))
          ->when($sort === 'oldest', fn($qq) => $qq->orderBy('created_at', 'asc'))
          ->when(! in_array($sort, ['name','age','oldest']), fn($qq) => $qq->orderBy('created_at','desc'));

        // Paginación segura
        $perPage = (int) $req->get('per_page', 12);
        $perPage = max(1, min($perPage, 100));

        $pets = $q->paginate($perPage)->appends($req->query());

        return PetResource::collection($pets);
    }

    // GET /api/pets/{pet}?include=photos
    public function show(Request $req, Pet $pet)
    {
        $includes = collect(explode(',', (string) $req->query('include')))
            ->filter()
            ->map(fn($s) => trim($s))
            ->toArray();

        $pet->load(['primaryPhoto:id,pet_id,photo_path']);

        if (in_array('photos', $includes)) {
            $pet->load('photos:id,pet_id,photo_path,is_primary');
        }

        return new PetResource($pet);
    }
}
