<div>
    <div class="relative mb-5 overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <div>
                <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio"
                    class="inline-flex items-center text-zinc-500 bg-white border border-zinc-300 focus:outline-none hover:bg-zinc-100 focus:ring-4 focus:ring-zinc-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-zinc-800 dark:text-white dark:border-zinc-600 dark:hover:bg-zinc-700 dark:hover:border-zinc-600 dark:focus:ring-zinc-700"
                    type="button">
                    <svg class="w-3 h-3 text-zinc-500 dark:text-zinc-400 me-3" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                    </svg>
                    Last 30 days
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownRadio"
                    class="z-10 hidden w-48 bg-white divide-y divide-zinc-100 rounded-lg shadow-sm dark:bg-zinc-700 dark:divide-zinc-600"
                    data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top"
                    style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
                    <ul class="p-3 space-y-1 text-sm text-zinc-700 dark:text-zinc-200"
                        aria-labelledby="dropdownRadioButton">
                        <li>
                            <div class="flex items-center p-2 rounded-sm hover:bg-zinc-100 dark:hover:bg-zinc-600">
                                <input id="filter-radio-example-1" type="radio" value="" name="filter-radio"
                                    class="w-4 h-4 text-zinc-600 bg-zinc-100 border-zinc-300 focus:ring-zinc-500 dark:focus:ring-zinc-600 dark:ring-offset-zinc-800 dark:focus:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                                <label for="filter-radio-example-1"
                                    class="w-full ms-2 text-sm font-medium text-zinc-900 rounded-sm dark:text-zinc-300">Last
                                    day</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center p-2 rounded-sm hover:bg-zinc-100 dark:hover:bg-zinc-600">
                                <input checked="" id="filter-radio-example-2" type="radio" value="" name="filter-radio"
                                    class="w-4 h-4 text-zinc-600 bg-zinc-100 border-zinc-300 focus:ring-zinc-500 dark:focus:ring-zinc-600 dark:ring-offset-zinc-800 dark:focus:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                                <label for="filter-radio-example-2"
                                    class="w-full ms-2 text-sm font-medium text-zinc-900 rounded-sm dark:text-zinc-300">Last
                                    7
                                    days</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center p-2 rounded-sm hover:bg-zinc-100 dark:hover:bg-zinc-600">
                                <input id="filter-radio-example-3" type="radio" value="" name="filter-radio"
                                    class="w-4 h-4 text-zinc-600 bg-zinc-100 border-zinc-300 focus:ring-zinc-500 dark:focus:ring-zinc-600 dark:ring-offset-zinc-800 dark:focus:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                                <label for="filter-radio-example-3"
                                    class="w-full ms-2 text-sm font-medium text-zinc-900 rounded-sm dark:text-zinc-300">Last
                                    30
                                    days</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center p-2 rounded-sm hover:bg-zinc-100 dark:hover:bg-zinc-600">
                                <input id="filter-radio-example-4" type="radio" value="" name="filter-radio"
                                    class="w-4 h-4 text-zinc-600 bg-zinc-100 border-zinc-300 focus:ring-zinc-500 dark:focus:ring-zinc-600 dark:ring-offset-zinc-800 dark:focus:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                                <label for="filter-radio-example-4"
                                    class="w-full ms-2 text-sm font-medium text-zinc-900 rounded-sm dark:text-zinc-300">Last
                                    month</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center p-2 rounded-sm hover:bg-zinc-100 dark:hover:bg-zinc-600">
                                <input id="filter-radio-example-5" type="radio" value="" name="filter-radio"
                                    class="w-4 h-4 text-zinc-600 bg-zinc-100 border-zinc-300 focus:ring-zinc-500 dark:focus:ring-zinc-600 dark:ring-offset-zinc-800 dark:focus:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                                <label for="filter-radio-example-5"
                                    class="w-full ms-2 text-sm font-medium text-zinc-900 rounded-sm dark:text-zinc-300">Last
                                    year</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div
                    class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-zinc-500 dark:text-zinc-400" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="table-search"
                    class="block p-2 ps-10 text-sm text-zinc-900 border border-zinc-300 rounded-lg w-80 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                    placeholder="Search for items">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-zinc-500 dark:text-zinc-400">
            <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-400">
                <tr class="text-center">
                    <th scope="col" class="px-6 w-[5%] rounded-tl-xl py-3">
                        #
                    </th>
                    <th scope="col" class="px-6  py-3">
                        Nama Bahan
                    </th>
                    <th scope="col" class="px-6 w-[15%] py-3">
                        Satuan Besar
                    </th>
                    <th scope="col" class="px-6 w-[15%] py-3">
                        Satuan Kecil
                    </th>
                    <th scope="col" class="px-6  py-3">
                        Sisa
                    </th>
                    <th scope="col" class="px-6 w-[10%] py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bahans as $bahan)
                <tr
                    class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-600">
                    <td scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">
                        {{ $loop->iteration }}
                    </td>
                    <td scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">
                        {{ $bahan->nama }}
                    </td>
                    <td class="px-6 text-center py-4">
                        {{ $bahan->satuanBesar->nama }}
                    </td>
                    <td class="px-6 text-center py-4">
                        {{ $bahan->satuanKecil->nama }}
                    </td>
                    <td class="px-6 text-center py-4">
                        50 Kg - 50000 Gram
                    </td>
                    <td class="px-6 py-4 flex">
                        <a href="#" class="font-medium text-zinc-100 dark:text-zinc-500 hover:underline">
                            <flux:icon.pencil-square />
                        </a>
                        <a href="#" class="font-medium text-red-100 dark:text-red-500 hover:underline">
                            <flux:icon.trash />
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    {{ $bahans->onEachSide(1)->links() }}

</div>