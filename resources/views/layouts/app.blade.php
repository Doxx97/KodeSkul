<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KodeSkul E-Learning</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    {{-- Memanggil Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font tambahan agar terlihat lebih modern --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- CSS Animasi Kustom --}}
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Animasi getar/pantul halus untuk robot */
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .group-hover\:animate-bounce-slow {
            animation: bounce-slow 1s infinite ease-in-out;
        }

        /* Ikon Pesan di scrollbar chat */
        #chat-messages::-webkit-scrollbar { width: 4px; }
        #chat-messages::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900">

    {{-- ================= NAVBAR MULAI DI SINI ================= --}}
    <nav class="flex justify-between items-center px-6 lg:px-12 py-4 bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        
        <div class="flex items-center gap-10">
            <a href="{{ url('/beranda') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="Logo KodeSkul" class="h-10 w-auto transition-transform group-hover:scale-110">
                
                <span class="text-2xl font-extrabold text-black-600 tracking-tight flex">
                    Kode<span class="text-indigo-600">Skul</span>
                </span>
            </a>

            <div class="hidden md:flex items-center gap-8 font-semibold text-sm">
                <a href="/beranda" class="relative py-2 group {{ request()->is('beranda') ? 'text-indigo-600 font-bold' : 'text-slate-500 hover:text-indigo-600' }} transition-colors duration-300 font-medium">
                    Beranda
                    <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 h-[3px] bg-indigo-600 rounded-t-full transition-all duration-300 {{ request()->is('beranda') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <a href="/progres" class="relative py-2 group {{ request()->is('progres*') ? 'text-indigo-600 font-bold' : 'text-slate-500 hover:text-indigo-600' }} transition-colors duration-300 font-medium">
                    Progres
                    <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 h-[3px] bg-indigo-600 rounded-t-full transition-all duration-300 {{ request()->is('progres*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <a href="/roadmap" class="relative py-2 group {{ request()->is('roadmap*') ? 'text-indigo-600 font-bold' : 'text-slate-500 hover:text-indigo-600' }} transition-colors duration-300 font-medium">
                    Roadmap
                    <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 h-[3px] bg-indigo-600 rounded-t-full transition-all duration-300 {{ request()->is('roadmap*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
            </div>
        </div>

        <div class="flex items-center gap-4">
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="/admin/dashboard" class="hidden md:block text-sm font-bold text-slate-400 hover:text-indigo-600 transition mr-2">
                        Dashboard Admin
                    </a>
                @endif

                <div class="flex items-center gap-3">
                    <a href="/profile" class="flex items-center gap-3 cursor-pointer group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-700 leading-none group-hover:text-indigo-600 transition">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-400 mt-1 capitalize">{{ Auth::user()->role ?? 'Siswa' }}</p>
                        </div>
                        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=e0e7ff&color=4f46e5' }}" 
                             class="w-10 h-10 rounded-full object-cover border-2 border-indigo-50 group-hover:border-indigo-300 transition">
                    </a>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="ml-1 pl-4 border-l border-slate-200">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition rounded-xl hover:bg-red-50" title="Keluar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            @else
                <a href="/login" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-all">
                    Masuk / Daftar
                </a>
            @endauth
        </div>
    </nav>
    {{-- ================= NAVBAR SELESAI ================= --}}

    <main class="min-h-screen relative">
        @yield('content')

        {{-- AREA HELP DESK CHATBOT --}}
        <div id="chatbot-wrapper" class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end pointer-events-none">
            
            <div id="chat-window" class="hidden flex-col bg-white w-[340px] h-[480px] rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-100 overflow-hidden transition-all duration-300 origin-bottom-right mb-5 pointer-events-auto">
                <div class="bg-indigo-600 p-5 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">🤖</div>
                        <div>
                            <h4 class="font-bold text-sm">SkulBot AI</h4>
                            <p class="text-[10px] text-indigo-100">Online</p>
                        </div>
                    </div>
                    <button onclick="toggleChat()" class="hover:bg-white/10 p-2 rounded-full">✕</button>
                </div>

                <div id="chat-messages" class="flex-1 p-5 overflow-y-auto space-y-4 bg-slate-50/50 text-[13px]">
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-slate-700">
                        Halo! Ada yang bisa SkulBot bantu hari ini? 😊
                    </div>
                </div>

                <div class="p-4 bg-white border-t border-slate-100 flex gap-2 items-center">
                    <input type="text" id="user-input" placeholder="Tulis pesan..." 
                        class="w-full bg-slate-100 border-none rounded-full px-5 py-2.5 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                    <button onclick="sendMessage()" class="bg-indigo-600 text-white p-2.5 rounded-full hover:bg-indigo-700 transition-all active:scale-90 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button onclick="toggleChat()" class="w-24 h-24 hover:scale-110 transition-all active:scale-95 pointer-events-auto relative overflow-visible group flex items-center justify-center">
                <div id="chat-icon-msg" class="w-full h-full flex items-center justify-center group-hover:animate-bounce-slow">
                    <img src="{{ asset('storage/bot/mas.png') }}" alt="SkulBot" class="w-full h-full object-contain">
                </div>
                <div id="chat-icon-close" class="hidden w-12 h-12 bg-indigo-600 rounded-full items-center justify-center text-white text-2xl shadow-lg shadow-indigo-200">
                    ✕
                </div>
            </button>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 py-8 mt-12 text-center text-sm text-slate-500">
        <p>&copy; {{ date('Y') }} KodeSkul E-Learning SMK. Dibuat dengan ❤️ untuk pembelajaran.</p>
    </footer>

    <script>
        function toggleChat() {
            const windowEl = document.getElementById('chat-window');
            const iconMsg = document.getElementById('chat-icon-msg');
            const iconClose = document.getElementById('chat-icon-close');
            
            if (windowEl.classList.contains('hidden')) {
                windowEl.classList.replace('hidden', 'flex');
                iconMsg.classList.add('hidden');
                iconClose.classList.remove('hidden');
                iconClose.classList.add('flex');
            } else {
                windowEl.classList.replace('flex', 'hidden');
                iconMsg.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        }

        async function sendMessage() {
            const input = document.getElementById('user-input');
            const container = document.getElementById('chat-messages');
            const userText = input.value.trim();

            if (!userText) return;

            // 1. Tampilkan pesan user
            container.innerHTML += `
                <div class="flex justify-end animate__animated animate__fadeInUp">
                    <div class="bg-indigo-600 p-3 rounded-2xl rounded-tr-none text-white max-w-[80%] shadow-sm">
                        ${userText}
                    </div>
                </div>`;
            
            input.value = "";
            container.scrollTop = container.scrollHeight;

            // 2. Tampilkan indikator mengetik
            const typingId = 'typing-' + Date.now();
            container.innerHTML += `
                <div id="${typingId}" class="flex gap-2 animate__animated animate__fadeIn">
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-slate-400 text-[11px] font-bold">
                        SkulBot sedang berpikir...
                    </div>
                </div>`;
            container.scrollTop = container.scrollHeight;

            try {
                // 3. Kirim ke API Laravel
                const response = await fetch("{{ route('chatbot.send') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ message: userText })
                });

                const data = await response.json();

                // 4. Hapus indikator mengetik dan tampilkan jawaban AI
                document.getElementById(typingId).remove();
                container.innerHTML += `
                    <div class="flex gap-2 items-end">
                        <img src="{{ asset('storage/bot/mas.png') }}" class="w-6 h-6 object-contain mb-1">
                        <div class="bg-white p-3.5 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-slate-700 max-w-[80%]">
                            ${data.reply}
                        </div>
                    </div>`;
            } catch (error) {
                document.getElementById(typingId).innerHTML = "Gagal terhubung ke server.";
            }

            container.scrollTop = container.scrollHeight;
        }

        document.getElementById('user-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    </script>
</body>
</html>