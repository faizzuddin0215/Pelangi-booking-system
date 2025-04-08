@extends('layouts.app')

@section('content')
{{-- <style>
    /* Container for side-by-side layout */
    .form-container {
        display: flex;
        flex-wrap: wrap; /* Allows wrapping for smaller screens */
        gap: 2rem; /* Space between tables */
    }

    /* Make sure the tables are responsive */
    .pickup-table-container,
    .dropoff-table-container {
        flex: 1; /* Equal space for both tables */
        min-width: 300px; /* Ensure tables don't shrink too much */
        max-width: 50%; /* Each table takes up half the width on large screens */
    }

</style> --}}
<script src="https://cdn.tailwindcss.com"></script>
    <!-- Optionally configure Tailwind with custom settings -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1da1f2',
                    secondary: '#14171a',
                },
            },
        },
    }
</script>
<div class="max-w-full mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Breadcrumb Container -->
            <div class="flex justify-between items-center flex-wrap">
                <nav class="mb-4">
                    <!-- Mobile Menu Toggle -->
                    <input type="checkbox" id="menu-toggle" class="peer hidden">
                    <label for="menu-toggle" class="md:hidden flex items-center cursor-pointer text-gray-600 dark:text-gray-300 p-2">
                        ☰
                    </label>
                
                    <!-- Desktop Breadcrumb Menu -->
                    <ol class="hidden md:flex flex-wrap items-center space-x-3 text-sm text-gray-600 dark:text-gray-300">
                        <li>
                            <a href="{{ url('form') }}?booking={{ $bookings->booking_id }}&amend={{ $amendId }}" class="hover:text-indigo-500">
                                Basic Information
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form2', [$bookings->booking_id, $amendId]) }}" class="text-indigo-600 font-semibold">
                                Room Details
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form3', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Land Transfer & Optional
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form4', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Remarks
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form5', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Summary & Payment
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('invoice', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Invoice
                            </a>
                        </li>
                    </ol>
                
                    <!-- Mobile Dropdown Menu -->
                    <ol class="hidden peer-checked:block md:hidden mt-2 space-y-2 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 p-3 rounded-md shadow-md text-sm">
                        <li>
                            <a href="{{ url('form') }}?booking={{ $bookings->booking_id }}&amend={{ $amendId }}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                Basic Information
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('form2', [$bookings->booking_id, $amendId]) }}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                Room Details
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('form3', [$bookings->booking_id, $amendId]) }}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                Land Transfer & Optional
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('form4', [$bookings->booking_id, $amendId]) }}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                Remarks
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('form5', [$bookings->booking_id, $amendId]) }}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                Summary & Payment
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('invoice', [$bookings->booking_id, $amendId]) }}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                Invoice
                            </a>
                        </li>
                    </ol>
                </nav>
                
        
                <!-- Booking Info -->
                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1 text-right">
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">#{{ $bookings->booking_id }}-{{ $bookings->amend_id }} {{ $days }}D{{ $nights }}N</div>
                    <p>{{ $bookings->attention }} <span class="text-gray-500">({{ $bookings->company }})</span></p>
                    <p>
                        <strong>Check In:</strong> {{ $bookings->check_in }} |
                        <strong>Check Out:</strong> {{ $bookings->check_out }}
                    </p>
                    <p><strong>PIC:</strong> {{ $bookings->handle_by }}</p>
                </div>
            </div>
            <div id="form3-container">
                <div class="form-container flex flex-col md:flex-row gap-8">
                    <div id="mainContainer" class="w-full md:w-9/12 p-4">
                        <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">

                            <div class="flex flex-wrap gap-4 items-center p-4 bg-white dark:bg-gray-900 shadow-md rounded-lg">
                                
                                <div class="relative flex-1 min-w-[180px]">
                                    <label for="check_in" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Check In</label>
                                    <div class="relative">
                                        <input 
                                            type="date" 
                                            name="check_in" 
                                            id="check_in" 
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 text-xs"
                                            value="{{ $bookings->check_in }}" 
                                            onchange="dateRate()"
                                        >
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                            📅
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Check Out -->
                                <div class="flex-1 min-w-[180px]">
                                    <label for="check_out" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Check Out</label>
                                    <div class="relative">
                                        <input 
                                            type="date" 
                                            name="check_out" 
                                            id="check_out" 
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 text-xs"
                                            value="{{ $bookings->check_out }}" 
                                            onchange="dateRate()"
                                        >
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                            📅
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Agent Rate -->
                                <div class="flex-1 min-w-[180px]">
                                    <label for="agent" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Agent Rate</label>
                                    <select 
                                        name="agent" 
                                        id="agent" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 text-xs"
                                        onchange="agentRate()">
                                        <option value="0" {{ $bookings->agent == '0' ? 'selected' : '' }}>Normal Selling Rate</option>
                                        <option value="1" {{ $bookings->agent == '1' ? 'selected' : '' }}>Agent Tier 1</option>
                                        <option value="2" {{ $bookings->agent == '2' ? 'selected' : '' }}>Agent Tier 2</option>
                                    </select>
                                </div>
                                <div class="flex-1 min-w-[80px]">
                                    <label for="adult" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Adult</label>
                                    <input 
                                        type="number" 
                                        name="adult" 
                                        id="adult" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-center focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 text-xs"
                                        value="{{ $bookings->pax_adult }}"
                                    >
                                </div>
                                <div class="flex-1 min-w-[80px]">
                                    <label for="child" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Child</label>
                                    <input 
                                        type="number" 
                                        name="child" 
                                        id="child" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-center focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 text-xs"
                                        value="{{ $bookings->pax_child }}"
                                    >
                                </div>
                                <div class="flex-1 min-w-[80px]">
                                    <label for="toddler" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Toddler</label>
                                    <input 
                                        type="number" 
                                        name="toddler" 
                                        id="toddler" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-center focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 text-xs"
                                        value="{{ $bookings->pax_toddler }}"
                                    >
                                </div>
                                <div class="flex-1 min-w-[80px]">
                                    <label for="tl" class="block text-xs font-medium text-gray-700 dark:text-gray-300">TL / Instructor</label>
                                    <input 
                                        type="number" 
                                        name="tl" 
                                        id="tl" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-center focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 text-xs"
                                        value="{{ $bookings->pax_foc_tl }}"
                                    >
                                </div>
                                
                            </div>
                            <br />
                                                                                                                                            
                            {{-- <div class="mb-6">
                                <label for="package_amount" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Package Amount (RM)</label> 
                                        <input 
                                            type="number" 
                                            name="package_amount" 
                                            id="package_amount" 
                                            class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700"
                                            value="{{ $bookings->package_total }}" readonly
                                        >
                            </div> --}}
                                                                                        

                            <div class="overflow-x-auto">
                                <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th></th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 text-center" colspan="5">Double</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 text-center" colspan="5">Triple</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 text-center" colspan="5">Quad</th>
                                        </tr>
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Room Type</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Double (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">x</th>
                                            {{-- <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 {{ (fmod($sum_rooms['sum_double'], 1) !== 0.0) ? 'text-red-500' : '' }}" id="sum_double_pax" value="0">{{ $sum_rooms['sum_double_ceil'] }}</th> --}}
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 {{ (fmod($sum_rooms['sum_double'], 1) !== 0.0) ? 'text-red-500' : '' }}" id="sum_double_pax" value="0">
                                                <input 
                                                    id="sum_double_pax_input" 
                                                    type="text" 
                                                    class="w-8 px-2 py-1 text-gray-700 text-xs bg-transparent border-none focus:outline-none {{ (fmod($sum_rooms['sum_double'], 1) !== 0.0) ? 'text-red-500' : '' }}" 
                                                    value="{{ $bookings->room_double }}" onkeyup="changeValueRoom()" 
                                                />
                                            </th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Matt (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700" id="sum_double_mat_pax" value="0">{{ $sum_rooms['sum_double_mat'] }}</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Triple (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">x</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 {{ (fmod($sum_rooms['sum_triple'], 1) !== 0.0) ? 'text-red-500' : '' }}" id="sum_triple_pax" value="0">
                                                {{-- {{ $sum_rooms['sum_triple_ceil'] }} --}}
                                                <input 
                                                    id="sum_triple_pax_input" 
                                                    type="text" 
                                                    class="w-8 px-2 py-1 text-gray-700 text-xs bg-transparent border-none focus:outline-none {{ (fmod($sum_rooms['sum_triple'], 1) !== 0.0) ? 'text-red-500' : '' }}" 
                                                    value="{{ $bookings->room_triple }}" onkeyup="changeValueRoom()" 
                                                />
                                            </th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Matt (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">0</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Quad (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">x</th>
                                            {{-- <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 {{ (fmod($sum_rooms['sum_quad'], 1) !== 0.0) ? 'text-red-500' : '' }}" id="sum_quad_pax" value="0">
                                                {{ $sum_rooms['sum_quad_ceil'] }}
                                            </th> --}}
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 {{ (fmod($sum_rooms['sum_quad'], 1) !== 0.0) ? 'text-red-500' : '' }}" id="sum_quad_pax" value="0">
                                                {{-- {{ $sum_rooms['sum_quad_ceil'] }} --}}
                                                <input 
                                                    id="sum_quad_pax_input" 
                                                    type="text" 
                                                    class="w-8 px-2 py-1 text-gray-700 text-xs bg-transparent border-none focus:outline-none {{ (fmod($sum_rooms['sum_quad'], 1) !== 0.0) ? 'text-red-500' : '' }}" 
                                                    value="{{ $bookings->room_quad }}" onkeyup="changeValueRoom()" 
                                                />
                                            </th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Matt (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700" id="sum_quad_mat_pax" value="0">{{ $sum_rooms['sum_quad_mat'] }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Adult
                                            </td>
                                            
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->d_adult_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['double_adult'], 2) }} --}}
                                                <input
                                                    id="double_adult" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->d_adult_price, 2) }}"
                                                />
                                                
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input
                                                    id="double_adult_pax" 
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->d_adult_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->d_adult_m_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['double_adult_mat'], 2) }} --}}
                                                <input
                                                    id="double_adult_mat" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->d_adult_m_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="double_adult_mat_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->d_adult_m_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->t_adult_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['triple_adult'], 2) }} --}}
                                                <input
                                                    id="triple_adult" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->t_adult_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="triple_adult_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->t_adult_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format($bookings->t_adult_m_price, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- <input 
                                                    type="text" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                /> --}}
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->q_adult_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['quad_adult'], 2) }} --}}
                                                <input
                                                    id="quad_adult" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->q_adult_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="quad_adult_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->q_adult_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->q_adult_m_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['quad_adult_mat'], 2) }} --}}
                                                <input
                                                    id="quad_adult_mat" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->q_adult_m_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="quad_adult_mat_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->q_adult_m_pax ?? 0 }}"
                                                />
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Child
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->d_child_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['double_child'], 2) }} --}}
                                                <input
                                                    id="double_child" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->d_child_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="double_child_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->d_child_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->d_child_m_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['double_child_mat'], 2) }} --}}
                                                <input
                                                    id="double_child_mat" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->d_child_m_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="double_child_mat_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->d_child_m_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->t_child_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['triple_child'], 2) }} --}}
                                                <input
                                                    id="triple_child" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->t_child_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="triple_child_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->t_child_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="t_child_m_price" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format($bookings->t_child_m_price, 2) }}
                                                
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- <input 
                                                    type="text" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                /> --}}
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->q_child_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['quad_child'], 2) }} --}}
                                                <input
                                                    id="quad_child" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->q_child_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="quad_child_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->q_child_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->q_child_m_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['quad_child_mat'], 2) }} --}}
                                                <input
                                                    id="quad_child_mat" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->q_child_m_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="quad_child_mat_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->q_child_m_pax ?? 0 }}"
                                                />
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Toddler
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->d_toddler_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['double_toddler'], 2) }} --}}
                                                <input
                                                    id="double_toddler" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->d_toddler_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="double_toddler_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->d_toddler_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="d_toddler_m_price" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format($bookings->d_toddler_m_price, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->t_toddler_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['triple_toddler'], 2) }} --}}
                                                <input
                                                    id="triple_toddler" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->t_toddler_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="triple_toddler_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->t_toddler_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="t_toddler_m_price" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format($bookings->t_toddler_m_price, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($bookings->q_toddler_price, 2) }} --}}
                                                {{-- {{ number_format($room_rates['quad_toddler'], 2) }} --}}
                                                <input
                                                    id="quad_toddler" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->q_toddler_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="quad_toddler_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" onkeyup="changeValue()" value="{{ $bookings->q_toddler_pax ?? 0 }}"
                                                />
                                            </td>
                                            <td id="q_toddler_m_price" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format($bookings->q_toddler_m_price, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                
                                            </td>
                                        </tr>
                                        
                                    </tbody>    

                                </table>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 text-center" colspan="16">SEAVIEW ROOMS</th>
                                        </tr>
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Room Type</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Double (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">x</th>
                                            {{-- <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700" id="sea_sum_double_pax" value="0">

                                            </th> --}}
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 {{ (fmod($sum_rooms['sea_sum_double'], 1) !== 0.0) ? 'text-red-500' : '' }}" id="sea_sum_double_pax" value="0">
                                                <input 
                                                    id="sea_sum_double_pax_input" 
                                                    type="text" 
                                                    class="w-8 px-2 py-1 text-gray-700 text-xs bg-transparent border-none focus:outline-none {{ (fmod($sum_rooms['sea_sum_double'], 1) !== 0.0) ? 'text-red-500' : '' }}" 
                                                    value="{{ $bookings->deluxe_double }}" onkeyup="changeValueRoom()" 
                                                />
                                            </th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Matt (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700" id="sea_sum_double_mat_pax" value="0"></th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Triple (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">x</th>
                                            {{-- <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700" id="sea_sum_triple_pax" value="0"></th> --}}
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 {{ (fmod($sum_rooms['sea_sum_triple'], 1) !== 0.0) ? 'text-red-500' : '' }}" id="sea_sum_triple_pax" value="0">
                                                <input 
                                                    id="sea_sum_triple_pax_input" 
                                                    type="text" 
                                                    class="w-8 px-2 py-1 text-gray-700 text-xs bg-transparent border-none focus:outline-none {{ (fmod($sum_rooms['sea_sum_triple'], 1) !== 0.0) ? 'text-red-500' : '' }}" 
                                                    value="{{ $bookings->deluxe_triple }}" onkeyup="changeValueRoom()" 
                                                />
                                            </th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Matt (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">0</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Quad (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">x</th>
                                            {{-- <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700" id="sea_sum_quad_pax" value="0"></th> --}}
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700 {{ (fmod($sum_rooms['sea_sum_quad'], 1) !== 0.0) ? 'text-red-500' : '' }}" id="sea_sum_quad_pax" value="0">
                                                <input 
                                                    id="sea_sum_quad_pax_input" 
                                                    type="text" 
                                                    class="w-8 px-2 py-1 text-gray-700 text-xs bg-transparent border-none focus:outline-none {{ (fmod($sum_rooms['sea_sum_quad'], 1) !== 0.0) ? 'text-red-500' : '' }}" 
                                                    value="{{ $bookings->deluxe_quad }}" onkeyup="changeValueRoom()" 
                                                />
                                            </th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Matt (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700" id="sea_sum_quad_mat_pax" value="0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Adult
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_double_adult'], 2) }} --}}
                                                <input
                                                    id="sea_double_adult" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ number_format($bookings->deluxe_d_adult_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_double_adult_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()"
                                                    value="{{ $bookings->deluxe_d_adult_pax }}"
                                                />
                                            </td>
                                            <td  id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_double_adult_mat'], 2) }} --}}
                                                <input
                                                    id="sea_double_adult_mat" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_d_adult_m_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_double_adult_mat_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_d_adult_m_pax }}"
                                                />
                                            </td>
                                            <td  id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_triple_adult'], 2) }} --}}
                                                <input
                                                    id="sea_triple_adult" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_t_adult_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_triple_adult_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_t_adult_pax }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format(0, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- <input 
                                                    type="text" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                /> --}}
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_quad_adult'], 2) }} --}}
                                                <input
                                                    id="sea_quad_adult" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_q_adult_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_quad_adult_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"   onkeyup="changeValue()" value="{{ $bookings->deluxe_q_adult_pax }}"
                                                    value=""
                                                />
                                            </td>
                                            <td  id=""class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_quad_adult_mat'], 2) }} --}}
                                                <input
                                                    id="sea_quad_adult_mat" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"" value="{{ number_format($bookings->deluxe_q_adult_m_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_quad_adult_mat_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_q_adult_m_pax }}"
                                                />
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Child
                                            </td>
                                            <td  id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_double_child'], 2) }} --}}
                                                <input
                                                    id="sea_double_child" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_d_child_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_double_child_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_d_child_pax }}"
                                                />
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_double_child_mat'], 2) }} --}}
                                                <input
                                                    id="sea_double_child_mat" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_d_child_m_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_double_child_mat_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_d_child_m_pax }}"
                                                />
                                            </td>
                                            <td  id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_triple_child'], 2) }} --}}
                                                <input
                                                    id="sea_triple_child" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_t_child_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_triple_child_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_t_child_pax }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format(0, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- <input 
                                                    type="text" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                /> --}}
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_quad_child'], 2) }} --}}
                                                <input
                                                    id="sea_quad_child" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_q_child_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_quad_child_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_q_child_pax }}"
                                                />
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_quad_child_mat'], 2) }} --}}
                                                <input
                                                    id="sea_quad_child_mat" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_q_child_m_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_quad_child_mat_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_q_child_m_pax }}"
                                                />
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Toddler
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_double_toddler'], 2) }} --}}
                                                <input
                                                    id="sea_double_toddler" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"value="{{ number_format($bookings->deluxe_d_toddler_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_double_toddler_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_d_toddler_pax }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format(0, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- <input 
                                                    type="text" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                /> --}}
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input
                                                    id="sea_triple_toddler" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_t_toddler_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_triple_toddler_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_t_toddler_pax }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format(0, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- <input 
                                                    type="text" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                /> --}}
                                            </td>
                                            <td id="" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- {{ number_format($room_rates['sea_quad_toddler'], 2) }} --}}
                                                <input
                                                    id="sea_quad_toddler" 
                                                    type="text" 
                                                    class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" value="{{ number_format($bookings->deluxe_q_toddler_price, 2) }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                x
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <input 
                                                    id="sea_quad_toddler_pax"
                                                    type="text" 
                                                    class="w-8 border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"  onkeyup="changeValue()" value="{{ $bookings->deluxe_q_toddler_pax }}"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ number_format(0, 2) }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{-- <input 
                                                    type="text" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                /> --}}
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-right" colspan="3">
                                                Total
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                0
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-right" colspan="1">
                                                Total
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                0
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-right" colspan="2">
                                                Total
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                0
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-right" colspan="1">
                                                Total
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                0
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-right" colspan="2">
                                                Total
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                0
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-right" colspan="1">
                                                Total
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                0
                                            </td>
                                        </tr> --}}
                                        <tr class="text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-right" colspan="15">
                                                <strong>Package Amount Total (RM)</strong>
                                            </td>
                                            <td id="package_amount" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <strong>{{ $bookings->package_total }}</strong>
                                            </td>
                                        </tr>
                                                                            
                                    </tbody>    

                                </table>
                            </div>


                        </div>
                    </div>
                    <div id="summaryContainer" class="w-full md:w-3/12 p-4 transition-all duration-300">
                        <!-- Toggle Button -->
                        <div class="flex justify-end w-full">
                            <button 
                                id="toggleSummaryBtn" 
                                class="bg-blue-500 text-white px-3 py-2 rounded-md w-10 h-10 flex items-center justify-center"
                                onclick="toggleSummary()"
                            >
                                <svg id="iconShow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75 21 21m0 0-5.25-5.25M21 21l-5.25-5.25M9 3.75A9 9 0 0 1 18 12a9 9 0 0 1-9 8.25A9 9 0 0 1 0 12a9 9 0 0 1 9-8.25z" />
                                </svg>
                                <svg id="iconHide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18m-6.75-6.75A3 3 0 1 1 9.75 9.75m6.75 6.75A9 9 0 0 1 12 21a9 9 0 0 1-9-9 9 9 0 0 1 1.5-5.06M9.75 9.75A3 3 0 0 1 12 6a3 3 0 0 1 3 3 3 3 0 0 1-.75 2.25M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                    
                        <!-- Summary Section -->
                        <div id="summarySection" class="pickup-table-container w-full transition-all duration-300">
                            <h2 class="text-sm font-bold text-gray-700 mb-4">Summary</h2>
                            <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">
                                <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700"></th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Price (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Total Package
                                            </td>
                                            <td id="summary_package_amount" class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ $package_total }}
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Land Transfer
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ $land_transfer_total }}
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                Optional Arrangement
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                {{ $optional_total }}
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <strong>Total (RM)</strong>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <strong>{{ $total_summary }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button
                        type="button"
                        id="save"
                        class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300 text-xs"
                        onclick="save()"
                    >
                        Save
                    </button>
                    <button
                        type="button"
                        id="form2"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 text-xs"
                        onclick="showForm3()"
                    >
                        Next
                    </button>
                    
                </div>
                
                                
            </div>
            
        </div>
    </div>
</div>

@endsection

<script>

    function toggleSummary() {
        let summarySection = document.getElementById('summarySection');
        let summaryContainer = document.getElementById('summaryContainer');
        let mainContainer = document.getElementById('mainContainer');
        let button = document.getElementById('toggleSummaryBtn');

        let iconShow = document.getElementById('iconShow');
        let iconHide = document.getElementById('iconHide');

        // Toggle visibility of summary
        summarySection.classList.toggle('hidden');

        // Adjust width classes dynamically
        if (summarySection.classList.contains('hidden')) {
            summaryContainer.classList.remove('md:w-3/12');
            summaryContainer.classList.add('md:w-1/12');

            mainContainer.classList.remove('md:w-9/12');
            mainContainer.classList.add('md:w-11/12');

            iconShow.classList.remove('hidden');
            iconHide.classList.add('hidden');
        } else {
            summaryContainer.classList.remove('md:w-1/12');
            summaryContainer.classList.add('md:w-3/12');

            mainContainer.classList.remove('md:w-11/12');
            mainContainer.classList.add('md:w-9/12');

            iconShow.classList.add('hidden');
            iconHide.classList.remove('hidden');
        }
    }

    function getValue(id) {
        let element = document.getElementById(id);
        
        if (!element) return 0; // Return 0 if element not found
        
        // Check if "pax" is in the id
        return element.value || 0;
    }
    function showForm3() {

        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];
        window.location.href = "{{ url('form3') }}/" + bookingId + "/" + amendId;

    }

    function save() {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        const paxData = {
            amendid : amendId,
            check_in: document.getElementById('check_in').value,
            check_out: document.getElementById('check_out').value,
            pax_adult: document.getElementById('adult').value,
            pax_child: document.getElementById('child').value,
            pax_toddler: document.getElementById('toddler').value,
            pax_foc_tl: document.getElementById('tl').value,
            total_package: document.getElementById('package_amount').textContent,
            agent: document.getElementById('agent').value,
            paxRoom: {
                double: document.getElementById('sum_double_pax_input')?.value || 0,
                triple: document.getElementById('sum_triple_pax_input')?.value || 0,
                quad: document.getElementById('sum_quad_pax_input')?.value || 0,

                sea_double: document.getElementById('sea_sum_double_pax_input')?.value || 0,
                sea_triple: document.getElementById('sea_sum_triple_pax_input')?.value || 0,
                sea_quad: document.getElementById('sea_sum_quad_pax_input')?.value || 0,

                room_double: document.getElementById('sum_double_pax').textContent.trim(),
                room_triple: document.getElementById('sum_triple_pax').textContent.trim(),
                room_quad: document.getElementById('sum_quad_pax').textContent.trim(),

                room_sea_double: document.getElementById('sea_sum_double_pax').textContent.trim(),
                room_sea_triple: document.getElementById('sea_sum_triple_pax').textContent.trim(),
                room_sea_quad: document.getElementById('sea_sum_quad_pax').textContent.trim(),
            },
            pax: {
                double_adult_pax: parseFloat(getValue('double_adult_pax').replace(/,/g, '')),
                double_adult_price: parseFloat(getValue('double_adult').replace(/,/g, '')),
                double_adult_mat_pax: parseFloat(getValue('double_adult_mat_pax').replace(/,/g, '')),
                double_adult_mat_price: parseFloat(getValue('double_adult_mat').replace(/,/g, '')),

                double_child_pax: parseFloat(getValue('double_child_pax').replace(/,/g, '')),
                double_child_price: parseFloat(getValue('double_child').replace(/,/g, '')),
                double_child_mat_pax: parseFloat(getValue('double_child_mat_pax').replace(/,/g, '')),
                double_child_mat_price: parseFloat(getValue('double_child_mat').replace(/,/g, '')),

                double_toddler_pax: parseFloat(getValue('double_toddler_pax').replace(/,/g, '')),
                double_toddler_price: parseFloat(getValue('double_toddler').replace(/,/g, '')),

                triple_adult_pax: parseFloat(getValue('triple_adult_pax').replace(/,/g, '')),
                triple_adult_price: parseFloat(getValue('triple_adult').replace(/,/g, '')),

                triple_child_pax: parseFloat(getValue('triple_child_pax').replace(/,/g, '')),
                triple_child_price: parseFloat(getValue('triple_child').replace(/,/g, '')),

                triple_toddler_pax: parseFloat(getValue('triple_toddler_pax').replace(/,/g, '')),
                triple_toddler_price: parseFloat(getValue('triple_toddler').replace(/,/g, '')),

                quad_adult_pax: parseFloat(getValue('quad_adult_pax').replace(/,/g, '')),
                quad_adult_price: parseFloat(getValue('quad_adult').replace(/,/g, '')),
                quad_adult_mat_pax: parseFloat(getValue('quad_adult_mat_pax').replace(/,/g, '')),
                quad_adult_mat_price: parseFloat(getValue('quad_adult_mat').replace(/,/g, '')),

                quad_child_pax: parseFloat(getValue('quad_child_pax').replace(/,/g, '')),
                quad_child_price: parseFloat(getValue('quad_child').replace(/,/g, '')),
                quad_child_mat_pax: parseFloat(getValue('quad_child_mat_pax').replace(/,/g, '')),
                quad_child_mat_price: parseFloat(getValue('quad_child_mat').replace(/,/g, '')),

                quad_toddler_pax: parseFloat(getValue('quad_toddler_pax').replace(/,/g, '')),
                quad_toddler_price: parseFloat(getValue('quad_toddler').replace(/,/g, '')),

                sea_double_adult_pax: parseFloat(getValue('sea_double_adult_pax').replace(/,/g, '')),
                sea_double_adult_price: parseFloat(getValue('sea_double_adult').replace(/,/g, '')),
                sea_double_adult_mat_pax: parseFloat(getValue('sea_double_adult_mat_pax').replace(/,/g, '')),
                sea_double_adult_mat_price: parseFloat(getValue('sea_double_adult_mat').replace(/,/g, '')),

                sea_double_child_pax: parseFloat(getValue('sea_double_child_pax').replace(/,/g, '')),
                sea_double_child_price: parseFloat(getValue('sea_double_child').replace(/,/g, '')),
                sea_double_child_mat_pax: parseFloat(getValue('sea_double_child_mat_pax').replace(/,/g, '')),
                sea_double_child_mat_price: parseFloat(getValue('sea_double_child_mat').replace(/,/g, '')),

                sea_double_toddler_pax: parseFloat(getValue('sea_double_toddler_pax').replace(/,/g, '')),
                sea_double_toddler_price: parseFloat(getValue('sea_double_toddler').replace(/,/g, '')),

                sea_triple_adult_pax: parseFloat(getValue('sea_triple_adult_pax').replace(/,/g, '')),
                sea_triple_adult_price: parseFloat(getValue('sea_triple_adult').replace(/,/g, '')),

                sea_triple_child_pax: parseFloat(getValue('sea_triple_child_pax').replace(/,/g, '')),
                sea_triple_child_price: parseFloat(getValue('sea_triple_child').replace(/,/g, '')),

                sea_triple_toddler_pax: parseFloat(getValue('sea_triple_toddler_pax').replace(/,/g, '')),
                sea_triple_toddler_price: parseFloat(getValue('sea_triple_toddler').replace(/,/g, '')),

                sea_quad_adult_pax: parseFloat(getValue('sea_quad_adult_pax').replace(/,/g, '')),
                sea_quad_adult_price: parseFloat(getValue('sea_quad_adult').replace(/,/g, '')),
                sea_quad_adult_mat_pax: parseFloat(getValue('sea_quad_adult_mat_pax').replace(/,/g, '')),
                sea_quad_adult_mat_price: parseFloat(getValue('sea_quad_adult_mat').replace(/,/g, '')),

                sea_quad_child_pax: parseFloat(getValue('sea_quad_child_pax').replace(/,/g, '')),
                sea_quad_child_price: parseFloat(getValue('sea_quad_child').replace(/,/g, '')),
                sea_quad_child_mat_pax: parseFloat(getValue('sea_quad_child_mat_pax').replace(/,/g, '')),
                sea_quad_child_mat_price: parseFloat(getValue('sea_quad_child_mat').replace(/,/g, '')),

                sea_quad_toddler_pax: parseFloat(getValue('sea_quad_toddler_pax').replace(/,/g, '')),
                sea_quad_toddler_price: parseFloat(getValue('sea_quad_toddler').replace(/,/g, ''))
            }
        };

        fetch(`{{ url('/form2') }}/${bookingId}/save`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(paxData)
        })
        .then(response => response.json())
        .then(data => {
            alert('Successfully Updated!');
            window.location.href = "{{ url('form2') }}/" + bookingId + "/" + amendId;
        })
        .catch(error => console.error('Error updating dates:', error));

    }

    function changeValue() {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        let checkIn = document.getElementById('check_in').value;
        let checkOut = document.getElementById('check_out').value;

        const pax = {
            // Prices
            double: {
                adult: parseFloat(getValue('double_adult').replace(/,/g, '')),
                adult_mat: parseFloat(getValue('double_adult_mat').replace(/,/g, '')),
                child: parseFloat(getValue('double_child').replace(/,/g, '')),
                child_mat: parseFloat(getValue('double_child_mat').replace(/,/g, '')),
                toddler: parseFloat(getValue('double_toddler').replace(/,/g, ''))
            },
            triple: {
                adult: parseFloat(getValue('triple_adult').replace(/,/g, '')),
                child: parseFloat(getValue('triple_child').replace(/,/g, '')),
                toddler: parseFloat(getValue('triple_toddler').replace(/,/g, ''))
            },
            quad: {
                adult: parseFloat(getValue('quad_adult').replace(/,/g, '')),
                adult_mat: parseFloat(getValue('quad_adult_mat').replace(/,/g, '')),
                child: parseFloat(getValue('quad_child').replace(/,/g, '')),
                child_mat: parseFloat(getValue('quad_child_mat').replace(/,/g, '')),
                toddler: parseFloat(getValue('quad_toddler').replace(/,/g, ''))
            },

            // Pax Counts
            pax_count: {
                double: {
                    adult: document.getElementById('double_adult_pax').value,
                    adult_mat: document.getElementById('double_adult_mat_pax').value,
                    child: document.getElementById('double_child_pax').value,
                    child_mat: document.getElementById('double_child_mat_pax').value,
                    toddler: document.getElementById('double_toddler_pax').value
                },
                triple: {
                    adult: document.getElementById('triple_adult_pax').value,
                    child: document.getElementById('triple_child_pax').value,
                    toddler: document.getElementById('triple_toddler_pax').value
                },
                quad: {
                    adult: document.getElementById('quad_adult_pax').value,
                    adult_mat: document.getElementById('quad_adult_mat_pax').value,
                    child: document.getElementById('quad_child_pax').value,
                    child_mat: document.getElementById('quad_child_mat_pax').value,
                    toddler: document.getElementById('quad_toddler_pax').value
                }
            },

            // Seaview Prices
            seaview: {
                double: {
                    adult: parseFloat(getValue('sea_double_adult').replace(/,/g, '')),
                    adult_mat: parseFloat(getValue('sea_double_adult_mat').replace(/,/g, '')),
                    child: parseFloat(getValue('sea_double_child').replace(/,/g, '')),
                    child_mat: parseFloat(getValue('sea_double_child_mat').replace(/,/g, '')),
                    toddler: parseFloat(getValue('sea_double_toddler').replace(/,/g, ''))
                },
                triple: {
                    adult: parseFloat(getValue('sea_triple_adult').replace(/,/g, '')),
                    child: parseFloat(getValue('sea_triple_child').replace(/,/g, '')),
                    toddler: parseFloat(getValue('sea_triple_toddler').replace(/,/g, ''))
                },
                quad: {
                    adult: parseFloat(getValue('sea_quad_adult').replace(/,/g, '')),
                    adult_mat: parseFloat(getValue('sea_quad_adult_mat').replace(/,/g, '')),
                    child: parseFloat(getValue('sea_quad_child').replace(/,/g, '')),
                    child_mat: parseFloat(getValue('sea_quad_child_mat').replace(/,/g, '')),
                    toddler: parseFloat(getValue('sea_quad_toddler').replace(/,/g, ''))
                }
            },

            // Seaview Pax Counts
            seaview_pax_count: {
                double: {
                    adult: document.getElementById('sea_double_adult_pax').value,
                    adult_mat: document.getElementById('sea_double_adult_mat_pax').value,
                    child: document.getElementById('sea_double_child_pax').value,
                    child_mat: document.getElementById('sea_double_child_mat_pax').value,
                    toddler: document.getElementById('sea_double_toddler_pax').value
                },
                triple: {
                    adult: document.getElementById('sea_triple_adult_pax').value,
                    child: document.getElementById('sea_triple_child_pax').value,
                    toddler: document.getElementById('sea_triple_toddler_pax').value
                },
                quad: {
                    adult: document.getElementById('sea_quad_adult_pax').value,
                    adult_mat: document.getElementById('sea_quad_adult_mat_pax').value,
                    child: document.getElementById('sea_quad_child_pax').value,
                    child_mat: document.getElementById('sea_quad_child_mat_pax').value,
                    toddler: document.getElementById('sea_quad_toddler_pax').value
                }
            }
        };
        fetch(`{{ url('/form2') }}/${bookingId}/getRate`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                type: 'change',
                amend: amendId,
                check_in: checkIn,
                check_out: checkOut,
                pax
            })

        })
        .then(response => response.json())
        .then(data => {
            if (data.type == 'change') {
                document.getElementById('package_amount').textContent = data.total_package.toFixed(2);
                document.getElementById('summary_package_amount').textContent = data.total_package.toFixed(2);

                document.getElementById('sum_double_mat_pax').textContent = data.sum_mat_pax.sum_double_mat_pax;
                document.getElementById('sum_quad_mat_pax').textContent = data.sum_mat_pax.sum_quad_mat_pax;

                //seaview
                document.getElementById('sea_sum_double_mat_pax').textContent = data.sum_mat_pax.sea_sum_double_mat_pax;
                document.getElementById('sea_sum_quad_mat_pax').textContent = data.sum_mat_pax.sea_sum_quad_mat_pax;

                let paxIds = [
                    'sum_double_pax',
                    'sum_triple_pax',
                    'sum_quad_pax',
                    'sea_sum_double_pax',
                    'sea_sum_triple_pax',
                    'sea_sum_quad_pax',
                ];

                paxIds.forEach(id => {
                    let element = document.getElementById(id);
                    let value = data.sum_pax[id]; // Dynamically access the corresponding value

                    let roundedValue = (value % 1 !== 0) ? Math.ceil(value) : value; // Round up if decimal

                    element.textContent = roundedValue; // Set the updated value

                    // Apply or remove red text class based on decimal check
                    if (value % 1 !== 0) { 
                        element.classList.add('text-red-500');
                    } else {
                        element.classList.remove('text-red-500');
                    }
                });
            } else {
                // document.getElementById('double_adult').textContent = data.room_rate.double_adult.toFixed(2);
                document.getElementById('double_adult').value = data.room_rate.double_adult.toFixed(2);
                document.getElementById('double_child').value = data.room_rate.double_child.toFixed(2);
                document.getElementById('double_adult_mat').value = data.room_rate.double_adult_mat.toFixed(2);
                document.getElementById('double_child_mat').value = data.room_rate.double_child_mat.toFixed(2);
                document.getElementById('double_toddler').value = data.room_rate.double_toddler.toFixed(2);

                document.getElementById('triple_adult').value = data.room_rate.triple_adult.toFixed(2);
                document.getElementById('triple_child').value = data.room_rate.triple_child.toFixed(2);
                document.getElementById('triple_toddler').value = data.room_rate.triple_toddler.toFixed(2);
                
                document.getElementById('quad_adult').value = data.room_rate.quad_adult.toFixed(2);
                document.getElementById('quad_child').value = data.room_rate.quad_child.toFixed(2);
                document.getElementById('quad_adult_mat').value = data.room_rate.quad_adult_mat.toFixed(2);
                document.getElementById('quad_child_mat').value = data.room_rate.quad_child_mat.toFixed(2);
                document.getElementById('quad_toddler').value = data.room_rate.quad_toddler.toFixed(2);

                // seaview
                document.getElementById('sea_double_adult').value = data.room_rate.sea_double_adult.toFixed(2);
                document.getElementById('sea_double_child').value = data.room_rate.sea_double_child.toFixed(2);
                document.getElementById('sea_double_adult_mat').value = data.room_rate.sea_double_adult_mat.toFixed(2);
                document.getElementById('sea_double_child_mat').value = data.room_rate.sea_double_child_mat.toFixed(2);
                document.getElementById('sea_double_toddler').value = data.room_rate.sea_double_toddler.toFixed(2);

                document.getElementById('sea_triple_adult').value = data.room_rate.sea_triple_adult.toFixed(2);
                document.getElementById('sea_triple_child').value = data.room_rate.sea_triple_child.toFixed(2);
                document.getElementById('sea_triple_toddler').value = data.room_rate.sea_triple_toddler.toFixed(2);
                
                document.getElementById('sea_quad_adult').value = data.room_rate.sea_quad_adult.toFixed(2);
                document.getElementById('sea_quad_child').value = data.room_rate.sea_quad_child.toFixed(2);
                document.getElementById('sea_quad_adult_mat').value = data.room_rate.sea_quad_adult_mat.toFixed(2);
                document.getElementById('sea_quad_child_mat').value = data.room_rate.sea_quad_child_mat.toFixed(2);
                document.getElementById('sea_quad_toddler').value = data.room_rate.sea_quad_toddler.toFixed(2);

                document.getElementById('days').textContent = data.days;
                document.getElementById('night').textContent = data.nights;

                document.getElementById('package_amount').textContent = (data.room_rate.total_double_rates + data.room_rate.total_triple_rates + data.room_rate.total_quad_rates + data.room_rate.sea_total_double_rates + data.room_rate.sea_total_triple_rates + data.room_rate.sea_total_quad_rates).toFixed(2);

                document.getElementById('summary_package_amount').textContent = (data.room_rate.total_double_rates + data.room_rate.total_triple_rates + data.room_rate.total_quad_rates + data.room_rate.sea_total_double_rates + data.room_rate.sea_total_triple_rates + data.room_rate.sea_total_quad_rates).toFixed(2);

                document.getElementById('sum_double_mat_pax').textContent = data.room_rate.sum_double_mat_pax;
                document.getElementById('sum_quad_mat_pax').textContent = data.room_rate.sum_quad_mat_pax;

                //seaview
                document.getElementById('sea_sum_double_mat_pax').textContent = data.room_rate.sea_sum_double_mat_pax;
                document.getElementById('sea_sum_quad_mat_pax').textContent = data.room_rate.sea_sum_quad_mat_pax;

                let paxIds = [
                    'sum_double_pax',
                    'sum_triple_pax',
                    'sum_quad_pax',
                    'sea_sum_double_pax',
                    'sea_sum_triple_pax',
                    'sea_sum_quad_pax',
                ];

                paxIds.forEach(id => {
                    let element = document.getElementById(id);
                    let value = data.room_rate[id]; // Dynamically access the corresponding value

                    let roundedValue = (value % 1 !== 0) ? Math.ceil(value) : value; // Round up if decimal

                    element.textContent = roundedValue; // Set the updated value

                    // Apply or remove red text class based on decimal check
                    if (value % 1 !== 0) { 
                        element.classList.add('text-red-500');
                    } else {
                        element.classList.remove('text-red-500');
                    }
                });
            }



            // You can do something with the response data if needed
        })
        .catch(error => console.error('Error updating dates:', error));
    }

    // function changeValueRoom() {
    //     const urlParams = new URLSearchParams(window.location.search);
    //     const bookingId = window.location.pathname.split('/')[4];
    //     const amendId = window.location.pathname.split('/')[5];

    //     let checkIn = document.getElementById('check_in').value;
    //     let checkOut = document.getElementById('check_out').value;

    //     const paxRoom = {
    //         double: document.getElementById('sum_double_pax_input').value,
    //         triple: document.getElementById('sum_triple_pax_input').value,
    //         quad: document.getElementById('sum_quad_pax_input').value,

    //         sea_double: document.getElementById('sea_sum_double_pax_input').value,
    //         sea_triple: document.getElementById('sea_sum_triple_pax_input').value,
    //         sea_quad: document.getElementById('sea_sum_quad_pax_input').value,
    //     };

    //     fetch(`{{ url('/form2') }}/${bookingId}/getRate`, {
    //         method: "POST",
    //         headers: {
    //             "Content-Type": "application/json",
    //             "X-CSRF-TOKEN": "{{ csrf_token() }}"
    //         },
    //         body: JSON.stringify(paxData)
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         // alert('Successfully Updated!');
    //         window.location.href = "{{ url('form2') }}/" + bookingId + "/" + amendId;
    //     })
    //     .catch(error => console.error('Error updating dates:', error));


    // }

    function dateRate() {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];
        

        const paxData = {
            type: 'date',
            submit : 'submit',
            amendid : amendId,
            check_in: document.getElementById('check_in').value,
            check_out: document.getElementById('check_out').value,
        };

        fetch(`{{ url('/form2') }}/${bookingId}/getRate`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(paxData)
        })
        .then(response => response.json())
        .then(data => {
            // alert('Successfully Updated!');
            window.location.href = "{{ url('form2') }}/" + bookingId + "/" + amendId;
        })
        .catch(error => console.error('Error updating dates:', error));

    }

    function agentRate() {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];
        

        const paxData = {
            type: 'date',
            field: 'agent',
            submit : 'submit',
            amendid : amendId,
            check_in: document.getElementById('check_in').value,
            check_out: document.getElementById('check_out').value,
            agentTier: document.getElementById('agent').value
        };

        fetch(`{{ url('/form2') }}/${bookingId}/getRate`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(paxData)
        })
        .then(response => response.json())
        .then(data => {
            // alert('Successfully Updated!');
            window.location.href = "{{ url('form2') }}/" + bookingId + "/" + amendId;
        })
        .catch(error => console.error('Error updating dates:', error));

    }



</script>
