<div class="flex flex-col w-64 h-screen bg-[#1E2A40] text-[rgba(215,228,248,0.75)] shadow-md">
    @php
        $baseMenu = 'menu-item flex items-center gap-3 px-4 py-2.5 mx-2 mt-1 rounded-lg text-sm font-medium
             cursor-pointer transition-all duration-150
             hover:bg-white/5 hover:text-[rgba(215,228,248,0.95)]';

        $activeMenu = 'bg-[linear-gradient(135deg,rgba(212,163,85,0.18),rgba(212,163,85,0.08))]
             text-[#E8C990] border border-[#D4A355]/20';

        $inactiveMenu = 'text-[rgba(215,228,248,0.65)]';
    @endphp

    <!-- HEADER -->
    <li class="relative px-4 py-6 mb-4 text-center border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-3">
            <div class="flex items-center justify-center w-12 h-12">
                <x-application-logo class="text-white w-7 h-7" />
            </div>

            <div>
                <p class="font-serif text-sm font-medium leading-tight text-white">
                    SMP Islamiyah
                </p>
                <p class="text-[10px] tracking-wide text-[#E8C990]">
                    Widodaren · Ngawi
                </p>
            </div>
        </a>
    </li>

    <div class="flex-1 overflow-y-auto sidebar-scroll">
        <nav class="mt-6">
            <ul id="sidebarMenu">
                <!-- Menu Item 1 -->
                <li>
                    <a href="{{ route('teacher.dashboard') }}"
                        class="{{ $baseMenu }}
                              {{ request()->routeIs('teacher.dashboard') ? $activeMenu : $inactiveMenu }}
                              rounded-md cursor-pointer transition duration-200 ease-in-out
                              hover:bg-gray-100 hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>
                </li>

                <!-- Menu Item 2 -->
                <li>
                    <a href="{{ route('teacher.tugas_hafalan.index') }}"
                        class="{{ $baseMenu }}
                              {{ request()->routeIs('teacher.tugas_hafalan.index') ? $activeMenu : $inactiveMenu }}
                              rounded-md cursor-pointer transition duration-200 ease-in-out
                              hover:bg-gray-100 hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Tugas Hafalan
                    </a>
                </li>

                <!-- Menu Item 3 -->
                <li>
                    <a href="{{ route('teacher.pengumpulan.index') }}"
                        class="{{ $baseMenu }}
                                {{ request()->routeIs('teacher.pengumpulan.index') ? $activeMenu : $inactiveMenu }}
                                rounded-md cursor-pointer transition duration-200 ease-in-out
                                hover:bg-gray-100 hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                        </svg>

                        Pengumpulan
                    </a>
                </li>

                <!-- Menu Item 4 -->
                <li>
                    <a href="{{ route('teacher.penilaian.langsung.index') }}"
                        class="{{ $baseMenu }}
                            {{ request()->routeIs('teacher.penilaian.langsung.index') ? $activeMenu : $inactiveMenu }}
                             rounded-md cursor-pointer transition duration-200 ease-in-out
                              hover:bg-gray-100 hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M9 5H7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2h-2" />
                            <rect x="9" y="3" width="6" height="4" rx="2" />
                            <path d="M9 14l2 2l4 -4" />
                        </svg>
                        Penilaian
                    </a>
                </li>

                <!-- Menu Item 6 -->
                <li>
                    <a href="{{ route('teacher.laporan.index') }}"
                        class="{{ $baseMenu }}
                        {{ request()->routeIs('teacher.laporankelas.index') ? $activeMenu : $inactiveMenu }}
                         rounded-md cursor-pointer transition duration-200 ease-in-out
                         hover:bg-gray-100 hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>

                        Laporan Siswa
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
