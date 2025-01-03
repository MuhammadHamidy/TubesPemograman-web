
<x-layout_main>
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Manage Questions</h1>
        <a href="{{ route('parent.create') }}" class="px-4 py-2 bg-green-500 text-white rounded mb-4">Add New Question</a>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Level</th>
                    <th class="py-2">Question</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                <tr>
                    <td class="py-2">{{ $question->id }}</td>
                    <td class="py-2">{{ $question->level }}</td>
                    <td class="py-2">{{ $question->question }}</td>
                    <td class="py-2">
                        <a href="{{ route('parent.edit', $question->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded">Edit</a>
                        <form action="{{ route('parent.destroy', $question->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout_main>