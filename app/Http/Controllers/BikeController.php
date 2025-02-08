<?php

namespace App\Http\Controllers;

use App\Models\Bike;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class BikeController extends Controller
{
    public function index()
    {
        return Bike::all();
    }

    public function create(Request $request)
    {
dd(Gate::authorize('create', Bike::class));

        $request->validate(['name' => 'required|string']);

        $query = Bike::create(['name' => $request['name']]);

        return response()->json([
            'success' => true,
            'message' => __('create was successful'),
        ], ['id' => $query->id]);
    }

    public function update(Request $request,Bike $bike)
    {
        Gate::authorize('update', $bike);
        $request->validate([
            'name' => 'required|string'
        ]);

        $query = Bike::update(['name' => $request['name']]);

        return response()->json([
            'success' => true,
            'message' => __('create was successful'),
        ], ['id' => $query->id]);
    }

    public function delete(Bike $bike)
    {
        Gate::authorize('delete', $bike);
        return $bike->delete();

    }
}

