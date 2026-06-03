<?php
    // AMBIL SEMUA SETTINGAN DESAIN
    $setting = $user->pageSetting;
    
    // 1. Logika Latar Belakang (Background)
    $bgType = $setting->bg_type ?? 'solid';
    $bgColor = $setting->bg_color ?? '#F8FAFC';
    
    // Pastikan path gambar background menggunakan asset() dan storage/
    $bgImage = '';
    if (isset($setting->background_image) && $setting->background_image) {
        $bgImage = asset('storage/' . str_replace('\\', '/', $setting->background_image));
    }
    
    $bgStyle = '';
    if ($bgType === 'solid') {
        $bgStyle = "background-color: {$bgColor};";
    } elseif ($bgType === 'gradient') {
        $bgStyle = "background: linear-gradient(135deg, {$bgColor}, #ffffff);";
    } elseif ($bgType === 'image' && $bgImage) {
        $bgStyle = "background-image: url('{$bgImage}'); background-size: cover; background-position: center; background-attachment: fixed;";
    }

    // 2. Logika Tombol Kustom
    $btnStyle = $setting->button_corner_style ?? 'rounded';
    $btnRadius = $btnStyle === 'square' ? 'rounded-none' : ($btnStyle === 'capsule' ? 'rounded-full' : 'rounded-xl');
    
    $btnDisplay = $setting->button_display_style ?? 'fill';
    $btnColor = $setting->button_color ?? '#8129D9';
    $textColor = $setting->text_color ?? '#FFFFFF';

    // 3. Posisi Ikon Sosial
    $socialPos = $setting->social_position ?? 'bottom';
    
    // 4. Gambar Profil
    $profilePic = 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=000&color=fff';
    if ($user->profile_picture) {
        $profilePic = asset('storage/' . str_replace('\\', '/', $user->profile_picture));
    }

    // 5. Daftar Ikon Platform
    $platformIcons = [
        'instagram' => 'fa-brands fa-instagram',
        'tiktok' => 'fa-brands fa-tiktok',
        'youtube' => 'fa-brands fa-youtube',
        'whatsapp' => 'fa-brands fa-whatsapp',
        'linkedin' => 'fa-brands fa-linkedin',
        'jobstreet' => 'fa-solid fa-briefcase',
        'github' => 'fa-brands fa-github',
        'facebook' => 'fa-brands fa-facebook',
        'x-twitter' => 'fa-brands fa-x-twitter',
        'telegram' => 'fa-brands fa-telegram',
        'shopee' => 'fa-solid fa-bag-shopping',
        'tokopedia' => 'fa-solid fa-store'
    ];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $user->name ?> | SmartLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto; }
    </style>
</head>
<body style="<?= $bgStyle ?>" class="min-h-screen flex flex-col items-center py-12 px-4 relative">

    <div class="flex flex-col items-center mb-8 text-center max-w-md w-full relative z-10">
        <img src="<?= $profilePic ?>" 
             class="w-24 h-24 rounded-full shadow-lg border-4 border-white/20 mb-4 object-cover">
        
        <h1 class="text-[17px] font-bold leading-tight px-2" 
            style="<?= $bgType === 'solid' && $bgColor === '#1E1E1E' ? 'color: white;' : ($bgType === 'image' ? 'color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.8);' : 'color: #111827;') ?>">
            <?= $user->name ?>
        </h1>
        
        <p class="text-[13px] mt-2 font-medium leading-snug px-2"
           style="<?= $bgType === 'solid' && $bgColor === '#1E1E1E' ? 'color: #D1D5DB;' : ($bgType === 'image' ? 'color: #E5E7EB; text-shadow: 0 1px 3px rgba(0,0,0,0.8);' : 'color: #4B5563;') ?>">
            <?= $user->bio ?? 'Welcome to my SmartLink!' ?>
        </p>
    </div>

    <div class="w-full max-w-[640px] space-y-4 relative z-10 flex flex-col items-center">
        
        <?php if($socialPos === 'top'): ?>
            <div class="flex flex-wrap justify-center gap-4 w-full mb-6">
                <?php foreach($links->where('type', 'social') as $link): ?>
                    <a href="<?= route('link.go', $link->id) ?>" target="_blank" class="text-[28px] hover:scale-110 transition-transform drop-shadow-sm"
                       style="<?= $bgType === 'image' ? 'color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));' : 'color: ' . ($textColor === '#FFFFFF' && $bgColor !== '#1E1E1E' ? '#111827' : $textColor) ?>">
                        <i class="<?= $platformIcons[$link->platform] ?? 'fa-solid fa-link' ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="w-full max-w-md space-y-4">
            <?php foreach($links->where('type', 'custom') as $link): ?>
                <?php
                    // Setingan Gaya Tombol
                    if ($btnDisplay === 'fill') {
                        $linkStyle = "background-color: {$btnColor}; color: {$textColor}; border: 2px solid {$btnColor};";
                    } elseif ($btnDisplay === 'outline') {
                        $linkStyle = "background-color: transparent; color: {$btnColor}; border: 2px solid {$btnColor}; backdrop-filter: blur(4px);";
                    } else { 
                        // Mode shadow
                        $linkStyle = "background-color: #ffffff; color: {$btnColor}; border: 2px solid transparent; box-shadow: 0 4px 10px rgba(0,0,0,0.1);";
                    }
                ?>
                <a href="<?= route('link.go', $link->id) ?>" target="_blank"
                   style="<?= $linkStyle ?>"
                   class="flex items-center justify-center w-full py-4 px-6 font-bold hover:scale-[1.02] transition-all relative <?= $btnRadius ?> overflow-hidden">
                   
                   <span class="truncate px-6"><?= $link->title ?></span>

                   <?php if($link->is_private): ?>
                    <i class="fa-solid fa-lock absolute right-6 text-xs opacity-50"></i>
                   <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if($socialPos === 'bottom'): ?>
            <div class="flex flex-wrap justify-center gap-4 w-full mt-6">
                <?php foreach($links->where('type', 'social') as $link): ?>
                    <a href="<?= route('link.go', $link->id) ?>" target="_blank" class="text-[28px] hover:scale-110 transition-transform drop-shadow-sm"
                       style="<?= $bgType === 'image' ? 'color: white; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));' : 'color: ' . ($textColor === '#FFFFFF' && $bgColor !== '#1E1E1E' ? '#111827' : $textColor) ?>">
                        <i class="<?= $platformIcons[$link->platform] ?? 'fa-solid fa-link' ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="mt-auto pt-12 opacity-40 hover:opacity-100 transition relative z-10">
        <p class="text-[10px] font-black uppercase tracking-widest" 
           style="<?= $bgType === 'image' || ($bgType === 'solid' && $bgColor === '#1E1E1E') ? 'color: white;' : 'color: #111827;' ?>">
           SmartLink Bio
        </p>
    </footer>

</body>
</html>