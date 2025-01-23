<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tutorial Video</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-8">
                        <span class="text-xl font-semibold">Admin Dashboard</span>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Questions
                            </a>
                            <a href="{{ route('admin.tutorial-video') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Tutorial Video
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-2xl font-bold mb-6">Kelola Video Tutorial</h2>

                    <!-- Upload Form -->
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Unggah Video Baru</h3>
                        <form action="{{ route('admin.tutorial-video.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                    Judul Video
                                </label>
                                <input type="text" name="title" id="title" required
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="video">
                                    File Video (MP4/WebM, max 100MB)
                                </label>
                                <input type="file" name="video" id="video" required accept="video/mp4,video/webm"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" class="form-checkbox">
                                    <span class="ml-2">Aktifkan sebagai video tutorial utama</span>
                                </label>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Unggah Video
                            </button>
                        </form>
                    </div>

                    <!-- Video List -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Daftar Video</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Judul
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Tanggal Upload
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($videos as $video)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            {{ $video->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $video->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $video->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            {{ $video->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            <form action="{{ route('admin.tutorial-video.toggle', $video->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    {{ $video->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.tutorial-video.delete', $video->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 