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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Profile Info Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-lg">
                <div class="flex flex-col items-center">
                    <h1 class="text-2xl font-bold text-blue-900 mb-6">Data Perkembangan Anak</h1>
                    
                    <!-- User Info Display -->
                    <div class="text-center mb-8">
                        <h2 class="text-xl font-semibold">{{ $user->name ?? '-' }}</h2>
                        <p class="text-gray-600">Nama Ibu: {{ $user->mother_name ?? '-' }}</p>
                        <button id="editButton" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                            Ubah Profil
                        </button>
                    </div>

                    <!-- Total Points Display -->
                    <div class="w-full text-center mb-8">
                        <div class="text-4xl font-bold text-blue-600">{{ $user->points ?? 0 }}</div>
                        <div class="text-gray-600">Total Poin</div>
                    </div>

                    <!-- Level Progress -->
                    <div class="w-full">
                        <h3 class="text-lg font-semibold mb-4">Kemajuan Level</h3>
                        <div id="levelProgressChart" class="w-full h-64"></div>
                    </div>
                </div>
            </div>

            <!-- Game Performance Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-lg">
                <h2 class="text-2xl font-bold text-blue-900 mb-6">Performa Permainan</h2>
                
                <!-- Success Rate Chart -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Tingkat Keberhasilan per Game</h3>
                    <div id="successRateChart" class="w-full h-64"></div>
                </div>

                <!-- Points History Chart -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Riwayat Poin</h3>
                    <div id="pointsHistoryChart" class="w-full h-64"></div>
                </div>
            </div>
        </div>

        <!-- Recent Games History -->
        <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-blue-900 mb-6">Riwayat Permainan Terakhir</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Permainan</th>
                            <th class="px-4 py-2">Skor</th>
                            <th class="px-4 py-2">Poin Diperoleh</th>
                            <th class="px-4 py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gameHistory as $game)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ ucfirst(str_replace('-', ' ', $game->level)) }}</td>
                            <td class="px-4 py-2">{{ $game->correct_answers }}/{{ $game->total_questions }}</td>
                            <td class="px-4 py-2 {{ $game->points_earned >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $game->points_earned >= 0 ? '+' : '' }}{{ $game->points_earned }}
                            </td>
                            <td class="px-4 py-2">{{ $game->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Ubah Profil</h3>
                    <button type="button" onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    
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
                        <input type="text" name="mother_name" value="{{ old('mother_name', $user->mother_name ?? '') }}" 
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
        document.addEventListener('DOMContentLoaded', function() {
            // Modal functionality
            const editButton = document.getElementById('editButton');
            const modal = document.getElementById('editProfileModal');
            const closeButton = document.querySelector('[onclick="closeEditModal()"]');

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

            if (editButton) {
                editButton.addEventListener('click', openEditModal);
            }

            if (closeButton) {
                closeButton.removeAttribute('onclick');
                closeButton.addEventListener('click', closeEditModal);
            }

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeEditModal();
                }
            });

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
                            window.location.href = "{{ route('profile') }}";
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

            // Debug data
            console.log('Level Progress Data:', {!! json_encode($levelProgress) !!});
            console.log('Success Rate Data:', {!! json_encode($successRateData) !!});
            console.log('Points History Data:', {!! json_encode($pointsHistory) !!});

            // Charts
            try {
                // Level Progress Chart
                Highcharts.chart('levelProgressChart', {
                    chart: {
                        type: 'pie',
                        backgroundColor: 'transparent',
                        height: 300
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: 'Kemajuan Level',
                        style: { fontSize: '16px' }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                                style: {
                                    fontSize: '12px'
                                }
                            },
                            showInLegend: true,
                            size: '100%'
                        }
                    },
                    tooltip: {
                        pointFormat: 'Kemajuan: <b>{point.percentage:.1f}%</b>'
                    },
                    series: [{
                        name: 'Kemajuan',
                        colorByPoint: true,
                        data: {!! json_encode($levelProgress) !!}
                    }]
                });

                // Success Rate Chart
                Highcharts.chart('successRateChart', {
                    chart: {
                        type: 'column',
                        backgroundColor: 'transparent',
                        height: 300
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: 'Tingkat Keberhasilan per Game',
                        style: { fontSize: '16px' }
                    },
                    xAxis: {
                        categories: {!! json_encode($successRateData['categories']) !!},
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'Tingkat Keberhasilan (%)'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">Keberhasilan: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f}%</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                            colorByPoint: true,
                            colors: ['#4299E1', '#48BB78', '#ECC94B', '#ED8936']
                        }
                    },
                    series: [{
                        name: 'Tingkat Keberhasilan',
                        data: {!! json_encode($successRateData['data']) !!}
                    }]
                });

                // Points History Chart
                Highcharts.chart('pointsHistoryChart', {
                    chart: {
                        type: 'line',
                        backgroundColor: 'transparent',
                        height: 300
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: 'Riwayat Poin',
                        style: { fontSize: '16px' }
                    },
                    xAxis: {
                        categories: {!! json_encode($pointsHistory['dates']) !!},
                        labels: {
                            rotation: -45
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Total Poin'
                        },
                        min: 0
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>' + this.x + '</b><br/>Poin: ' + this.y;
                        }
                    },
                    plotOptions: {
                        line: {
                            marker: {
                                enabled: true
                            },
                            color: '#4299E1'
                        }
                    },
                    series: [{
                        name: 'Poin',
                        data: {!! json_encode($pointsHistory['points']) !!}
                    }]
                });
            } catch (error) {
                console.error('Error creating charts:', error);
            }
        });
    </script>
    @endpush
</x-layout_landingPage>