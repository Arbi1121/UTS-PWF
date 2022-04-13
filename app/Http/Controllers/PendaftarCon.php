<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PendaftarCon extends Controller
{
    public function registered(Request $request){
        $validator = Validator::make($request->all(),[
            'nama' => 'required|max:50',
            'kata_sandi' => 'required|max:50',
            'role' => 'required|in:admin,pendaftar',
            'tanggal_lahir' => 'required|date'
        ]);

        if($validator -> fails()){
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $validated = $validator->validated();

        Pendaftar::create([
            'nama' => $validated['nama'],
            'kata_sandi' => $validated['kata_sandi'],
            'role' => $validated['role'],
            'tanggal_lahir' => $validated['tanggal_lahir']
        ]);

        return response()->json('produk berhasil disimpan')->setStatusCode(201);
    }

    public function show(){
        $pendaftar = Pendaftar::all();

        return response()->json($pendaftar)->setStatusCode(201);
    }

    public function update(Request $request, $id){

        $pendaftar = Pendaftar::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'nama' => 'required|max:50',
            'kata_sandi' => 'required|max:50',
            'role' => 'required|in:admin,pendaftar',
            'tanggal_lahir' => 'required|date'
        ]);

        if($validator -> fails()){
            return response()->json($validator->messages())->setStatusCode(422);
        }

        return response()->json([
            'messages' => 'Data tidak ditemukan'
        ])->setStatusCode(404);
        
        try{
            $pendaftar->update($request->all());
            $response = [
                'message' => 'berhasil',
                'data' => $pendaftar
            ];
            return response()->json($response, Response::HTTP_OK);
        }catch(QueryException $e){
            return response()->json([
                'message' => 'eror',
                'data' => 'fail'.$e->errorInfo
            ]);
        }

    }

    public function destroy($id){
        $checkData = Pendaftar::find($id);

        if($checkData){
            Pendaftar::destroy($id);

            return response()->json([
                'messages' => 'Data berhasil dihapus'
            ])->setStatusCode(200);
        }

        return response()->json([
            'messages' => 'Data tidak ditemukan'
        ])->setStatusCode(404);
    }
}
