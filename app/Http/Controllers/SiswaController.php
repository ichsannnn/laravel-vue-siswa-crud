<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
      $siswa = Siswa::orderBy('nama')->get();
      return response()->json([
        'siswa' => $siswa,
      ], 200);
    }

    public function store(Request $r)
    {
      $this->validate($r, [
        'nis'  => 'required|numeric',
        'nama'  => 'required',
        'kelas' =>  'required'
      ]);

      $siswa = new Siswa;
      $siswa->nis = $r->input('nis');
      $siswa->nama = $r->input('nama');
      $siswa->kelas = $r->input('kelas');
      $siswa->save();

      return response()->json([
        'siswa' => $siswa,
        'message' => 'Data siswa berhasil ditambah!'
      ], 200);
    }

    public function update(Request $r)
    {
      $this->validate($r, [
        'nis'  => 'required|numeric',
        'nama'  => 'required',
        'kelas' =>  'required'
      ]);

      $id = $r->input('id');
      $siswa = Siswa::find($id);
      $siswa->nis = $r->input('nis');
      $siswa->nama = $r->input('nama');
      $siswa->kelas = $r->input('kelas');
      $siswa->save();

      return response()->json([
        'siswa' => $siswa,
        'message' => 'Data siswa berhasil diubah!'
      ], 200);
    }

    public function delete($id)
    {
      $siswa = Siswa::find($id);
      $siswa->delete();

      return response()->json([
        'message' => 'Data siswa berhasil dihapus!'
      ], 200);
    }
}
