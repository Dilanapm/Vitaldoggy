<x-app-layout>
    <div class="max-w-2xl mx-auto py-12">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Test Profile Photo Upload</h1>
            
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    Status: {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', auth()->user()->username) }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @if(auth()->user()->profile_photo_url)
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Current" class="mt-2 w-20 h-20 rounded-full">
                    @endif
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Update Profile
                </button>
            </form>

            <div class="mt-6">
                <h3 class="font-bold">Debug Info:</h3>
                <p>User ID: {{ auth()->user()->id }}</p>
                <p>Current photo path: {{ auth()->user()->profile_photo_path ?? 'None' }}</p>
                <p>Has photo method: {{ auth()->user()->hasProfilePhoto() ? 'Yes' : 'No' }}</p>
                <p>Photo URL: {{ auth()->user()->profile_photo_url ?? 'None' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
