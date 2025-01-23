<x-layout_mainParent>
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Tambah Soal</h1>

        <form action="{{ route('parent.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="level" class="block text-sm font-medium">Level</label>
                <select id="level" name="level" class="mt-1 block w-full" required>
                    <option value="motorik-1">Motorik I - Tebak Warna</option>
                    <option value="motorik-2">Motorik II - Berhitung</option>
                    <option value="motorik-3">Motorik III - Membaca</option>
                    <option value="motorik-4">Motorik IV - Tebak Bentuk</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="question" class="block text-sm font-medium">Soal</label>
                <input type="text" id="question" name="question" value="{{ old('question') }}" class="mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="question_desc" class="block text-sm font-medium">Deskripsi Soal (Opsional)</label>
                <textarea id="question_desc" name="question_desc" class="mt-1 block w-full">{{ old('question_desc') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium">Gambar Soal (Opsional)</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full">
            </div>

            <h2 class="mt-6 text-lg font-bold">Opsi Jawaban</h2>
            <div id="options-container">
                <div class="option mb-4">
                    <label class="block">Tipe Opsi</label>
                    <select name="options[0][type]" class="mb-2">
                        <option value="text">Teks</option>
                        <option value="image">Gambar</option>
                    </select>
                    <label class="block">Nilai Opsi</label>
                    <input type="text" name="options[0][value]" class="mt-1 block w-full mb-2" required>
                    <label class="block">Gambar Opsi (opsional)</label>
                    <input type="file" name="options[0][image]" class="mt-1 block w-full">
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Tambah Soal</button>
        </form>
    </div>
    <script>
        let optionCount = 1;
        document.getElementById('add-option').addEventListener('click', () => {
            const newOption = document.createElement('div');
            newOption.classList.add('option', 'mb-4');
            newOption.innerHTML = `
                <label class="block">Tipe Opsi</label>
                <select name="options[${optionCount}][type]" class="mb-2">
                    <option value="text">Teks</option>
                    <option value="image">Gambar</option>
                </select>
                <label class="block">Nilai Opsi</label>
                <input type="text" name="options[${optionCount}][value]" class="mt-1 block w-full mb-2" required>
                <label class="block">Gambar Opsi (opsional)</label>
                <input type="file" name="options[${optionCount}][image]" class="mt-1 block w-full">
            `;
            document.getElementById('options-container').appendChild(newOption);
            optionCount++;
        });
    </script>    
</x-layout_mainParent>
