<x-layout_landingPage>
    <div class="container mx-auto p-4">
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-lg max-w-2xl mx-auto">
            <div class="flex flex-col items-center">
                <h1 class="text-2xl font-bold text-blue-900 mb-6">Progress Belajar {{ $child->name }}</h1>
                
                <!-- Profile Info -->
                <div class="text-center mb-8">
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 border-4 border-blue-500 mx-auto mb-4">
                        <img src="{{ $child->profile_picture ? asset('storage/' . $child->profile_picture) : asset('img/default-profile.png') }}" 
                             alt="Profile Picture" 
                             class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-xl font-semibold">{{ $child->name }}</h2>
                    <p class="text-gray-600">Total Points: {{ $child->points ?? 0 }}</p>
                </div>

                <!-- Progress Chart -->
                <div id="progressChart" class="w-full" style="height: 300px;"></div>

                <!-- Detail Progress -->
                <div class="w-full mt-8">
                    <h3 class="text-xl font-semibold mb-4 text-center">Detail Perkembangan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Motorik I</h4>
                            <p class="text-gray-600">Progress: {{ min(100, ($child->points / 300) * 100) }}%</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg">
                            <h4 class="font-semibold text-green-800">Motorik II</h4>
                            <p class="text-gray-600">Progress: {{ max(0, min(100, (($child->points - 300) / 300) * 100)) }}%</p>
                        </div>
                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Motorik III</h4>
                            <p class="text-gray-600">Progress: {{ max(0, min(100, (($child->points - 600) / 300) * 100)) }}%</p>
                        </div>
                        <div class="p-4 bg-orange-50 rounded-lg">
                            <h4 class="font-semibold text-orange-800">Motorik IV</h4>
                            <p class="text-gray-600">Progress: {{ max(0, min(100, (($child->points - 900) / 300) * 100)) }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        // ... (sama seperti script chart sebelumnya) ...
    </script>
    @endpush
</x-layout_landingPage> 