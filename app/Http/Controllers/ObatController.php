<?php

namespace App\Http\Controllers;

use App\Models\obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    // Home
    public function home(){
        return view('Home');
    }

    // Tampil data
    public function index(Request $request){
        if($request->has('search')){
            $data= obat::where('nama','LIKE','%'.$request->search.'%')->paginate(10);
            if($data==null){
                $data = obat::paginate(10);
            }
        }else{
            $data = obat::paginate(10);
        }
        return view('Obatpage', compact('data'));
    }
    
    public function create(Request $request)
    {
        // Validasi data yang dikirimkan
        $request->validate([
            'nama' => 'required|string|max:30',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $newObat = new Obat();
        $newObat->nama = $request->nama;
        $newObat->deskripsi = $request->deskripsi;
        $newObat->harga = $request->harga;
    
        // Mengunggah file foto obat
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->storeAs('foto_obat', $file_name);
            $newObat->foto = $file_path;
        }
    
        $newObat->save();
    
        return redirect('/obat');
    }

    // Update data
    public function updatePage($id_obat){
        $data = obat::find($id_obat);
        // dd($data);
        return view('Editobat',compact('data'));
    }
    public function update(Request $request)
    {
    // Validasi data yang dikirimkan
    $request->validate([
        'id_obat' => 'required|exists:obats,id_obat',
        'nama' => 'required|string|max:30',
        'deskripsi' => 'required|string',
        'harga' => 'required|numeric',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg',
    ]);

    $obat = Obat::find($request->id_obat);
    $obat->nama = $request->nama;
    $obat->deskripsi = $request->deskripsi;
    $obat->harga = $request->harga;

    // Mengunggah file foto obat jika ada
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $file_name = $file->getClientOriginalName();
        $file_path = $file->storeAs('foto_obat', $file_name);
        $obat->foto = $file_path;
    }
    $obat->save();
    return redirect('/obat');
}
    // Delete data
    public function deleteObat($id_obat){
        $data = obat::find($id_obat);
        $data->delete();
        return redirect('/obat');
    }
}
