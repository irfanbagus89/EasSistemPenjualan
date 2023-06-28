<?php

namespace App\Http\Controllers;

use App\Models\penjualan;
use App\Models\obat;
use App\Models\detailpen;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function history(){
        $dataPen = Penjualan::where('no_order', '!=', 'Keranjang')->get();
        // dd($dataPen);
        $detail = DetailPen::whereIn('id_pen', $dataPen->pluck('id_pen'))->with('obat')->get();

        return view('Historypage', compact('dataPen', 'detail'));
    }

    // Tampil data
    public function index(Request $request){
        $search = $request->input('search');
        $dataObat = Obat::query()->where('nama', 'LIKE', "%{$search}%")->orWhere('deskripsi', 'LIKE', "%{$search}%")->get();
        $keranjang = Penjualan::where('no_order', 'Keranjang')->first();

        if ($keranjang) {
            $totalHarga = $keranjang->total_price;
            $obatList = $keranjang->detailPen()->with('obat')->get();
            // dd($obatList);
            // dd($totalHarga);
            return view('Penjualanpage', compact('obatList','dataObat','totalHarga'));
        }
        return view('Penjualanpage',compact('dataObat'));
    }
    
    public function addCart($id_obat){
    // Mendapatkan data obat berdasarkan ID
        $obat = Obat::findOrFail($id_obat);
        $keranjang = Penjualan::where('no_order', 'Keranjang')->first();

        if ($keranjang) {
            // Cek apakah obat sudah ada dalam keranjang
            $detailPen = DetailPen::where('id_pen', $keranjang->id_pen)->where('id_obat', $obat->id_obat)->first();
            if ($detailPen) {
                // Obat sudah ada dalam keranjang, tambahkan qty
                $detailPen->qty += 1;
                $detailPen->save();
            } else {
                // Obat belum ada dalam keranjang, buat entri baru dalam tabel "detailpens"
                $detailPen = new DetailPen();
                $detailPen->id_pen = $keranjang->id_pen;
                $detailPen->id_obat = $obat->id_obat;
                $detailPen->qty = 1; // Jumlah obat diatur ke 1
                $detailPen->save();
            }

            // Update total harga di penjualan
            $keranjang->total_price += $obat->harga;
            $keranjang->save();
        } else {
            // Membuat keranjang dalam tabel
            $penjualan = new Penjualan();
            $penjualan->no_order = 'Keranjang';
            $penjualan->paid_amount = 0; 
            $penjualan->total_price = $obat->harga; 
            $penjualan->save();


            // Membuat entri baru dalam tabel "detailpens" untuk obat yang ditambahkan ke keranjang
            $detailPen = new DetailPen();
            $detailPen->id_pen = $penjualan->id_pen;
            $detailPen->id_obat = $obat->id_obat;
            $detailPen->qty = 1; 
            $detailPen->save();
        }

        // Redirect ke halaman keranjang atau obat lainnya
        return redirect('/penjualan');
    }
 
    
    public function bayar(Request $request){
        // Mendapatkan keranjang yang aktif dengan nomor order "Keranjang"
        $keranjang = Penjualan::where('no_order', 'Keranjang')->first();
        if ($keranjang) {
            // Menghasilkan nomor order acak
            $nomorOrder = 'OR' . Str::random(7);
            // Mengganti nomor order keranjang dengan nomor order acak yang baru
            $keranjang->no_order = $nomorOrder;
            // Menghitung total harga dalam keranjang
            $totalPrice = $keranjang->total_price;

            // Validasi paid_amount harus lebih besar atau sama dengan total_price
            if ($request->paid_amount >= $totalPrice) {
                $keranjang->paid_amount = $request->paid_amount;
                $keranjang->save();

                $detailPens = DetailPen::where('id_pen', $keranjang->id_pen)->get();
                foreach ($detailPens as $detailPen) {
                    $obatId = $detailPen->id_obat;
                    $qty = $request->input('qty_'.$obatId);

                    // Mengupdate jumlah obat (qty) di dalam keranjang
                    $detailPen->qty = $qty;
                    $detailPen->save();
                }

                return redirect('/penjualan');
            } else {
                return redirect('/penjualan');
            }
        }

        return redirect('/penjualan');
    }

    
    public function hapusBarang($id){
        $detailPen = DetailPen::find($id);

        if ($detailPen) {
            $penjualan = Penjualan::find($detailPen->id_pen);
            $obat = Obat::find($detailPen->id_obat);

            if ($penjualan && $obat) {
                $hargaBarang = $obat->harga * $detailPen->qty;

                // Mengurangi harga barang yang dihapus dari total harga penjualan
                $penjualan->total_price -= $hargaBarang;
                $penjualan->save();

                $detailPen->delete();
            }
        }

        return redirect('/penjualan');
    }
}

