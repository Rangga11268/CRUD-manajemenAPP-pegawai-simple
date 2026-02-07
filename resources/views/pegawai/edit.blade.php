<x-app-layout>
    <div class="my-6 p-5 max-w-4xl mx-auto rounded-lg shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center border-b pb-4">
            <h3 class="text-xl font-semibold text-gray-200">Edit Data Pegawai: {{ $pegawai->nama_pegawai }}</h3>
            <a href="{{ route('pegawai.index') }}"
                class="mt-4 sm:mt-0 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>

        <div>
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-300 border-b border-gray-600 pb-2">Informasi Dasar</h4>
                        
                        <div>
                            <x-input-label for="employee_id" :value="__('ID Pegawai (NIP):')" />
                            <x-text-input id="employee_id" class="block mt-1 w-full" type="text" name="employee_id"
                                value="{{ old('employee_id', $pegawai->employee_id) }}" required />
                            <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nik" :value="__('NIK (KTP):')" />
                            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik"
                                value="{{ old('nik', $pegawai->nik) }}" required minlength="16" maxlength="16" />
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_pegawai" :value="__('Nama Lengkap:')" />
                            <x-text-input id="nama_pegawai" class="block mt-1 w-full" type="text" name="nama_pegawai"
                                value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" required />
                            <x-input-error :messages="$errors->get('nama_pegawai')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="email" :value="__('Email:')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                value="{{ old('email', $pegawai->email) }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="gender" :value="__('Jenis Kelamin:')" />
                            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender', $pegawai->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $pegawai->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir:')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir?->format('Y-m-d')) }}" required />
                            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Work Info -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-300 border-b border-gray-600 pb-2">Informasi Pekerjaan</h4>

                        <div>
                            <x-input-label for="department_id" :value="__('Department:')" />
                            <select id="department_id" name="department_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Pilih Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $pegawai->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jabatan_id" :value="__('Jabatan:')" />
                            <select id="jabatan_id" name="jabatan_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Pilih Jabatan</option>
                                @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}" {{ old('jabatan_id', $pegawai->jabatan_id) == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama_jabatan }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jabatan_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status Kepegawaian:')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="aktif" {{ old('status', $pegawai->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="cuti" {{ old('status', $pegawai->status) == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="resign" {{ old('status', $pegawai->status) == 'resign' ? 'selected' : '' }}>Resign</option>
                                <option value="pensiun" {{ old('status', $pegawai->status) == 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_masuk" :value="__('Tanggal Masuk:')" />
                            <x-text-input id="tanggal_masuk" class="block mt-1 w-full" type="date" name="tanggal_masuk"
                                value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk?->format('Y-m-d')) }}" required />
                            <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="gaji_pokok" :value="__('Gaji Pokok:')" />
                            <x-text-input id="gaji_pokok" class="block mt-1 w-full" type="number" name="gaji_pokok"
                                value="{{ old('gaji_pokok', $pegawai->gaji_pokok) }}" required min="0" step="1000" />
                            <x-input-error :messages="$errors->get('gaji_pokok')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="user_id" :value="__('Akun User (Login):')" />
                            <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Tidak terhubung ke akun user --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $pegawai->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Pilih user jika pegawai ini bisa login ke sistem.</p>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div class="space-y-4">
                         <h4 class="text-lg font-medium text-gray-300 border-b border-gray-600 pb-2">Kontak & Lainnya</h4>
                         
                         <div>
                            <x-input-label for="alamat" :value="__('Alamat Domisili:')" />
                            <textarea id="alamat" name="alamat" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('alamat', $pegawai->alamat) }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="telepon" :value="__('No. Telepon / WhatsApp:')" />
                            <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon"
                                value="{{ old('telepon', $pegawai->telepon) }}" required />
                            <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                        </div>

                        <div class="mt-2">
                             <x-input-label for="image" class="mb-2" :value="__('Upload Foto Profil:')" />
        
                             <div class="sm:flex items-center gap-x-4">
                                 <div class="flex-shrink-0">
                                     @if ($pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png')
                                         <img src="{{ asset('storage/' . $pegawai->image) }}"
                                             alt="Foto {{ $pegawai->nama_pegawai }}" class="h-24 w-24 rounded-full object-cover border-2 border-gray-600">
                                     @else
                                         <span class="inline-block h-24 w-24 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700">
                                             <svg class="h-full w-full text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                                 <path d="M24 20.993V24H0v-2.997A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                             </svg>
                                         </span>
                                     @endif
                                 </div>
                                 <div class="flex-grow mt-2 sm:mt-0">
                                     <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                                     <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">WEBP, PNG, JPG, JPEG or GIF (MAX 2MB).</p>
                                 </div>
                             </div>
                             <x-input-error :messages="$errors->get('image')" class="mt-2" />
                         </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 border-t border-gray-600 pt-4">
                    <a href="{{ route('pegawai.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Update Data Pegawai</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
