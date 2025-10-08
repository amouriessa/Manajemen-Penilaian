<div class="flex flex-col w-64 h-screen text-gray-900 bg-white shadow-md">
    {{-- <div class="flex items-center justify-center h-16 bg-gray-300">
        <h1 class="text-2xl font-semibold">Dashboard</h1>
    </div> --}}

    <div class="flex-1 overflow-y-auto">
        <nav class="mt-6">
            <ul id="sidebarMenu">
                <!-- Menu Item 1 -->
                <li>
                    <a href="{{ route('teacher.dashboard') }}"
                        class="menu-item flex items-center px-4 py-3 text-sm font-medium
                              {{ request()->routeIs('teacher.dashboard') ? 'text-indigo-500' : 'text-gray-500' }}
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
                        class="menu-item flex items-center px-4 py-3 text-sm font-medium
                              {{ request()->routeIs('teacher.tugas_hafalan.index') ? 'text-indigo-500' : 'text-gray-500' }}
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
                        class="menu-item flex items-center px-4 py-3 text-sm font-medium
                                {{ request()->routeIs('teacher.pengumpulan.index') ? 'text-indigo-500' : 'text-gray-500' }}
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
                        class="menu-item flex items-center px-4 py-3 text-sm font-medium
                            {{ request()->routeIs('teacher.penilaian.langsung.index') ? 'text-indigo-500' : 'text-gray-500' }}
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
                    <a href="{{ route('teacher.laporankelas.index') }}"
                        class="menu-item flex items-center px-4 py-3 text-sm font-medium
                        {{ request()->routeIs('teacher.laporankelas.index') ? 'text-indigo-500' : 'text-gray-500' }}
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
