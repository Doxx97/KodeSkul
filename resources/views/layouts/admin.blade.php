<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KodeSkul</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Smooth scroll untuk chat messages */
        #chat-messages::-webkit-scrollbar { width: 4px; }
        #chat-messages::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        <>
        /* Animasi getar/pantul halus untuk robot */
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        
        .group-hover\:animate-bounce-slow {
            animation: bounce-slow 1s infinite ease-in-out;
        }

        /* Efek tambahan: Robot sedikit bergoyang (tilt) saat idle */
        #chat-icon-msg img {
            animation: idle-tilt 3s infinite ease-in-out;
        }

        @keyframes idle-tilt {
            0%, 100% { transform: rotate(-2deg); }
            50% { transform: rotate(2deg); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased flex h-screen overflow-hidden">

    <aside class="w-72 bg-slate-900 text-white flex flex-col hidden md:flex shrink-0">
        <div class="p-8 border-b border-slate-800">
            <a href="/" class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500">
                KodeSkul Admin
            </a>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4 mb-4">Menu Utama</p>
            
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-semibold {{ request()->is('admin/dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>📊</span> Dashboard
            </a>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-semibold {{ request()->routeIs('admin.articles.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span>📝</span> Materi Teks (Blog)
            </a>

            <a href="/" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl font-semibold transition">
                <span>🌍</span> Lihat Website
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="w-full py-3 bg-rose-500/10 text-rose-500 font-bold rounded-xl hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center gap-2 text-sm">
                    <span>🚪</span> Log Out
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 relative">
        <header class="bg-white border-b border-slate-100 p-6 flex justify-between items-center z-10">
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Dashboard Control Panel</h2>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">Halo, {{ auth()->user()->name ?? 'Admin' }} 👑</p>
                    <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider">Administrator</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-100 border-2 border-white shadow-sm overflow-hidden flex items-center justify-center font-bold text-indigo-600">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto bg-slate-50/50 p-6 md:p-10">
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>
        </main>

        <div id="chatbot-wrapper" class="fixed bottom-6 right-6 z-[99999] flex flex-col items-end pointer-events-none">
            
            <div id="chat-window" class="hidden flex-col bg-white w-[320px] md:w-[360px] h-[480px] rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-100 overflow-hidden transition-all duration-300 ease-out transform scale-90 translate-y-10 origin-bottom-right mb-5 pointer-events-auto">
                
                <div class="bg-indigo-600 p-5 text-white flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl backdrop-blur-md">🤖</div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-indigo-600 rounded-full"></span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm tracking-tight">SkulBot AI</h4>
                            <p class="text-[10px] text-indigo-100">Online</p>
                        </div>
                    </div>
                    <button onclick="toggleChat()" class="hover:bg-white/10 p-2 rounded-full transition-all text-sm">✕</button>
                </div>

                <div id="chat-messages" class="flex-1 p-5 overflow-y-auto space-y-4 bg-slate-50/50 text-[13px] leading-relaxed">
                    <div class="flex flex-col gap-1 max-w-[85%]">
                        <div class="bg-white p-3.5 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-slate-700">
                            Halo! Ada yang bisa SkulBot bantu hari ini? 😊
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white border-t border-slate-100">
                    <div class="relative flex items-center gap-2">
                        <input type="text" id="user-input" placeholder="Tulis pesan..." 
                            class="w-full bg-slate-100 border-none rounded-full px-5 py-2.5 text-xs focus:ring-2 focus:ring-indigo-500 transition-all outline-none text-slate-600">
                        
                        <button onclick="sendMessage()" class="bg-indigo-600 text-white p-2.5 rounded-full hover:bg-indigo-700 shadow-md transition-all active:scale-90 flex-shrink-0 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <button onclick="toggleChat()" class="w-24 h-24 hover:scale-110 transition-all active:scale-95 pointer-events-auto relative overflow-visible group flex items-center justify-center">
    
                <div id="chat-icon-msg" class="w-full h-full flex items-center justify-center group-hover:animate-bounce-slow">
                    <img src="{{ asset('storage/bot/mas.png') }}" alt="SkulBot" class="w-full h-full object-contain drop-shadow-xl">
                </div>

                <div id="chat-icon-close" class="hidden w-12 h-12 bg-indigo-600 rounded-full items-center justify-center text-white text-2xl transition-all shadow-lg">
                    ✕
                </div>
            </button>
        </div>
    </div>

    <script>
        function toggleChat() {
            const windowEl = document.getElementById('chat-window');
            const iconMsg = document.getElementById('chat-icon-msg');
            const iconClose = document.getElementById('chat-icon-close');
            
            if (windowEl.classList.contains('hidden')) {
                windowEl.classList.replace('hidden', 'flex');
                setTimeout(() => {
                    windowEl.classList.remove('scale-90', 'translate-y-10');
                    windowEl.classList.add('scale-100', 'translate-y-0');
                }, 10);
                iconMsg.classList.add('hidden');
                iconClose.classList.remove('hidden');
                iconClose.classList.add('flex');
            } else {
                windowEl.classList.replace('scale-100', 'scale-90');
                windowEl.classList.add('translate-y-10');
                setTimeout(() => {
                    windowEl.classList.replace('flex', 'hidden');
                    iconMsg.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                    iconClose.classList.remove('flex');
                }, 300);
            }
        }

        function sendMessage() {
            const input = document.getElementById('user-input');
            const container = document.getElementById('chat-messages');
            if (!input.value.trim()) return;

            // Tambah pesan user
            container.innerHTML += `
                <div class="flex flex-col gap-1 max-w-[85%] ml-auto items-end animate__animated animate__fadeInUp animate__faster">
                    <div class="bg-indigo-600 p-3 rounded-2xl rounded-tr-none text-white shadow-sm">${input.value}</div>
                </div>`;
            
            input.value = "";
            container.scrollTop = container.scrollHeight;

            // Simulasi Bot Menjawab
            setTimeout(() => {
                container.innerHTML += `<div id="typing" class="text-[10px] text-slate-400 ml-2 animate-pulse">SkulBot sedang mengetik...</div>`;
                container.scrollTop = container.scrollHeight;

                setTimeout(() => {
                    document.getElementById('typing').remove();
                    container.innerHTML += `
                        <div class="flex flex-col gap-1 max-w-[85%] animate__animated animate__fadeInLeft animate__faster">
                            <div class="bg-white p-3.5 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-slate-700">
                                Pesan Anda telah diterima! Integrasi AI akan segera aktif untuk membantu Anda mengelola materi KodeSkul.
                            </div>
                        </div>`;
                    container.scrollTop = container.scrollHeight;
                }, 1500);
            }, 500);
        }

        document.getElementById('user-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    </script>

</body>
</html>