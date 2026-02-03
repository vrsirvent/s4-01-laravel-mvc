{{-- Success/error messages --}}
@if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="mb-4 p-4 bg-green-900 border border-green-500 text-green-100 rounded-lg">
        <p class="font-neon text-center">✅ {{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="mb-4 p-4 bg-red-900 border border-red-500 text-red-100 rounded-lg">
        <p class="font-neon text-center">❌ {{ session('error') }}</p>
    </div>
@endif


