<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBikeRequest;
use App\Http\Resources\BikeResource;
use App\Models\Bike;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class BikeController extends Controller
{
    public function index()
    {
        $bikes = Bike::all();
        return BikeResource::collection($bikes);
    }

    public function create(CreateBikeRequest $request)
    {
        $bike = Bike::create($request->validated());
        return response()->json([
            'success' => true,
            'data' => new BikeResource($bike),
        ], 201);
    }

    public function update(Request $request, Bike $bike)
    {
        $bike->update(['name' => $request->name]);
        return response()->json([
            'success' => true,
            'data' => new BikeResource($bike),
        ], 201);

    }

    public function delete(Bike $bike)
    {
        Gate::authorize('delete', $bike);

        $bike->delete();

        return response()->json([
            'success' => true,
            'message' => __('delete was successful'),
        ], 200);
    }

}

