@extends('layouts.main')

@section('main-content')
    <div class="max-w-5xl mx-auto my-10">

        <form action="{{ route('visit.create') }}" method="POST" enctype="multipart/form-data"
            class="bg-white backdrop-blur-sm  rounded-2xl shadow-xl overflow-hidden">
            @csrf

            <div class="w-full h-2 bg-gray-100">
                <div class="w-0 h-full bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-300"
                    id="progress-bar"></div>
            </div>

            <div class="p-8 pt-0 border-b border-gray-100 mt-5 bg-gradient-to-br from-gray-50/50 to-white">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Pengunjung</h3>
                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-gray-500 mr-2"></i>Nama Lengkap <span
                                    class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-4 transition-all bg-gray-50/50 hover:bg-white @error('full_name') border-red-300 focus:border-red-500 focus:ring-red-100 @else border-gray-200 focus:border-blue-500 focus:ring-blue-100 @enderror"
                                placeholder="Masukkan nama lengkap">
                            @error('full_name')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-id-card text-gray-500 mr-2"></i>NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="identity_number" value="{{ old('identity_number') }}" maxlength="16"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-4 transition-all bg-gray-50/50 hover:bg-white @error('identity_number') border-red-300 focus:border-red-500 focus:ring-red-100 @else border-gray-200 focus:border-blue-500 focus:ring-blue-100 @enderror"
                                placeholder="16 digit NIK">
                            @error('identity_number')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone-alt text-gray-500 mr-2"></i>Nomor Telepon <span
                                    class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number') }}"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-4 transition-all bg-gray-50/50 hover:bg-white @error('phone_number') border-red-300 focus:border-red-500 focus:ring-red-100 @else border-gray-200 focus:border-blue-500 focus:ring-blue-100 @enderror"
                                placeholder="08xxxxxxxxxx">
                            @error('phone_number')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i>Alamat <span
                                    class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="3"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-4 transition-all bg-gray-50/50 hover:bg-white resize-none @error('address') border-red-300 focus:border-red-500 focus:ring-red-100 @else border-gray-200 focus:border-blue-500 focus:ring-blue-100 @enderror"
                                placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-8 border-b border-gray-100 bg-gradient-to-br from-gray-50/50 to-white">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Dokumen Pendukung</h3>

                <div id="documentContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div id="idCardContainer">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-id-card text-gray-500 mr-2"></i>Foto KTP <span class="text-red-500">*</span>
                        </label>
                        <input type="file" id="ktp" name="id_card_image" accept="image/*" class="hidden"
                            onchange="previewImage(event, 'ktp-preview')">
                        <label for="ktp"
                            class="flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-xl cursor-pointer transition-all @error('id_card_image') border-red-300 hover:border-red-400 hover:bg-red-50/30 @else border-gray-200 hover:border-blue-400 hover:bg-blue-50/30 @enderror">
                            <div
                                class="w-16 h-16 mb-3 rounded-full flex items-center justify-center @error('id_card_image') bg-red-50 @else bg-blue-50 @enderror">
                                <i
                                    class="fas fa-image text-2xl @error('id_card_image') text-red-500 @else text-blue-500 @enderror"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700 mb-1"><i class="fas fa-upload mr-1"></i>Klik untuk
                                upload</p>
                            <p class="text-xs text-gray-500"><i class="far fa-file-image mr-1"></i>PNG, JPG maksimal 5MB
                            </p>
                        </label>
                        <div id="ktp-preview" class="mt-4 hidden">
                            <img src="" alt="Preview KTP"
                                class="w-full h-72 object-cover rounded-xl border-2 border-gray-200 shadow-lg">
                        </div>
                        @error('id_card_image')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-camera text-gray-500 mr-2"></i>Foto Selfie <span class="text-red-500">*</span>
                        </label>
                        <input type="file" id="selfie" name="selfie_image" accept="image/*" class="hidden"
                            capture="user" onchange="previewImage(event, 'selfie-preview')">

                        <label for="selfie"
                            class="flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-xl cursor-pointer transition-all @error('selfie_image') border-red-300 hover:border-red-400 hover:bg-red-50/30 @else border-gray-200 hover:border-blue-400 hover:bg-blue-50/30 @enderror">
                            <div
                                class="w-16 h-16 mb-3 rounded-full flex items-center justify-center @error('selfie_image') bg-red-50 @else bg-blue-50 @enderror">
                                <i
                                    class="fas fa-camera text-2xl @error('selfie_image') text-red-500 @else text-blue-500 @enderror"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700 mb-1"><i class="fas fa-upload mr-1"></i>Klik untuk
                                upload</p>
                            <p class="text-xs text-gray-500"><i class="far fa-file-image mr-1"></i>PNG, JPG maksimal 5MB
                            </p>
                        </label>
                        <div id="selfie-preview" class="mt-4 hidden">
                            <img src="" alt="Preview Selfie"
                                class="w-full h-72 object-cover rounded-xl border-2 border-gray-200 shadow-lg">
                        </div>
                        @error('selfie_image')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="p-8 border-b border-gray-100 bg-gradient-to-br from-gray-50/50 to-white">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Kunjungan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt text-gray-500 mr-2"></i>Tanggal Kunjungan <span
                                class="text-red-500">*</span>
                        </label>
                        <input type="date" id="visit-date" name="visit_date" value="{{ old('visit_date') }}"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-4 transition-all bg-gray-50/50 hover:bg-white @error('visit_date') border-red-300 focus:border-red-500 focus:ring-red-100 @else border-gray-200 focus:border-blue-500 focus:ring-blue-100 @enderror">
                        @error('visit_date')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-clock text-gray-500 mr-2"></i>Waktu Check In <span
                                class="text-red-500">*</span>
                        </label>
                        <input type="time" id="check-in" name="check_in" value="{{ old('check_in') }}"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-4 transition-all bg-gray-50/50 hover:bg-white @error('check_in') border-red-300 focus:border-red-500 focus:ring-red-100 @else border-gray-200 focus:border-blue-500 focus:ring-blue-100 @enderror">
                        @error('check_in')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-clipboard-list text-gray-500 mr-2"></i>Tujuan Kunjungan <span
                                class="text-red-500">*</span>
                        </label>
                        <textarea name="purpose" rows="4"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-4 transition-all bg-gray-50/50 hover:bg-white resize-none @error('purpose') border-red-300 focus:border-red-500 focus:ring-red-100 @else border-gray-200 focus:border-blue-500 focus:ring-blue-100 @enderror"
                            placeholder="Jelaskan tujuan kunjungan Anda secara detail">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-gray-50/80 backdrop-blur-sm flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('adminpage.visit.index') }}"
                    class="px-8 py-3 border-2 border-gray-200 text-gray-700 rounded-xl hover:bg-white hover:border-gray-300 transition-all font-medium text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-save mr-2"></i>Simpan Kunjungan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const img = preview.querySelector('img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                    updateProgress();
                }
                reader.readAsDataURL(file);
            }
        }

        function updateProgress() {
            const inputs = document.querySelectorAll('input, textarea, select');
            const filled = Array.from(inputs).filter(input => input.value && input.type !== 'radio').length;
            const total = Array.from(inputs).filter(input => input.type !== 'radio' && input.type !== 'file').length;
            const progress = (filled / total) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const visitDate = document.getElementById('visit-date');
            if (!visitDate.value) {
                visitDate.value = new Date().toISOString().split('T')[0];
            }

            const checkIn = document.getElementById('check-in');
            if (!checkIn.value) {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                checkIn.value = `${hours}:${minutes}`;
            }


            document.querySelectorAll('input, textarea, select').forEach(input => {
                input.addEventListener('input', updateProgress);
                input.addEventListener('change', updateProgress);
            });

            updateProgress();
        });
    </script>
@endpush
