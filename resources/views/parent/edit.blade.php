<x-layout_main>
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Edit Question</h1>

        <form action="{{ route('parent.update', $question->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="level" class="block text-sm font-medium">Level</label>
                <input type="text" id="level" name="level" value="{{ old('level', $question->level) }}" class="mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="question" class="block text-sm font-medium">Soal</label>
                <input type="text" id="question" name="question" value="{{ old('question', $question->question) }}" class="mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="question_desc" class="block text-sm font-medium">Deskripsi Soal (Opsional)</label>
                <textarea id="question_desc" name="question_desc" class="mt-1 block w-full">{{ old('question_desc', $question->question_desc) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium">Gambar Soal (Opsional)</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full">
                @if($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="mt-2 w-32">
                @endif
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Update</button>
        </form>
    </div>
</x-layout_main>