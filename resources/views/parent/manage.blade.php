<x-layout_mainParent>
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Kelola Soal</h1>
        <a href="{{ route('parent.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Tambah Soal</a>

        <table class="mt-4 w-full">
            <thead>
                <tr>
                    <th class="text-left">Level</th>
                    <th class="text-left">Soal</th>
                    <th class="text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                <tr>
                    <td>{{ $question->level }}</td>
                    <td>{{ $question->question }}</td>
                    <td>
                        <a href="{{ route('parent.edit', $question->id) }}" class="text-blue-500">Edit</a> |
                        <form action="{{ route('parent.destroy', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout_mainParent>
