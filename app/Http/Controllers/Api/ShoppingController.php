<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShoppingController extends Controller
{
    public function store(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'createddate' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => $validateUser->errors()
                ], 401);
            }

            $shopping = Shopping::create([
                'name' => $request->name,
                'created_at' => $request->createddate,
            ]);

            return response()->json([
                'shopping' => [
                    'name' => $shopping->name,
                    'id' => $shopping->id,
                    'createddate' => $shopping->created_at,
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getShoppings()
    {
        return response()->json([
            'shoppings' => Shopping::all(),
        ], 200);
    }

    public function show($id)
    {
        try {
            if (!($shopping = Shopping::find($id))) {
                return response()->json([
                    'message' => 'Data Shopping Not Found',
                ], 401);
            }

            return response()->json([
                'shopping' => [
                    'name' => $shopping->name,
                    'id' => $shopping->id,
                    'createddate' => $shopping->created_at,
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'createddate' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => $validateUser->errors()
                ], 401);
            }

            if (!($shopping = Shopping::find($id))) {
                return response()->json([
                    'message' => 'Data Shopping Not Found',
                ], 401);
            }

            $shopping->update([
                'name' => $request->name,
                'created_at' => $request->createddate,
            ]);

            return response()->json([
                'shopping' => [
                    'name' => $shopping->name,
                    'id' => $shopping->id,
                    'createddate' => $shopping->created_at,
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if (!($shopping = Shopping::find($id))) {
                return response()->json([
                    'message' => 'Data Shopping Not Found',
                ], 401);
            }

            $shopping->delete();

            return response()->json([
                'shopping' => [
                    'name' => $shopping->name,
                    'id' => $shopping->id,
                    'createddate' => $shopping->created_at,
                    'deleteddate' => $shopping->deleted_at,
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
