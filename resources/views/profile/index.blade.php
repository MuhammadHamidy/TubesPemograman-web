<x-layout_landingPage>
    <div class="container mx-auto p-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-lg max-w-2xl mx-auto">
            <!-- Profile Display Section -->
            <div class="flex flex-col items-center">
                <h1 class="text-2xl font-bold text-blue-900 mb-6">Data Perkembangan Anak</h1>
                
                <!-- Profile Picture and Basic Info -->
                <div class="relative mb-6">
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 border-4 border-blue-500">
                        <img id="profileImage" src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('img/default-profile.png') }}" 
                             alt="Profile Picture" 
                             class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="editButton" class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer hover:bg-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </button>
                </div>

                <!-- User Info Display -->
                <div class="text-center mb-8">
                    <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                    <p class="text-gray-600">Nama Ibu: {{ $user->mother_name }}</p>
                </div>

                <!-- Progress Chart -->
                <div class="w-full">
                    <div class="text-center mb-4">
                        <div class="text-4xl font-bold text-blue-600">{{ $user->points ?? 0 }}</div>
                        <div class="text-gray-600">Total Points</div>
                    </div>
                    <div id="progressChart" style="min-width: 300px; height: 300px;" class="w-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Edit Profile</h3>
                    <button type="button" onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    
                    <!-- Profile Picture Upload -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Foto Profile</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="w-full" accept="image/*">
                    </div>

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>

                    <!-- Mother's Name Field -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama Ibu</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name', $user->mother_name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        // Tunggu sampai DOM selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Modal elements
            const editButton = document.getElementById('editButton');
            const modal = document.getElementById('editProfileModal');
            const closeButton = document.querySelector('[onclick="closeEditModal()"]');

            // Modal functions
            function openEditModal() {
                if (modal) {
                    modal.classList.remove('hidden');
                }
            }

            function closeEditModal() {
                if (modal) {
                    modal.classList.add('hidden');
                }
            }

            // Add event listeners
            if (editButton) {
                editButton.addEventListener('click', openEditModal);
            }

            if (closeButton) {
                closeButton.removeAttribute('onclick');
                closeButton.addEventListener('click', closeEditModal);
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeEditModal();
                }
            });

            // Preview profile picture before upload
            const profilePictureInput = document.getElementById('profile_picture');
            if (profilePictureInput) {
                profilePictureInput.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('profileImage').src = e.target.result;
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }

            // Form submission handling
            const profileForm = document.getElementById('profileForm');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Terjadi kesalahan');
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                    });
                });
            }

            // Initialize progress chart dengan konfigurasi yang lebih lengkap
            const chartOptions = {
                chart: {
                    type: 'pie',
                    backgroundColor: 'transparent',
                    renderTo: 'progressChart',
                    height: 300
                },
                title: {
                    text: 'Progress Belajar'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Progress',
                    colorByPoint: true,
                    data: [
                        {
                            name: 'Motorik I',
                            y: {{ $user->points >= 300 ? 25 : ($user->points / 300 * 25) }},
                            color: '#4299E1' // blue-500
                        },
                        {
                            name: 'Motorik II',
                            y: {{ $user->points >= 600 ? 25 : (max(0, $user->points - 300) / 300 * 25) }},
                            color: '#48BB78' // green-500
                        },
                        {
                            name: 'Motorik III',
                            y: {{ $user->points >= 900 ? 25 : (max(0, $user->points - 600) / 300 * 25) }},
                            color: '#ECC94B' // yellow-500
                        },
                        {
                            name: 'Motorik IV',
                            y: {{ $user->points >= 1200 ? 25 : (max(0, $user->points - 900) / 300 * 25) }},
                            color: '#ED8936' // orange-500
                        }
                    ]
                }],
                credits: {
                    enabled: false
                },
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            plotOptions: {
                                pie: {
                                    dataLabels: {
                                        enabled: false
                                    }
                                }
                            }
                        }
                    }]
                }
            };

            // Pastikan container sudah ada sebelum membuat chart
            const container = document.getElementById('progressChart');
            if (container) {
                try {
                    Highcharts.chart(chartOptions);
                } catch (error) {
                    console.error('Error creating chart:', error);
                }
            }
        });
    </script>
    @endpush
</x-layout_landingPage>