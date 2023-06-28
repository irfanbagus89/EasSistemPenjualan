<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body>

    
    <div class="w-full min-h-screen">
        
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
        
    
        <section class="w-full h-auto p-4">
            <h1 class="p-4 text-4xl font-bold">Penjualan</h1>
            <br>
            <div class="w-full h-full flex justify-between">
                
                <div class="w-3/4 h-auto rounded-2xl shadow-xl p-8">
                    <div class="w-full h-auto flex justify-between">
                        <h2 class="text-2xl font-medium">Daftar Obat</h2>
                        <form action="" method="get">
                            <input type="text" placeholder="seacrh" class="input w-full max-w-xs" id="search" name="search"/>
                        </form>
                    </div>
                    <div class="w-full h-auto flex gap-12 flex-wrap py-4">
                       
                        <?php $__currentLoopData = $dataObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
                        <div class="card card-compact w-96 bg-base-100 shadow-xl">
                            <figure><img src="<?php echo e(asset('storage/'.$dt->foto)); ?>" alt="<?php echo e($dt->foto); ?>" /></figure>
                            <div class="card-body">
                            <h2 class="card-title"><?php echo e($dt->nama); ?>!</h2>
                            <h3><?php echo e($dt->deskripsi); ?></h3>
                            <h4>Rp <?php echo e($dt->harga); ?></h4>
                            <form action="/addCart/<?php echo e($dt->id_obat); ?>" method="get">
                                <div class="card-actions justify-end">
                                    <button class="btn btn-primary">ADD Cart</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>
                
                </div>
                

                
                <div class="w-[22%] h-[35rem] rounded-2xl shadow-xl p-4 relative">
                    <div class="w-full min-h-[23rem] relativ">
                        <div class="absolute right-5 top-0" method="get">
                            <?php if(isset($obatList) && $obatList->isNotEmpty()): ?>
                                <?php $__currentLoopData = $obatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <a href="/cart/hapus/<?php echo e($cart->id_detail); ?>">
                                    <img src="<?php echo e(asset('assets/x.svg')); ?>" class="w-4 h-4 block mb-28" alt="">
 
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <?php endif; ?>
                        </div>
                        <form action="/bayar" method="post">
                            <?php echo csrf_field(); ?>
                        <?php if(isset($obatList) && $obatList->isNotEmpty()): ?>
                            <?php $__currentLoopData = $obatList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                            <div class="w-full h-24 rounded-xl shadow-xl flex gap-4 items-center px-4 mb-4">
                                <img src="<?php echo e(asset('storage/'.$cart->obat->foto)); ?>" class="w-16 h-16 rounded-2xl" alt="">
                                <div class="w-40 h-20">
                                    <h2><?php echo e($cart->obat->nama); ?></h2>
                                    <h3><?php echo e($cart->obat->harga); ?></h3>
                                </div>
                                <div class="">
                                    <input type="text" class="border w-10 text-center" id="qty_<?php echo e($cart->id_obat); ?>" name="qty_<?php echo e($cart->id_obat); ?>" min="1" readonly value="<?php echo e($cart->qty); ?>">
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            
                        <?php endif; ?>
                        </div>
                            <div class="w-full">
                                <?php if(isset($totalHarga) && $totalHarga > 0): ?>
                                <label class="label">
                                <span class="label-text">Total</span>
                                </label>
                                <input type="text" class="input input-bordered w-full max-w-xs h-8" value="<?php echo e($totalHarga); ?>" readonly/>
                                    
                                <?php else: ?>
                                <label class="label">
                                    <span class="label-text">Total</span>
                                    </label>
                                    <input type="text" class="input input-bordered w-full max-w-xs h-8" readonly/>                               
                                <?php endif; ?>
                            </div>
                            <div class="w-full justify-end">
                                <label class="label">
                                <span class="label-text">Bayar</span>
                                </label>
                                <input type="text" placeholder="Type here" class='border rounded-lg w-60 h-8 p-4' value="" id="paid_amount" name="paid_amount">
                                <button class="btn btn-primary">Bayar</button>
                            </div>
                        </form>
                </div>
                
            </div>
        </section>
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
    </div>
    
</body>
</html><?php /**PATH C:\Users\USER\Desktop\eas065\resources\views/Penjualanpage.blade.php ENDPATH**/ ?>