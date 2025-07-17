<div class="flex flex-col w-64 h-screen text-gray-900 bg-white shadow-md">
    {{-- <div class="flex items-center justify-center h-16 bg-gray-300">
        <h1 class="text-2xl font-semibold">Dashboard</h1>
    </div> --}}

    <div class="flex-1 overflow-y-auto">
        <nav class="mt-6">
            <ul id="sidebarMenu">
                <!-- Menu Item 1 -->
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="menu-item flex items-center px-4 py-3 text-sm font-medium
                              {{ request()->routeIs('admin.dashboard') ? 'text-indigo-500' : 'text-gray-500' }}
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
                    <a href="{{ route('admin.users.index') }}"
                        class="menu-item flex items-center px-4 py-3 text-sm font-medium
                              {{ request()->routeIs('admin.users.index') ? 'text-indigo-500' : 'text-gray-500' }}
                              rounded-md cursor-pointer transition duration-200 ease-in-out
                              hover:bg-gray-100 hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                        Kelola Akun
                    </a>
                </li>

                <!-- Menu Item Biodata dengan Dropdown -->
                <li x-data="{ open: {{ request()->routeIs('admin.guru.index') || request()->routeIs('admin.siswa.index') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="menu-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium
                            {{ request()->routeIs('admin.guru.index') || request()->routeIs('admin.siswa.index') ? 'text-indigo-500' : 'text-gray-500' }}
                            rounded-md cursor-pointer transition duration-200 ease-in-out
                            hover:bg-gray-100 hover:scale-[1.02]">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Biodata
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" x-transition class="mt-1 ml-8 space-y-1">
                        <li>
                            <a href="{{ route('admin.guru.index') }}"
                                class="block px-2 py-2 text-sm rounded-md transition duration-200 ease-in-out
                                {{ request()->routeIs('admin.guru.index') ? 'text-indigo-500' : 'text-gray-500' }}
                                hover:bg-gray-100 hover:text-indigo-600">
                                Data Guru
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.siswa.index') }}"
                                class="block px-2 py-2 text-sm rounded-md transition duration-200 ease-in-out
                                {{ request()->routeIs('admin.siswa.index') ? 'text-indigo-500' : 'text-gray-500' }}
                                hover:bg-gray-100 hover:text-indigo-600">
                                Data Siswa
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Menu Item Data Akademik dengan Dropdown -->
                <li x-data="{ open: {{ request()->routeIs('admin.kelas_tahfidz.index') || request()->routeIs('admin.tahun_ajaran.index') || request()->routeIs('admin.tahun_angkatan.index') || request()->routeIs('admin.surah.index') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="menu-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium
                            {{ request()->routeIs('admin.kelas_tahfidz.index') || request()->routeIs('admin.tahun_ajaran.index') || request()->routeIs('admin.tahun_angkatan.index') || request()->routeIs('admin.surah.index') ? 'text-indigo-500' : 'text-gray-500' }}
                            rounded-md cursor-pointer transition duration-200 ease-in-out
                            hover:bg-gray-100 hover:scale-[1.02]">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                            </svg>
                            Akademik
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" x-transition class="mt-1 ml-8 space-y-1">
                        <li>
                            <a href="{{ route('admin.tahun_ajaran.index') }}"
                                class="block px-2 py-2 text-sm rounded-md transition duration-200 ease-in-out
                                {{ request()->routeIs('admin.tahun_ajaran.index') ? 'text-indigo-500' : 'text-gray-500' }}
                                hover:bg-gray-100 hover:text-indigo-600">
                                Tahun Ajaran
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tahun_angkatan.index') }}"
                                class="block px-2 py-2 text-sm rounded-md transition duration-200 ease-in-out
                                {{ request()->routeIs('admin.tahun_angkatan.index') ? 'text-indigo-500' : 'text-gray-500' }}
                                hover:bg-gray-100 hover:text-indigo-600">
                                Tahun Angkatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.kelas_tahfidz.index') }}"
                                class="block px-2 py-2 text-sm rounded-md transition duration-200 ease-in-out
                                {{ request()->routeIs('admin.kelas_tahfidz.index') ? 'text-indigo-500' : 'text-gray-500' }}
                                hover:bg-gray-100 hover:text-indigo-600">
                                Kelas Tahfidz
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.surah.index') }}"
                                class="block px-2 py-2 text-sm rounded-md transition duration-200 ease-in-out
                                {{ request()->routeIs('admin.surah.index') ? 'text-indigo-500' : 'text-gray-500' }}
                                hover:bg-gray-100 hover:text-indigo-600">
                                Al-Quran
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Menu Item 6 -->
                <li>
                    <a href="{{ route('admin.manajemen_siswa_kelas.index') }}"
                        class="menu-item flex items-center px-4 py-3 text-sm font-medium
                        {{ request()->routeIs('admin.manajemen_siswa_kelas.index') ? 'text-indigo-500' : 'text-gray-500' }}
                         rounded-md cursor-pointer transition duration-200 ease-in-out
                         hover:bg-gray-100 hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                        Manajemen Kelas Siswa
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
