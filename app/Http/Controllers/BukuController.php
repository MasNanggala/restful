<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function getBuku(){
        $search = request()->input('search','');
        $sort = request()->input('sort','id');
        $isasc = request()->input('isasc', 'true');
        $page = request()->input('page',1);
        $size = request()->input('size',5);
        $data = DB::table('mst_buku')
                ->where('nama_buku', 'LIKE',"%$search%")
                ->orwhere('pengarang', 'LIKE',"%$search%")
                ->orwhere('jns_buku', 'LIKE',"%$search%")
                ->orwhere('desc_buku', 'LIKE',"%$search%");
        $data=$isasc=='true' ? $data->orderBy($sort) : $data->orderByDesc($sort);
        $count = $data->count();
        $data = $data->skip($page * $size - $size)->limit($size);
        return[
            "status" => 200,
            "success" => true,
            "data" => $data->get(),
            'totalRows' => $count,
            'totalPage' => ceil($count / $size)
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
            'jns_buku' => $data['jns_buku'],
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
            'jns_buku' => $data['jns_buku'],
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
