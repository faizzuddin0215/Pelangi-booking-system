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
                            <a href="{{ url('form') }}?booking={{ $bookings->booking_id }}&amend={{ $bookings->amend_id }}" class="hover:text-indigo-500">
                                Basic Information
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form2', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Room Details
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form3', [$bookings->booking_id, $amendId]) }}" class="text-indigo-600 font-semibold">
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
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('invoice', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Invoice
                            </a>
                        </li>
                    </ol>
                
                    <!-- Mobile Dropdown Menu -->
                    <ol class="hidden peer-checked:block md:hidden mt-2 space-y-2 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 p-3 rounded-md shadow-md transition-all duration-300 ease-in-out text-sm">
                        <li>
                            <a href="{{ url('form') }}?booking={{ $bookings->booking_id }}&amend={{ $bookings->amend_id }}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
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
                    {{-- <p>
                        <strong>Days:</strong> <span id="days">{{ $days }}</span> |  
                        <strong>Night:</strong> <span id="night">{{ $nights }}</span>
                    </p> --}}
                </div>
            </div>
                        
            <div id="form3-container">
                <div class="form-container flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-8/12 p-4">
                        <!-- Pickup Table -->
                        <div class="pickup-table-container w-full">
                            <h2 class="text-sm font-bold text-gray-700 mb-4">Pickup Arrangements</h2>
                            <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">

                                <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Pickup Arrangement</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Pax</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Rate (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <select
                                                    class="pickup-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-pickup-name="{{ $bookings->pickup01_method }}"
                                                    data-pickup-rate="{{ $bookings->pickup01_price }}"
                                                    data-pickup-field="pickup01_method"
                                                    onclick="handlePickupChangeOriginal(event)"
                                                >
                                                    <option value="other">Other</option>
                                                    <option value="Please Choose" selected>{{ $bookings->pickup01_method }}</option>
                                                    @foreach ($pickupOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <select
                                                    id="pickup-method"
                                                    class="pickup-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    onchange="handlePickupChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->pickup01_method }}</option>
                                                    @foreach ($pickupOptions as $option)
                                                        <option value="{{ $option }}" {{ $bookings->pickup01_method == $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                    <option value="other">Other</option>
                                                </select>

                                                <input 
                                                    type="text" 
                                                    id="custom-pickup-method"
                                                    class="hidden mt-2 w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    placeholder="Enter custom pickup method"
                                                    oninput="document.getElementById('final-pickup-method').value = this.value"
                                                >

                                                <input type="hidden" name="pickup01_method" id="final-pickup-method" value="{{ $bookings->pickup01_method }}"> --}}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value text-xs" data-pickup-name="{{ $bookings->pickup01_method }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->pickup01_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    {{-- onchange="updatePaxValueOriginal(event, {{ $bookings->pickup01_method }},'pickup01_method')"  --}}
                                                    onchange="updatePaxValueOriginal(event, 'pickup01_method')"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value text-xs" data-pickup-name="{{ $bookings->pickup01_method }}">
                                                {{ $bookings->pickup01_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-pickup-name="{{ $bookings->pickup01_method }}">
                                                {{ $bookings->pickup01_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deletePickup({{ $bookings->booking_id }}, 'pickup01_method')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="pickup-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-pickup2-name="{{ $bookings->pickup02_method }}"
                                                    data-pickup2-rate="{{ $bookings->pickup02_price }}"
                                                    data-pickup-field="pickup02_method"
                                                    onclick="handlePickupChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->pickup02_method }}</option>
                                                    @foreach ($pickupOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value text-xs" data-pickup2-name="{{ $bookings->pickup02_method }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->pickup02_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updatePaxValueOriginal(event, 'pickup02_method')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value text-xs" data-pickup2-name="{{ $bookings->pickup02_method }}">
                                                {{ $bookings->pickup02_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-pickup2-name="{{ $bookings->pickup02_method }}">
                                                {{ $bookings->pickup02_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deletePickup({{ $bookings->booking_id }}, 'pickup02_method')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="pickup-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-pickup3-name="{{ $bookings->pickup03_method }}"
                                                    data-pickup3-rate="{{ $bookings->pickup03_price }}"
                                                    data-pickup-field="pickup03_method"
                                                    onclick="handlePickupChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->pickup03_method }}</option>
                                                    @foreach ($pickupOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value text-xs" data-pickup3-name="{{ $bookings->pickup03_method }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->pickup03_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updatePaxValueOriginal(event, 'pickup03_method')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value text-xs" data-pickup3-name="{{ $bookings->pickup03_method }}">
                                                {{ $bookings->pickup03_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-pickup3-name="{{ $bookings->pickup03_method }}">
                                                {{ $bookings->pickup03_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deletePickup({{ $bookings->booking_id }}, 'pickup03_method')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value"><strong>Total (RM)</strong></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value">
                                                {{ $total_pickup }}
                                            </td>
                                        </tr>
                                    </tbody>    

                                </table>


                                <br/>
                                {{-- <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Pickup Arrangement</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Pax</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Rate (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pickups as $pickup)
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="pickup-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-row-id="{{ $loop->index }}"
                                                    data-pickup-id="{{ $pickup->id }}"
                                                    data-pickup-rate="{{ $pickup->pickup_rate }}"
                                                    onclick="handlePickupChange(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $pickup->pickup_name }}</option>
                                                    @foreach ($pickupOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value text-xs" data-row-id="{{ $loop->index }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $pickup->pickup_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updatePaxValue(event, {{ $pickup->id }}, {{ $loop->index }})" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value text-xs" data-row-id="{{ $loop->index }}">
                                                {{ $pickup->pickup_rate }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-row-id="{{ $loop->index }}">
                                                {{ $pickup->total_pickup_rate }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-row-id="{{ $loop->index }}">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deletePickupNew({{ $bookings->booking_id }}, {{$pickup->id}})"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        @endforeach                                
                                        <!-- New Row at the Bottom -->
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value"><strong>Total (RM)</strong></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value">
                                                {{ $total_pickup }}
                                            </td>
                                        </tr>
                                    </tbody>    

                                </table>
                                <button onclick="addRow()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Add Row</button> --}}
                            </div>
                        </div>
                              
                        <!-- Dropoff Table -->
                        <div class="dropoff-table-container w-full text-xs mt-4">
                            <h2 class="text-sm font-bold text-gray-700 mb-4">Dropoff Arrangements</h2>
                            <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">


                                <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Dropoff Arrangement</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Pax</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Rate (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-dropoff-name="{{ $bookings->dropoff01_method }}"
                                                    data-dropoff-rate="{{ $bookings->dropoff01_price }}"
                                                    data-dropoff-field="dropoff01_method"
                                                    onclick="handleDropoffChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->dropoff01_method }}</option>
                                                    @foreach ($dropoffOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value text-xs" data-dropoff-name="{{ $bookings->dropoff01_method }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->dropoff01_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    {{-- onchange="updatePaxValueOriginal(event, {{ $bookings->pickup01_method }},'pickup01_method')"  --}}
                                                    onchange="updatePaxValueDropoffOriginal(event, 'dropoff01_method')"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value text-xs" data-dropoff-name="{{ $bookings->dropoff_method }}">
                                                {{ $bookings->dropoff01_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-dropoff-name="{{ $bookings->dropoff_method }}">
                                                {{ $bookings->dropoff01_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteDropoff({{ $bookings->booking_id }}, 'dropoff01_method')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-dropoff2-name="{{ $bookings->dropoff02_method }}"
                                                    data-dropoff2-rate="{{ $bookings->dropoff02_price }}"
                                                    data-dropoff-field="dropoff02_method"
                                                    onclick="handleDropoffChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->dropoff02_method }}</option>
                                                    @foreach ($dropoffOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value text-xs" data-dropoff2-name="{{ $bookings->dropoff02_method }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->dropoff02_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updatePaxValueDropoffOriginal(event, 'dropoff02_method')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value text-xs" data-dropoff2-name="{{ $bookings->dropoff02_method }}">
                                                {{ $bookings->dropoff02_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-dropoff2-name="{{ $bookings->dropoff02_method }}">
                                                {{ $bookings->dropoff02_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteDropoff({{ $bookings->booking_id }}, 'dropoff02_method')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-dropoff3-name="{{ $bookings->dropoff03_method }}"
                                                    data-dropoff3-rate="{{ $bookings->dropoff03_price }}"
                                                    data-dropoff-field="dropoff03_method"
                                                    onclick="handleDropoffChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->dropoff03_method }}</option>
                                                    @foreach ($dropoffOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value text-xs" data-dropoff3-name="{{ $bookings->dropoff03_method }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->dropoff03_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updatePaxValueDropoffOriginal(event, 'dropoff03_method')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value text-xs" data-dropoff3-name="{{ $bookings->dropoff03_method }}">
                                                {{ $bookings->dropoff03_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-dropoff3-name="{{ $bookings->dropoff03_method }}">
                                                {{ $bookings->dropoff03_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteDropoff({{ $bookings->booking_id }}, 'dropoff03_method')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value"><strong>Total (RM)</strong></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value">
                                                {{ $total_dropoff }}
                                            </td>
                                        </tr>
                                    </tbody>    

                                </table>

                                <br />
                                {{-- <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Dropoff Arrangement</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Pax</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Rate (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dropoffs as $dropoff)
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="pickup-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-row-dropoff-id="{{ $loop->index }}"
                                                    data-dropoff-id="{{ $dropoff->id }}"
                                                    data-dropoff-rate="{{ $dropoff->dropoff_rate }}"
                                                    onclick="handlePickupChangeDropoff(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $dropoff->dropoff_name }}</option>
                                                    @foreach ($dropoffOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value text-xs" data-row-dropoff-id="{{ $loop->index }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $dropoff->dropoff_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updatePaxValueDropoff(event, {{ $dropoff->id }}, {{ $loop->index }})" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value text-xs" data-row-dropoff-id="{{ $loop->index }}">
                                                {{ $dropoff->dropoff_rate }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-row-dropoff-id="{{ $loop->index }}">
                                                {{ $dropoff->total_dropoff_rate }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-row-id="{{ $loop->index }}">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteDropoffNew({{ $bookings->booking_id }}, {{$dropoff->id}})"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value"><strong>Total (RM)</strong></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value">
                                                {{ $total_dropoff }}
                                            </td>
                                        </tr>
                                    </tbody>
        
                                </table>
                                <button onclick="addRowDropoff()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Add Row</button> --}}

                            </div>
                        </div>

                        <!-- optional arrangement -->

                        <div class="pickup-table-container w-full mt-4">
                            <h2 class="text-sm font-bold text-gray-700 mb-4">Optional Arrangement</h2>
                            <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">
                                <div class="mb-6 flex flex-col md:flex-row gap-3 text-xs">
                                    <!-- Dive Package -->
                                    <div class="w-full md:w-1/2 flex items-center gap-2">
                                        <label for="divepackage" class="text-gray-700 dark:text-gray-300 font-medium">Dive Package</label>
                                        <input type="checkbox" name="divepackage" id="divepackage" value="1" 
                                        {{ old('divepackage', $dive_package) == '1' ? 'checked' : '' }} 
                                        class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700">
                                    </div>
                                
                                    <!-- Insurance -->
                                    <div class="w-full md:w-1/2 flex items-center gap-2">
                                        <label for="insurance" class="text-gray-700 dark:text-gray-300 font-medium">Insurance</label>
                                        <select name="insurance" id="insurance" class="px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700">
                                            <option value="0" {{ old('insurance', $insurance) == '0' ? 'selected' : '' }}>No Insurance</option>
                                            <option value="1" {{ old('insurance', $insurance) == '1' ? 'selected' : '' }}>Require Insurance</option>
                                            <option value="2" {{ old('insurance', $insurance) == '2' ? 'selected' : '' }}>Ordered From Agent</option>
                                            <option value="3" {{ old('insurance', $insurance) == '3' ? 'selected' : '' }}>Received Information</option>
                                        </select>
                                    </div>
                                </div>
                                <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Description</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">SST</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Code</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">QTY</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Price/Unit (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-optional-name="{{ $bookings->optional01_desc }}"
                                                    data-optional-rate="{{ $bookings->optional01_price }}"
                                                    data-optional-field="optional01_desc"
                                                    onclick="handleOptionalChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->optional01_desc }}</option>
                                                    @foreach ($optionalOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 sst-value text-xs" data-optional-name="{{ $bookings->optional01_desc }}">
                                                {{ $bookings->optional01_GST }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 code-value text-xs" data-optional-name="{{ $bookings->optional01_desc }}">
                                                {{ $optional_code['optional_code01'] }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 qty-value text-xs" data-optional-name="{{ $bookings->optional01_desc }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->optional01_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updateQtyOriginalValue(event, 'optional01_desc', 'optional01_pax')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 price-value text-xs" data-optional-name="{{ $bookings->optional01_desc }}">
                                                {{ $bookings->optional01_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-optional-name="{{ $bookings->optional01_desc }}">
                                                {{ $bookings->optional01_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteOptionalOriginal({{ $bookings->booking_id }}, 'optional01_desc')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-optional-name="{{ $bookings->optional02_desc }}"
                                                    data-optional-rate="{{ $bookings->optional02_price }}"
                                                    data-optional-field="optional02_desc"
                                                    onclick="handleOptionalChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->optional02_desc }}</option>
                                                    @foreach ($optionalOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 sst-value text-xs" data-optional-name="{{ $bookings->optional02_desc }}">
                                                {{ $bookings->optional02_GST }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 code-value text-xs" data-optional-name="{{ $bookings->optional02_desc }}">
                                                {{ $optional_code['optional_code02'] }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 qty-value text-xs" data-optional-name="{{ $bookings->optional02_desc }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->optional02_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updateQtyOriginalValue(event, 'optional02_desc', 'optional02_pax')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 price-value text-xs" data-optional-name="{{ $bookings->optional02_desc }}">
                                                {{ $bookings->optional02_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-optional-name="{{ $bookings->optional02_desc }}">
                                                {{ $bookings->optional02_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteOptionalOriginal({{ $bookings->booking_id }}, 'optional02_desc')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-optional-name="{{ $bookings->optional03_desc }}"
                                                    data-optional-rate="{{ $bookings->optional03_price }}"
                                                    data-optional-field="optional03_desc"
                                                    onclick="handleOptionalChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->optional03_desc }}</option>
                                                    @foreach ($optionalOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 sst-value text-xs" data-optional-name="{{ $bookings->optional03_desc }}">
                                                {{ $bookings->optional03_GST }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 code-value text-xs" data-optional-name="{{ $bookings->optional03_desc }}">
                                                {{ $optional_code['optional_code03'] }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 qty-value text-xs" data-optional-name="{{ $bookings->optional03_desc }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->optional03_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updateQtyOriginalValue(event, 'optional03_desc', 'optional03_pax')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 price-value text-xs" data-optional-name="{{ $bookings->optional03_desc }}">
                                                {{ $bookings->optional03_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-optional-name="{{ $bookings->optional03_desc }}">
                                                {{ $bookings->optional03_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteOptionalOriginal({{ $bookings->booking_id }}, 'optional03_desc')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-optional-name="{{ $bookings->optional04_desc }}"
                                                    data-optional-rate="{{ $bookings->optional04_price }}"
                                                    data-optional-field="optional04_desc"
                                                    onclick="handleOptionalChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->optional04_desc }}</option>
                                                    @foreach ($optionalOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 sst-value text-xs" data-optional-name="{{ $bookings->optional04_desc }}">
                                                {{ $bookings->optional04_GST }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 code-value text-xs" data-optional-name="{{ $bookings->optional04_desc }}">
                                                {{ $optional_code['optional_code04'] }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 qty-value text-xs" data-optional-name="{{ $bookings->optional04_desc }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->optional04_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updateQtyOriginalValue(event, 'optional04_desc', 'optional04_pax')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 price-value text-xs" data-optional-name="{{ $bookings->optional04_desc }}">
                                                {{ $bookings->optional04_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-optional-name="{{ $bookings->optional04_desc }}">
                                                {{ $bookings->optional04_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteOptionalOriginal({{ $bookings->booking_id }}, 'optional04_desc')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-optional-name="{{ $bookings->optional05_desc }}"
                                                    data-optional-rate="{{ $bookings->optional05_price }}"
                                                    data-optional-field="optional05_desc"
                                                    onclick="handleOptionalChangeOriginal(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $bookings->optional05_desc }}</option>
                                                    @foreach ($optionalOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 sst-value text-xs" data-optional-name="{{ $bookings->optional05_desc }}">
                                                {{ $bookings->optional05_GST }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 code-value text-xs" data-optional-name="{{ $bookings->optional05_desc }}">
                                                {{ $optional_code['optional_code05'] }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 qty-value text-xs" data-optional-name="{{ $bookings->optional05_desc }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings->optional05_pax }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updateQtyOriginalValue(event, 'optional05_desc', 'optional05_pax')" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 price-value text-xs" data-optional-name="{{ $bookings->optional05_desc }}">
                                                {{ $bookings->optional05_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-optional-name="{{ $bookings->optional05_desc }}">
                                                {{ $bookings->optional05_total }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" 
                                                    class="cursor-pointer"
                                                    onclick="deleteOptionalOriginal({{ $bookings->booking_id }}, 'optional05_desc')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                </svg>
                                            </td>
                                        </tr>

                                    </tbody>    

                                </table>

                                {{-- <table class="table-auto w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Description</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">SST</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">CODE</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">QTY</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">PRICE/UNIT (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($optionalArrangements as $optional)
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-xs">
                                                <select
                                                    class="pickup-select w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    data-row-id="{{ $loop->index }}"
                                                    data-optional-id="{{ $optional->id }}"
                                                    data-optional-price="{{ $optional->optional_price }}"
                                                    data-optional-sst="{{ $optional->optional_sst }}"
                                                    data-optional-code="{{ $optional->optional_code }}"
                                                    onclick="handleOptionalChange(event)"
                                                >
                                                    <option value="Please Choose" selected>{{ $optional->optional_desc }}</option>
                                                    @foreach ($optionalOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 sst-value text-xs" data-row-id="{{ $loop->index }}">
                                                {{ $optional->optional_sst }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 code-value text-xs" data-row-id="{{ $loop->index }}">
                                                {{ $optional->optional_code }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 qty-value text-xs" data-row-id="{{ $loop->index }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $optional->optional_qty }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updateQtyValue(event, {{ $optional->id }}, {{ $loop->index }})" 
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 price-value text-xs" data-row-id="{{ $loop->index }}">
                                                {{ $optional->optional_price }}
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value text-xs" data-row-id="{{ $loop->index }}">
                                                {{ $optional->optional_total }}
                                            </td>
                                        </tr>
                                        @endforeach                                
                                        <!-- New Row at the Bottom -->
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value"><strong>Total (RM)</strong></td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value">
                                                {{ $total_optional }}
                                            </td>
                                        </tr>
                                    </tbody>    
        
                                </table>
                                <button onclick="addRowOptional()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Add Row</button> --}}
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-4/12 p-4">
                        <div class="pickup-table-container w-full">
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
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
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
                <div class="flex justify-end">
                    <button
                        type="submit"
                        id="form2"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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

    function showForm3() {

        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];
        window.location.href = "{{ url('form4') }}/" + bookingId + "/" + amendId;
        // Hide the "Next form 2" button
        // document.getElementById("form2").style.display = "none";
        // Show the "Next form 3" button
        // document.getElementById("form3-container").style.display = "flex";
    }

    function handlePickupChange(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];

        const pickupName = event.target.value;  // Get the selected value
        const rowId = event.target.getAttribute('data-row-id');  // Get the row ID
        const pickupId = event.target.getAttribute('data-pickup-id'); // Pickup ID
        const pickupRate = event.target.getAttribute('data-pickup-rate'); // Pickup ID

        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,  // Pass bookingId in the request payload
                pickup_name: pickupName,
                pickup_id: pickupId,
                pickup_rate: pickupRate,
                type: 'update rate',
                arrange_type: 'pickup'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                document.querySelector(`.pax-value[data-row-id="${rowId}"]`).innerText = data.pickup_pax;
                document.querySelector(`.rate-value[data-row-id="${rowId}"]`).innerText = data.pickup_rate;
                document.querySelector(`.total-value[data-row-id="${rowId}"]`).innerText = data.pickup_total_rate;
                location.reload();
                
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });

    }

    function updatePaxValue(event, rowId, id) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];

        const newPaxValue = event.target.value;
        const pickupId = rowId;
        
        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                pickup_pax_value: newPaxValue,  
                pickup_id: pickupId,
                booking_id: bookingId,
                type: 'update total',
                arrange_type: 'pickup'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.pickup_total_rate;
                $('#total_pickup').val(data.total_pickup);
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });

    }

    function addRow() {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];

        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                type: 'add',
                arrange_type: 'pickup'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                // document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.pickup_total_rate;
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });
    }

    function handlePickupChangeDropoff(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];

        const dropoffName = event.target.value;  // Get the selected value
        const rowId = event.target.getAttribute('data-row-dropoff-id');  // Get the row ID
        const dropoffId = event.target.getAttribute('data-dropoff-id'); // Pickup ID
        const dropoffRate = event.target.getAttribute('data-dropoff-rate'); // Pickup ID

        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,  // Pass bookingId in the request payload
                dropoff_name: dropoffName,
                dropoff_id: dropoffId,
                dropoff_rate: dropoffRate,
                type: 'update rate',
                arrange_type: 'dropoff'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                document.querySelector(`.pax-value[data-row-dropoff-id="${rowId}"]`).innerText = data.dropoff_pax;
                document.querySelector(`.rate-value[data-row-dropoff-id="${rowId}"]`).innerText = data.dropoff_rate;
                document.querySelector(`.total-value[data-row-dropoff-id="${rowId}"]`).innerText = data.dropoff_total_rate;
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });

    }

    function updatePaxValueDropoff(event, rowId, id) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];

        const newPaxValue = event.target.value;
        const dropoffId = rowId;
        
        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                dropoff_pax_value: newPaxValue,  
                dropoff_id: dropoffId,
                booking_id: bookingId,
                type: 'update total',
                arrange_type: 'dropoff'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.pickup_total_rate;
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });

    }

    function addRowDropoff() {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];

        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                type: 'add',
                arrange_type: 'dropoff'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                // document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.pickup_total_rate;
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });
    }

    function handleOptionalChange(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        const optionalName = event.target.value;  // Get the selected value
        const rowId = event.target.getAttribute('data-row-id');  // Get the row ID
        const optionalId = event.target.getAttribute('data-optional-id'); // Pickup ID
        const optionalPrice = event.target.getAttribute('data-optional-price'); // Pickup ID
        const optionalSst = event.target.getAttribute('data-optional-sst'); // Pickup ID
        const optionalCode = event.target.getAttribute('data-optional-code'); // Pickup ID

        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,  // Pass bookingId in the request payload
                amendid: amendId,
                optional_name: optionalName,
                optional_id: optionalId,
                optional_price: optionalPrice,
                optional_sst: optionalSst,
                optional_code: optionalCode,
                type: 'update rate',
                arrange_type: 'optional'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                document.querySelector(`.qty-value[data-row-id="${rowId}"]`).innerText = data.optional_qty;
                document.querySelector(`.price-value[data-row-id="${rowId}"]`).innerText = data.pickup_price;
                document.querySelector(`.sst-value[data-row-id="${rowId}"]`).innerText = data.pickup_sst;
                document.querySelector(`.code-value[data-row-id="${rowId}"]`).innerText = data.pickup_code;
                document.querySelector(`.total-value[data-row-id="${rowId}"]`).innerText = data.optional_total;

                location.reload();
                
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching optional details:', error);
        });

    }

    function handleOptionalChangeOriginal(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        const optionalName = event.target.value;  // Get the selected value
        const optionalField =  event.target.getAttribute('data-optional-field');

        fetch(`{{ url('/form3') }}/${bookingId}/optionalOriginal`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,  // Pass bookingId in the request payload
                amendid: amendId,
                optional_name: optionalName,
                optionalField: optionalField,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                // document.querySelector(`.qty-value[data-row-id="${rowId}"]`).innerText = data.optional_qty;
                // document.querySelector(`.price-value[data-row-id="${rowId}"]`).innerText = data.pickup_price;
                // document.querySelector(`.sst-value[data-row-id="${rowId}"]`).innerText = data.pickup_sst;
                // document.querySelector(`.code-value[data-row-id="${rowId}"]`).innerText = data.pickup_code;
                // document.querySelector(`.total-value[data-row-id="${rowId}"]`).innerText = data.optional_total;

                location.reload();
                
            } else {
                alert(data.message || 'Failed to fetch optional arrangement details');
            }
        })
        .catch(error => {
            console.error('Error fetching optional details:', error);
        });

    }

    function updateQtyOriginalValue(event, descfield, qtyfield) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        const newqtyValue = event.target.value;

        fetch(`{{ url('/form3') }}/${bookingId}/updateQtyOptional`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,  // Pass bookingId in the request payload
                amendid: amendId,
                newqtyValue: newqtyValue,
                descfield: descfield,
                qtyfield: qtyfield,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
                
            } else {
                alert(data.message || 'Failed to fetch optional arrangement details');
            }
        })
        .catch(error => {
            console.error('Error fetching optional details:', error);
        });
    }

    function deleteOptionalOriginal(bookingId, descfield) {
        if (!confirm("Are you sure you want to delete?")) {
            return;
        }
        const urlParams = new URLSearchParams(window.location.search);
        const amendId = window.location.pathname.split('/')[5];


        fetch(`{{ url('/form3') }}/${bookingId}/deleteoptional`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendid: amendId,
                descfield: descfield,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Optional arrangement deleted successfully");
                location.reload(); // Refresh the page
            } else {
                alert("Failed to delete: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error deleting pickup:", error);
        });
    }


    function updateQtyValue(event, rowId, id) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];

        const newqtyValue = event.target.value;
        const optionalId = rowId;
        
        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                optional_qty: newqtyValue,  
                optional_id: optionalId,
                booking_id: bookingId,
                type: 'update total',
                arrange_type: 'optional'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.optional_total;
                // $('#total_pickup').val(data.total_pickup);
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });

    }

    function addRowOptional() {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];

        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                type: 'add',
                arrange_type: 'optional'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                // document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.pickup_total_rate;
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });
    }

    // original table - bookings
    function handlePickupChangeOriginal(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        const pickupName = event.target.value;  // Get the selected value

        const dataField = event.target.getAttribute('data-pickup-field');
        const pickupId = '';
        const pickupRate = 0;

        if (dataField == 'pickup01_method') {
            const pickupId = event.target.getAttribute('data-pickup-name'); // Pickup ID
            const pickupRate = event.target.getAttribute('data-pickup-rate'); // Pickup ID
        } else if (dataField == 'pickup01_method') {
            const pickupId = event.target.getAttribute('data-pickup2-name'); // Pickup ID
            const pickupRate = event.target.getAttribute('data-pickup2-rate'); // Pickup ID
        } else {
            const pickupId = event.target.getAttribute('data-pickup3-name'); // Pickup ID
            const pickupRate = event.target.getAttribute('data-pickup3-rate'); // Pickup ID
        }

        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,  // Pass bookingId in the request payload
                amendid: amendId,
                pickup_name: pickupName,
                pickup_id: pickupId,
                pickup_rate: pickupRate,
                pickup_field: dataField,
                type: 'update rate',
                arrange_type: 'pickup',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                // document.querySelector(`.pax-value[data-row-id="${rowId}"]`).innerText = data.pickup_pax;
                // document.querySelector(`.rate-value[data-row-id="${rowId}"]`).innerText = data.pickup_rate;
                // document.querySelector(`.total-value[data-row-id="${rowId}"]`).innerText = data.pickup_total_rate;
                location.reload();
                
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });

    }

    // function handlePickupChangeOriginal(event) {
    //     const urlParams = new URLSearchParams(window.location.search);
    //     const bookingId = window.location.pathname.split('/')[4];

    //     const pickupName = event.target.value;  // Get the selected value
    //     const dataField = event.target.getAttribute('data-pickup-field');

    //     let pickupId = '';
    //     let pickupRate = 0;

    //     const customInput = document.getElementById('custom-pickup-method');

    //     if (pickupName === 'other') {
    //         // Show the input field when "Other" is selected
    //         customInput.classList.remove('hidden');
    //         customInput.value = "";
    //         customInput.focus();
            
    //         // Clear the hidden input value
    //         document.getElementById('final-pickup-method').value = "";
            
    //         return;  // Stop execution to prevent API call when selecting "Other"
    //     } else {
    //         // Hide the custom input field when switching back to a dropdown option
    //         customInput.classList.add('hidden');
    //         customInput.value = ""; // Reset input field
    //     }

    //     // Get pickupId and pickupRate based on the field
    //     if (dataField === 'pickup01_method') {
    //         pickupId = event.target.getAttribute('data-pickup-name');
    //         pickupRate = event.target.getAttribute('data-pickup-rate');
    //     } else if (dataField === 'pickup02_method') {
    //         pickupId = event.target.getAttribute('data-pickup2-name');
    //         pickupRate = event.target.getAttribute('data-pickup2-rate');
    //     } else if (dataField === 'pickup03_method') {
    //         pickupId = event.target.getAttribute('data-pickup3-name');
    //         pickupRate = event.target.getAttribute('data-pickup3-rate');
    //     }

    //     // Update the hidden input value (useful for form submission)
    //     document.getElementById('final-pickup-method').value = pickupName;

    //     // Perform fetch API call
    //     fetch(`{{ url('/form3') }}/${bookingId}`, {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //         },
    //         body: JSON.stringify({
    //             booking_id: bookingId,
    //             pickup_name: pickupName,
    //             pickup_id: pickupId,
    //             pickup_rate: pickupRate,
    //             pickup_field: dataField,
    //             type: 'update rate',
    //             arrange_type: 'pickup',
    //             original: 'original'
    //         })
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             location.reload();
    //         } else {
    //             alert(data.message || 'Failed to fetch pickup details');
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Error fetching pickup details:', error);
    //     });
    // }


    function updatePaxValueOriginal(event, field) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        const newPaxValue = event.target.value;
        
        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                pickup_pax_value: newPaxValue,
                amendid:   amendId,
                booking_id: bookingId,
                field: field,
                type: 'update total',
                arrange_type: 'pickup',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.pickup_total_rate;
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });

    }

    function handleDropoffChangeOriginal(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        const dropoffName = event.target.value;  // Get the selected value

        const dataField = event.target.getAttribute('data-dropoff-field');
        const dropoffId = '';
        const dropoffRate = 0;

        if (dataField == 'dropoff01_method') {
            const dropoffId = event.target.getAttribute('data-dropoff-name'); // Pickup ID
            const dropoffRate = event.target.getAttribute('data-dropoff-rate'); // Pickup ID
        } else if (dataField == 'dropoff01_method') {
            const dropoffId = event.target.getAttribute('data-dropoff2-name'); // Pickup ID
            const dropoffRate = event.target.getAttribute('data-dropoff2-rate'); // Pickup ID
        } else {
            const dropoffId = event.target.getAttribute('data-dropoff3-name'); // Pickup ID
            const dropoffRate = event.target.getAttribute('data-dropoff3-rate'); // Pickup ID
        }

        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,  // Pass bookingId in the request payload
                amendid: amendId,
                dropoff_name: dropoffName,
                dropoff_id: dropoffId,
                dropoff_rate: dropoffRate,
                dropoff_field: dataField,
                type: 'update rate',
                arrange_type: 'dropoff',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the related table cells dynamically
                // document.querySelector(`.pax-value[data-row-id="${rowId}"]`).innerText = data.pickup_pax;
                // document.querySelector(`.rate-value[data-row-id="${rowId}"]`).innerText = data.pickup_rate;
                // document.querySelector(`.total-value[data-row-id="${rowId}"]`).innerText = data.pickup_total_rate;
                location.reload();
                
            } else {
                alert(data.message || 'Failed to fetch dropoff details');
            }
        })
        .catch(error => {
            console.error('Error fetching dropoff details:', error);
        });

    }

    function updatePaxValueDropoffOriginal(event, field) {
        const urlParams = new URLSearchParams(window.location.search);
        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        const newPaxValue = event.target.value;
        
        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                dropoff_pax_value: newPaxValue,  
                amendid: amendId,
                booking_id: bookingId,
                field: field,
                type: 'update total',
                arrange_type: 'dropoff',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.pickup_total_rate;
                location.reload();
            } else {
                alert(data.message || 'Failed to fetch pickup details');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
        });

    }

    function deletePickup(bookingId, pickupmethod) {
        if (!confirm("Are you sure you want to delete this pickup method?")) {
            return;
        }
        const urlParams = new URLSearchParams(window.location.search);
        const amendId = window.location.pathname.split('/')[5];


        fetch(`{{ url('/form3') }}/${bookingId}/delete-pickup`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendid: amendId,
                pickupmethod: pickupmethod,
                type: 'delete',
                arrange_type: 'pickup',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Pickup method deleted successfully");
                location.reload(); // Refresh the page
            } else {
                alert("Failed to delete: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error deleting pickup:", error);
        });
    }

    function deletePickupNew(bookingId, pickupid) {
        if (!confirm("Are you sure you want to delete this pickup method?")) {
            return;
        }

        fetch(`{{ url('/form3') }}/${bookingId}/delete-pickup`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                booking_id: bookingId,
                pickupid: pickupid,
                type: 'delete',
                arrange_type: 'pickup',
                original: 'new'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Pickup method deleted successfully");
                location.reload(); // Refresh the page
            } else {
                alert("Failed to delete: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error deleting pickup:", error);
        });
    }

    function deleteDropoff(bookingId, dropoffmethod) {
        if (!confirm("Are you sure you want to delete this dropoff method?")) {
            return;
        }
        const urlParams = new URLSearchParams(window.location.search);
        const amendId = window.location.pathname.split('/')[5];

        fetch(`{{ url('/form3') }}/${bookingId}/delete-pickup`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendid: amendId,
                dropoffmethod: dropoffmethod,
                type: 'delete',
                arrange_type: 'dropoff',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Dropoff method deleted successfully");
                location.reload(); // Refresh the page
            } else {
                alert("Failed to delete: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error deleting dropoff:", error);
        });
    }

    function deleteDropoffNew(bookingId, dropoffid) {
        if (!confirm("Are you sure you want to delete this dropoff method?")) {
            return;
        }

        fetch(`{{ url('/form3') }}/${bookingId}/delete-pickup`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                booking_id: bookingId,
                dropoffid: dropoffid,
                type: 'delete',
                arrange_type: 'dropoff',
                original: 'new'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Pickup method deleted successfully");
                location.reload(); // Refresh the page
            } else {
                alert("Failed to delete: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error deleting pickup:", error);
        });
    }





</script>
