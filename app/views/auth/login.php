<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JFA Equipment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-10 rounded-[2.5rem] shadow-2xl w-full max-w-md border border-gray-100">

    <div class="text-center mb-8">
        <div class="mb-6">
            <img src="assets/img/logo-jfa.png" alt="Logo JFA" class="h-24 mx-auto object-contain">
        </div>

        <h1 class="text-2xl font-black tracking-tight text-gray-800">
            JFA <span class="text-yellow-500">INVENTARIS</span>
        </h1>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">
            JOGJA FILM ACADEMY
        </p>
    </div>

    <!-- ERROR MESSAGE -->
    <?php if (!empty($error)) : ?>
        <div class="bg-red-50 text-red-600 text-xs p-4 rounded-2xl mb-6 font-bold text-center border border-red-100">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <form method="POST" action="index.php?page=login" class="space-y-5">

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">
                Username
            </label>
            <input type="text" name="username" required
                placeholder="Masukkan NIM/Username"
                class="w-full bg-gray-50 border-none p-4 rounded-2xl focus:ring-2 focus:ring-yellow-400 outline-none transition">
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">
                Password
            </label>
            <input type="password" name="password" required
                placeholder="••••••••"
                class="w-full bg-gray-50 border-none p-4 rounded-2xl focus:ring-2 focus:ring-yellow-400 outline-none transition">
        </div>

        <button type="submit"
            class="w-full bg-black text-white py-4 rounded-2xl font-black text-sm tracking-widest hover:bg-gray-800 transition shadow-xl active:scale-95">
            MASUK SEKARANG
        </button>

    </form>

    <p class="mt-8 text-center text-[10px] text-gray-400 font-medium italic">
        Gunakan akun yang terdaftar di biro peralatan JFA.
    </p>

</div>

</body>
</html>
