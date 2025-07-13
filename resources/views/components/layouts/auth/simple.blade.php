<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-gradient-to-b from-primary-500 to-primary-600 antialiased dark:bg-linear-to-b ">
    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div
            class="flex w-full p-8 bg-gradient-to-b from-primary-600 to-primary-700 rounded-lg shadow-2xl max-w-sm flex-col gap-2">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                <span class="flex h-40 w-40 mb-1 items-center justify-center rounded-md">
                    <x-app-logo-icon class="size-9 fill-current text-black " />
                </span>
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div class="flex flex-col gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>