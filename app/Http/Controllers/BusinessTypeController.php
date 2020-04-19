<?php

namespace App\Http\Controllers;

use App\BusinessType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(['btypes' => BusinessType::all()], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:business_types'
        ]);

        try {
            $btyps = new BusinessType;

            $btyps->name = $request->name;
            $btyps->ip_address = $request->ip();
            $btyps->save();
            return response()->json(['btypes' => $btyps, 'message' => 'Created successfully!'], 201);

        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 409);
        }
    }


    public function show($id)
    {
        try {
            $bTypes = BusinessType::findOrFail($id);

            return response()->json(['btypes' => $bTypes], 200);

        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }


    public function edit($id)
    {
        try {
            $bTypes = BusinessType::findOrFail($id);

            return response()->json(['btypes' => $bTypes], 200);

        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }

    public function search(Request $request)
    {
        $this->validate($request, ['searchStr' => 'required|string']);
        try {
            $searchItem = $request->searchStr;
            $btyps = BusinessType::query()
                ->where('name', 'LIKE', "%{$searchItem}%")
                ->get();
            if (!$btyps->isEmpty()) {
                return response()->json(['datas' => $btyps, 'message' => 'Result with this query'], 200);
            } else {
                return response()->json(['datas' => $btyps, 'message' => 'No data found!'], 404);
            }


        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:business_types,name,' . $id
        ]);

        try {
            $data = $request->all();
            $data['updated_by'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['ip_address'] = $request->ip();
            BusinessType::where('id', $id)->update($request->all());
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }


    public function destroy($id)
    {
        try {
            BusinessType::findOrFail($id)->delete();
            return response()->json(['message' => 'Data deleted successfully'], 200);

        } catch (\Exception $e) {

            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }
}