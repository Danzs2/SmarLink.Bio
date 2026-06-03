<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akses Terbatas | SmartLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-[24px] shadow-xl shadow-slate-200/50 w-full max-w-md border border-gray-100">
        
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-lock text-2xl"></i>
            </div>
            <h2 class="text-xl font-black text-gray-900">Tautan Terlindungi</h2>
            <p class="text-gray-500 text-sm mt-1">Silakan masukkan akses untuk membuka <br><strong class="text-gray-900"><?= $link->title ?></strong></p>
        </div>

        <?php if(session('error')): ?>
            <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-xl text-sm font-bold text-center mb-5 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> <?= session('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= route('link.verify', $link->id) ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <?php if($link->link_password): ?>
                <input type="password" name="password" placeholder="Masukkan Password Akses" required
                    class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl px-5 py-4 focus:border-indigo-500 outline-none transition-all font-bold text-center tracking-widest text-gray-900 placeholder:tracking-normal placeholder:font-medium">
            <?php else: ?>
                <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 text-left mb-4">
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1">Login sebagai:</p>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-user text-indigo-400 text-2xl"></i>
                        <span class="text-sm font-bold text-gray-900"><?= optional(Auth::user())->email ?></span>
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 text-center font-medium">Klik konfirmasi untuk mengecek izin akses email kamu.</p>
            <?php endif; ?>
            
            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform active:scale-95 mt-2">
                <?= $link->link_password ? 'Buka Tautan' : 'Konfirmasi Akses' ?>
            </button>
        </form>

    </div>
</body>
</html>