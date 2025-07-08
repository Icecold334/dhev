<!DOCTYPE html>
<html lang="en">

<x-layouts.header />

<body class="bg-gray-50 ">

  <!-- Sidebar -->
  <x-layouts.sidebar />
  <x-layouts.navbar />




  <main class="pt-20 px-4 lg:ml-64 bg-gradient-to-br from-pink-100 to-primary-200 min-h-screen">
    {{ $slot }}
  </main>


</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="/select2dark.css">
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
@stack('scripts')

</html>