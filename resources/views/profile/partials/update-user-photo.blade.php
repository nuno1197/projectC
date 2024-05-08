<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Select one of this beautiful photos.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.photo-update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <x-user_photo></x-user_photo>

    </form>
</section>
