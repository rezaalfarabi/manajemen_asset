<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $data['aset'] = DB::table('tb_aset')->count();
        $data['pegawai'] = DB::table('tb_pegawai')->count();
        $data['kategori'] = DB::table('tb_kategori')->count();
        $data['departement'] = DB::table('tb_departement')->count();
        // 

        // hitung data grafik berdasarkan tahun
        $grafik = DB::table('tb_aset')->select(DB::raw('COUNT(*) as total'), 'tb_aset.tahun_pengadaan as tahun_pengadaan')->groupBy('tahun_pengadaan')->get();
        $grafik1 = DB::table('tb_aset')->select(DB::raw('COUNT(*) as total'), 'tb_aset.nama_aset as nama_aset')->groupBy('nama_aset')->get();
        // dd($grafik);
        $array = array();
        $tahun = array();

        $array1 = array();
        $nama_aset = array();
        foreach($grafik as $grafik)
        {
            $array[] = $grafik->total;
            $tahun[] = $grafik->tahun_pengadaan;
        }
        $data['hasil_grafik'] = $array;
        $data['hasil_tahun'] = $tahun;

        foreach($grafik1 as $grafik1)
        {
            $array1[] = $grafik1->total;
            $nama_aset[] = $grafik1->nama_aset;
        }
        $data['hasil_grafik1'] = $array;
        $data['hasil_nama_aset'] = $nama_aset;

        // tampil rekap activity
        $data['activity'] = DB::table('tb_activity')->join('tb_pegawai','tb_pegawai.id_pegawai','tb_activity.id_pegawai')->orderBy('id_activity','DESC')->paginate(5);
        return view('backend.home',$data);
    }
}
