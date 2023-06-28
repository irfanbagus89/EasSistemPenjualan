<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    {{-- Start Content --}}
    <section class="w-full min-h-screen">
        {{-- Start Navbar --}}
        <header class="navbar bg-success text-white">
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl" href="/">Apotekku</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                <li><a href="/obat">Obat</a></li>
                <li>
                    <details>
                    <summary>
                        Transaksi
                    </summary>
                    <ul class="p-2 bg-base-100 text-black">
                        <li><a href="/penjualan">Tambah</a></li>
                        <li><a href="/history">History</a></li>
                    </ul>
                    </details>
                </li>
                </ul>
            </div>
        </header>
        {{-- End Navbar --}}    


        <div class="w-full h-auto p-4">
            <h1 class="p-4 text-4xl font-bold">Daftar Obat</h1>
            <div class="w-full h-auto bg-white rounded-xl shadow-lg p-4 relative mt-4">
                <div class="w-full h-20 flex justify-between">
                    <!-- You can open the modal using ID.showModal() method -->
                    <button class="btn" onclick="my_modal_4.showModal()">Tambah Obat</button>
                    <dialog id="my_modal_4" class="modal h-[600px] mt-20">
                    <form action="/createObat" method="post" class="modal-box w-11/12 h-full max-w-5xl" encType="multipart/form-data">
                        @csrf
                        <div class="w-full h-full p-4 flex flex-col items-center gap-4">
                            <h1 class="p-4 text-4xl font-bold">Tambah Obat</h1>
                            <div class="w-full h-20 flex flex-col gap-4">
                              <label class="text-lg font-medium">Nama</label>
                              <input
                                type="text"
                                placeholder="Masukan Nama"
                                class="input w-full"
                                id="nama"
                                name="nama"
                              />
                            </div>
                            <div class="w-full h-20 flex flex-col gap-4">
                              <label class="text-lg font-medium">Deskripsi</label>
                              <input
                                type="text"
                                placeholder="Masukan Deskripsi"
                                class="input w-full"
                                id="deskripsi"
                                name="deskripsi"
                              />
                            </div>
                            <div class="w-full h-20 flex flex-col gap-4">
                              <label class="text-lg font-medium">Harga</label>
                              <input
                                type="text"
                                placeholder="Masukan Harga"
                                class="input w-full"
                                id="harga"
                                name="harga"
                              />
                            </div>
                            <div class="w-full h-20 flex flex-col gap-4">
                              <label class="text-lg font-medium">Foto</label>
                              <input
                                type="file"
                                class="file-input file-input-bordered w-full"
                                id="foto"
                                name="foto"
                                />
                            </div>
                            <div class="flex justify-end">
                                <button class="btn">Save</button>
                        </form>
                            <form action="" method="dialog">
                                <button class="btn">Close</button>
                            </form>
                            </div>
                    </dialog>
                    {{-- Search --}}
                    <form action="/obat" method="get">
                        <input type="text" placeholder="seacrh" class="input w-full max-w-xs" id="search" name="search"/>
                    </form>
                    {{-- End Search --}}
                </div>
                {{-- Start Tabel Data --}}
                <div class="w-full min-h-[30rem]">
                    <table  class='w-full h-auto text-center border'>
                            <thead class='border-spacing-0 bg-slate-100'>
                                <tr>
                                    <th class='border'>No</th>
                                    <th class='border'>Foto</th>
                                    <th class='border'>Nama Obat</th>
                                    <th class='border'>Deskripsi</th>
                                    <th class='border'>Harga</th>
                                    <th class='border'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $dt)
                                <tr>
                                    <td class='border'>{{$index + $data->firstItem()}}</td>
                                    <td class='border w-12 h-12'><img src='{{asset('storage/'.$dt->foto)}}' alt={{$dt->foto}}></td>
                                    <td class='border'>{{$dt->nama}}</td>
                                    <td class='border max-w-sm'>{{$dt->deskripsi}}</td>
                                    <td class='border'>{{$dt->harga}}</td>
                                    <td class='border flex justify-evenly'>
                                        <div class="w-8 h-11">
                                            <a href="/editObat/{{$dt->id_obat}}">
                                              <img src="{{asset('assets/pencil.svg')}}" class="w-full h-8" alt="">
                                            </a>
                                        </div>
                                        <div class="w-8 h-11">
                                            <a href="/deleteObat/{{$dt->id_obat}}">
                                                <img src="{{asset('assets/trash.svg')}}" class="w-full h-8" alt="">
                                            </a>
                                        </div>
                                    </td>
                                </tr>    
                                @endforeach
                            </tbody>
                    </table>
                    <br />
                    {{ $data->links() }}
                </div>
                {{-- End Tabel Data --}}
                
            </div>
        </div>
        <footer class="footer items-center p-4 bg-neutral text-neutral-content">
            <div class="items-center grid-flow-col">
              <svg width="36" height="36" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" class="fill-current"><path d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z"></path></svg> 
              <p>Copyright © 2023 - All right reserved</p>
            </div> 
            <div class="grid-flow-col gap-4 md:place-self-center md:justify-self-end">
              <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path></svg>
              </a> 
              <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path></svg></a>
              <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path></svg></a>
            </div>
          </footer>
    </section>
    {{-- End Content --}}    
</body>
</html>
