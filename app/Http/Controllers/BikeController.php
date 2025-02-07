<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BikeController extends Controller
{
    public function index()
    {
        return Bike::all();
    }

    public function create(Request $request)
    {
        $this->authorize('create', Bike::class);

        $request->validate(['name' => 'required|string']);

        $query = Bike::create(['name' => $request['name']]);

        return response()->json([
            'success' => true,
            'message' => __('create was successful'),
        ], ['id' => $query->id]);
    }

    public function update(Request $request,Bike $bike)
    {
        $this->authorize('update', $bike);
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
        $this->authorize('delete', $bike);
        return $bike->delete();

    }
}

