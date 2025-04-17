<?php

namespace App\Http\Controllers;

use App\Http\Resources\mahasiswaResource;
use App\Models\mahasiswaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = mahasiswaService::all();
        return new mahasiswaResource($mahasiswa, 'success', 'Daftar semua mahasiswa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'nomor' => 'required',
            'umur' => 'required'
        ]);
        if ($validator->fails()) {
            return new mahasiswaResource(null, 'failed', $validator->errors());
        };

        $mahasiswa = mahasiswaService::create($request->all());
        return new mahasiswaResource($mahasiswa, 'success', 'student create successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswa = mahasiswaService::find($id);
        if ($mahasiswa) {
            return new mahasiswaResource($mahasiswa, 'success', 'Mahasiswa ditemukan');
        } else {
            return new mahasiswaResource(null, 'failed', 'Mahasiswa tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'nomor' => 'required',
            'umur' => 'required'
        ]);
        if ($validator->fails()) {
            return new mahasiswaResource(null, 'failed', $validator->errors());
        };

        $mahasiswa = mahasiswaService::find($id);
        if (!$mahasiswa) {
            return new mahasiswaResource(null, 'Failed', 'Mahasiswa tidak ditemukan');
        }
        $mahasiswa->update($request->all());
        return new mahasiswaResource($mahasiswa, 'success', 'Data mahasiswa berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = mahasiswaService::find($id);
        if (!$mahasiswa) {
            return new mahasiswaResource(null, 'Failed', 'Mahasiswa tidak ditemukan');
        }
        $mahasiswa->delete();
        return new mahasiswaResource(null, 'success', 'data mahasiswa berhasil dihapus');
    }

    public function nilai($nim)
    {
        $response = Http::get("http://localhost:8001/api/nilai?nim=$nim");
        return $response->json();
    }

    public function cariByNim($nim)
    {
        $mahasiswa = mahasiswaService::where('nim', $nim)->first();

        if ($mahasiswa) {
            return new mahasiswaResource($mahasiswa, 'success', 'Mahasiswa ditemukan berdasarkan NIM');
        } else {
            return new mahasiswaResource(null, 'failed', 'Mahasiswa tidak ditemukan');
        }
    }
}
