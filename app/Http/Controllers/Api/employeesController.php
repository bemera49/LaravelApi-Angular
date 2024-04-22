<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class employeesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/employees",
     *     tags={"employees"},
     *     summary="Get list of employees",
     *     description="Returns list of employees",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Employees")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function index()
    {
        $employees = Employees::all();
        return response()->json($employees);
    }

    /**
     * @OA\Get(
     *     path="/api/employees/{id}",
     *     tags={"employees"},
     *     summary="Show an employee",
     *     description="Show an employee",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of employee to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Employees")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function show($id)
    {
        $employees = Employees::find($id);
        return response()->json($employees);
    }
    /**
     * @OA\Post(
     *     path="/api/save/employees",
     *     tags={"employees"},
     *     summary="Store new employee",
     *     description="Store new employee",
     *     @OA\RequestBody(
     *         description="Employee data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Employees")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Employees")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'identification_number' => 'required',
        ]);

        $employees = new Employees();
        $employees->company_id = $request->company_id['id']; // [id
        $employees->name = $request->name;
        $employees->email = $request->email;
        $employees->identification_number = $request->identification_number;
        $employees->save();

        return response()->json($employees, 201);
    }
    /**
     * @OA\Put(
     *     path="/api/update/employees/{id}",
     *     tags={"employees"},
     *     summary="Update an existing employee",
     *     description="Update an existing employee",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of employee to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Employee data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Employees")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Employees")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $employees = Employees::find($id);
        if (!$employees) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $request->validate([
            'company_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $id,
            'identification_number' => 'required',
        ]);

        $employees->company_id = $request->company_id['id'];
        $employees->name = $request->name;
        $employees->email = $request->email;
        $employees->identification_number = $request->identification_number;
        $employees->save();

        return response()->json($employees, 200);

    }

    public function destroy($id)
    {
        $employees = Employees::find($id);
        if (!$employees) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employees->delete();
        return response()->json(['message' => 'Employee deleted'], 200);
    }
}
