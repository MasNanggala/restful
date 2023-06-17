<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function getBuku(){
        $data = DB::table('mst_buku')->get();
        return[
            "status" => 200,
            "success" => true,
            "data" => $data,
        ];
    }

    public function getByID($id){
        $buku=DB::table('mst_buku')->where('id',$id)->first();
        if($buku){
            return response()->json($buku);
        } else{
            return[
            "status" => 404,
            "success" => false,
            "message" => 'Data tidak ditemukan!',
            ];
        }
    }

    public function insertBuku(){
        $data = request()->all();
        $buku = [
            'nama_buku' => $data['nama_buku'],
            'tahun_buku' => $data['tahun_buku'],
            'pengarang' => $data['pengarang'],
            'id_jns_buku' => $data['id_jns_buku'],
            'desc_buku' => $data['desc_buku'],
        ];
        try{
            DB::table('mst_buku')->insert($buku);
            return [
            "status" => 201,
            "success" => true,
            "message" => 'Penginputan data berhasil!',
            ];

        }catch(\Exception $ex){
            $message=$ex->getMessage();
            return response()->json([
            "status" => 400,
            "success" => false,
            "data" => $message,
            ],400);
        }
    }

    public function updateBuku($id){
        $data = request()->all();
        $buku = [
            'id' => $data['id'],
            'nama_buku' => $data['nama_buku'],
            'tahun_buku' => $data['tahun_buku'],
            'pengarang' => $data['pengarang'],
            'id_jns_buku' => $data['id_jns_buku'],
            'desc_buku' => $data['desc_buku'],
        ];
        try{
            DB::table('mst_buku')->where('id',$id)->update($buku);
            return [
            "status" => 201,
            "success" => true,
            "message" => 'Perubahan data berhasil!',
            ];

        }catch(\Exception $ex){
            $message=$ex->getMessage();
            return response()->json([
            "status" => 400,
            "success" => false,
            "data" => $message,
            ],400);
        }
    }

    public function deleteBuku($id){
        try{
            DB::table('mst_buku')->where('id',$id)->delete();
            return [
            "status" => 201,
            "success" => true,
            "message" => 'Penghapusan data berhasil!',
            ];

        }catch(\Exception $ex){
            $message=$ex->getMessage();
            return response()->json([
            "status" => 400,
            "success" => false,
            "data" => $message,
            ],400);
        }
    }

}
