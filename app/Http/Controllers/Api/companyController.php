<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class companyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/company",
     *     tags={"company"},
     *     summary="Get list of companies",
     *     description="Returns list of companies",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
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
        $companies = Company::all();
        return response()->json($companies, 200);
    }
    /**
     * @OA\Get(
     *     path="/api/companies/{id}",
     *     tags={"company"},
     *     summary="Show a company",
     *     description="Show a company",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of company to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
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
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }
        return response()->json($company, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/save/company",
     *     tags={"company"},
     *     summary="Store new company",
     *     description="Store new company",
     *     @OA\RequestBody(
     *         description="Company data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
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
            'name' => 'required',
            'email' => 'required|email|unique:company,email',
            'logo' => 'nullable|image',
            'website' => 'nullable|url',
        ]);

        // Procesar el archivo
        $archivo = $request->file('logo');
        $nombreArchivo = $archivo->getClientOriginalName(); // Nombre original del archivo
        $extension = $archivo->getClientOriginalExtension(); // Extensión del archivo
        // Que el nombre me quede sin el http://127.0.0.1:8000/storage/
        $nombreGuardado = pathinfo($nombreArchivo, PATHINFO_FILENAME) . '_' . time() . '.' . $extension; // Generar un nombre único para el archivo
        $rutaArchivo = $nombreGuardado; // Ruta donde se guardará el archivo

        // Guardar el archivo en la ruta especificada
        $archivo->move('C:/Users/gms44/aplication/src/assets/logoTipos/', $rutaArchivo);


        // Hacemos la consulta para guardar los datos
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $rutaArchivo;
        $company->website = $request->website;
        $company->save();

        return response()->json($company, 201);
    }
    /**
     * @OA\Post(
     *     path="/api/update/companies/{id}",
     *     tags={"company"},
     *     summary="Update an existing company",
     *     description="Update an existing company",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of company to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Company data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'logo' => 'required',
            'website' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $company = Company::find($id);

        if (!$company) {
            return response()->json([
                'message' => 'Company not found',
                'status' => 404
            ], 404);
        }

        // Procesar el archivo
        $archivo = $request->file('logo');
        $nombreArchivo = $archivo->getClientOriginalName(); // Nombre original del archivo
        $extension = $archivo->getClientOriginalExtension(); // Extensión del archivo
        $nombreGuardado = pathinfo($nombreArchivo, PATHINFO_FILENAME) . '_' . time() . '.' . $extension; // Generar un nombre único para el archivo
        $rutaArchivo = $nombreGuardado; // Ruta donde se guardará el archivo

        // Guardar el archivo en la ruta especificada
        $archivo->move('C:/Users/gms44/aplication/src/assets/logoTipos/', $rutaArchivo);

        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $rutaArchivo;
        $company->website = $request->website;
        $company->save();

        $data = [
            'message' => 'Company updated successfully',
            'company' => $company,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    /**
     * @OA\Delete(
     *     path="/api/delete/companies/{id}",
     *     tags={"company"},
     *     summary="Delete a company",
     *     description="Delete a company",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of company to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
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
    public function destroy($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }
        $company->delete();
        return response()->json(['message' => 'Company deleted'], 200);
    }
}
