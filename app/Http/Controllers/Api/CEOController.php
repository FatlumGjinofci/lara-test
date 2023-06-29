<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCEOFormRequest;
use App\Http\Resources\CEOResource;
use App\Models\CEO;
use Illuminate\Http\Request;

class CEOController extends Controller
{
    public function index()
    {
        $ceos = CEO::all();

        return response()->json([
            'status' => true,
            'message' => 'Retrieved successfully',
            'ceos' => $ceos,
        ]);
    }

    public function store(StoreCEOFormRequest $request)
    {
        $data = $request->validated();

        $ceo = CEO::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Created successfully',
            'ceo' => new CEOResource($ceo),
        ], 201);
    }

    public function show(Ceo $ceo)
    {
        return response()->json([
            'status' => true,
            'message' => 'Retrieved successfully',
            'ceo' => new CEOResource($ceo)
        ]);
    }

    public function update(Request $request, CEO $ceo)
    {
        $ceo->update($request->all());

        return response()->json([
           'status' => false,
            'message' => 'Updated successfully',
            'ceo' => new CEOResource($ceo),
        ]);
    }

    public function delete(CEO $ceo)
    {
        $ceo->delete();

        return response()->json([
            'message' => 'Deleted'
        ], 204);
    }
}
