
<x-layout_main>
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Your Profile</h1>
        <div class="bg-white p-4 rounded shadow">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Mother's Name:</strong> {{ $user->mother_name }}</p>
            <p><strong>Age:</strong> {{ $user->age }}</p>
        </div>
    </div>
</x-layout_main>