{{-- Song search --}}
<form action="{{ route('dashboard') }}" method="GET" class="mt-4 md:mt-6 mb-4 md:mb-6 search-container-green">
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
        @if($search)
            <a href="{{ route('dashboard') }}" class="control-btn w-full sm:w-auto btn-padding-lg">CLEAR</a>
        @endif
        <input type="text" name="search" placeholder="🔍 Search songs and artists..." class="search-input-green w-full sm:flex-1" value="{{ $search ?? '' }}">
        <button type="submit" class="control-btn w-full sm:w-auto btn-padding-lg">SEARCH</button>
    </div>
</form>
