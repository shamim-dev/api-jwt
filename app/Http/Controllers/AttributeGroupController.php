<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttributeGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(['data' => AttributeGroup::all()], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:attribute_groups'
        ]);

        try {
            $attrGroups = new AttributeGroup;

            $attrGroups->name = $request->name;
            $attrGroups->ip_address = $request->ip();
            $attrGroups->save();
            return response()->json(['data' => $attrGroups, 'message' => 'Created successfully!'], 201);

        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 409);
        }
    }


    public function show($id)
    {
        try {
           $attrGroups = AttributeGroup::findOrFail($id);
            //$attribute = $attrGroups->attribute; get relational all data collection
           // dd($attribute);

            return response()->json(['data' => $attrGroups], 200);

        } catch (\Exception $e) {
            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }


    public function edit($id)
    {
        try {
            $attrGroups = AttributeGroup::findOrFail($id);

            return response()->json(['data' => $attrGroups], 200);

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
            $attrGroups = AttributeGroup::query()
                ->where('name', 'LIKE', "%{$searchItem}%")
                ->get();
            if (!$attrGroups->isEmpty()) {
                return response()->json(['data' => $attrGroups, 'message' => 'Result with this query'], 200);
            } else {
                return response()->json(['data' => $attrGroups, 'message' => 'No data found!'], 404);
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
            'name' => 'required|string|unique:attribute_groups,name,' . $id
        ]);

        try {
            $data = $request->all();
            $data['updated_by'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['ip_address'] = $request->ip();
            AttributeGroup::where('id', $id)->update($request->all());
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
            $attrGroup=AttributeGroup::findOrFail($id);
            //$attrGroup->Attribute()->where('attribute_group_id', $id)->update(['status'=>0]);
            $attrGroup->Attribute()->delete();
            $attrGroup->delete();
            return response()->json(['message' => 'Data deleted successfully'], 200);

        } catch (\Exception $e) {

            $errCode = $e->getCode();
            $errMgs = $e->getMessage();
            return response()->json(['error code' => $errCode, 'message' => $errMgs], 500);
        }
    }
}