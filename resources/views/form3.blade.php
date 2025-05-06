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
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Rate (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Pax</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="pickup-rows">
                                        @php
                                            $pickups = [
                                                ['method' => 'pickup01_method', 'price' => 'pickup01_price', 'pax' => 'pickup01_pax', 'total' => 'pickup01_total', 'input' => 'pickup01_other_input', 'price_input' => 'pickup01_other_price'],
                                                ['method' => 'pickup02_method', 'price' => 'pickup02_price', 'pax' => 'pickup02_pax', 'total' => 'pickup02_total', 'input' => 'pickup02_other_input', 'price_input' => 'pickup02_other_price'],
                                                ['method' => 'pickup03_method', 'price' => 'pickup03_price', 'pax' => 'pickup03_pax', 'total' => 'pickup03_total', 'input' => 'pickup03_other_input', 'price_input' => 'pickup03_other_price'],
                                            ];
                                        @endphp
                                        
                                        @foreach ($pickups as $index => $pickup)
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            {{-- Method Select + Other Input --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <select
                                                    class="pickup-select w-full border border-gray-300 rounded-lg px-2 py-1 bg-white focus:ring-2 focus:ring-blue-500"
                                                    id="pickupmethod-{{ $index }}"
                                                    data-pickup-name="{{ $bookings[$pickup['method']] }}"
                                                    data-pickup-rate="{{ $bookings[$pickup['price']] }}"
                                                    data-pickup-field="{{ $pickup['method'] }}"
                                                    onchange="handlePickupChangeOriginal(event)"
                                                >
                                                    <option value="other">Other</option>
                                                    <option value="Please Choose" selected>{{ $bookings[$pickup['method']] }}</option>
                                                    @foreach ($pickupOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                        
                                                <input
                                                    type="text"
                                                    id="{{ $pickup['input'] }}"
                                                    name="{{ str_replace('_method', '_other', $pickup['method']) }}"
                                                    data-field="{{ $pickup['method'] }}"
                                                    class="mt-2 hidden w-full border border-gray-300 rounded-lg px-2 py-1 bg-white focus:ring-2 focus:ring-blue-500 text-xs"
                                                    placeholder="Enter custom pickup method"
                                                    value="{{ $bookings[$pickup['method']] }}"
                                                    onchange="handleCustomPickupBlur('{{ $pickup['input'] }}')"
                                                />
                                            </td>
                                        
                                            {{-- Rate Display + Editable Input --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value" data-pickup-name="{{ $bookings[$pickup['method']] }}">
                                                {{ $bookings[$pickup['price']] }}
                                                <input
                                                    type="number"
                                                    id="{{ $pickup['price_input'] }}"
                                                    name="{{ $pickup['price_input'] }}"
                                                    data-field="{{ $pickup['price'] }}"
                                                    class="mt-2 hidden w-full border border-gray-300 rounded-lg px-2 py-1 bg-white focus:ring-2 focus:ring-blue-500 text-xs"
                                                    value="{{ $bookings[$pickup['price']] }}"
                                                    onchange="handleCustomPickupPrice('{{ $pickup['price_input'] }}')"
                                                />
                                            </td>
                                        
                                            {{-- Pax Input --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value" data-pickup-name="{{ $bookings[$pickup['method']] }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 bg-white focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    data-pickup-name="{{ $bookings[$pickup['method']] }}"
                                                    data-pickup-rate="{{ $bookings[$pickup['price']] }}"
                                                    data-pickup-field="{{ $pickup['method'] }}"
                                                    value="{{ $bookings[$pickup['pax']] }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updatePaxValueOriginal(event, '{{ $pickup['method'] }}')"
                                                />
                                            </td>
                                        
                                            {{-- Total --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value" data-pickup-name="{{ $bookings[$pickup['method']] }}" id="totalPickup">
                                                {{ $bookings[$pickup['total']] }}
                                            </td>
                                        
                                            {{-- Delete Icon --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-center">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    class="w-5 h-5 cursor-pointer"
                                                    viewBox="0 0 48 48"
                                                    onclick="deletePickup({{ $bookings->booking_id }}, '{{ $pickup['method'] }}')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"/>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828-14.14,14.14-2.828-2.828L29.656,15.516z"/>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828-14.14-14.14 2.828-2.828L32.484,29.656z"/>
                                                </svg>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        {{-- Total Pickup Row --}}
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value">{{ $total_pickup }}</td>
                                        </tr>
                                        
                                    </tbody>    

                                </table>


                                <br/>
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
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Rate (RM)</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Pax</th>
                                            <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dropoff-rows">
                                        @php
                                            $dropoffs = [
                                                ['method' => 'dropoff01_method', 'price' => 'dropoff01_price', 'pax' => 'dropoff01_pax', 'total' => 'dropoff01_total', 'input' => 'dropoff01_other_input', 'price_input' => 'dropoff01_other_price'],
                                                ['method' => 'dropoff02_method', 'price' => 'dropoff02_price', 'pax' => 'dropoff02_pax', 'total' => 'dropoff02_total', 'input' => 'dropoff02_other_input', 'price_input' => 'dropoff02_other_price'],
                                                ['method' => 'dropoff03_method', 'price' => 'dropoff03_price', 'pax' => 'dropoff03_pax', 'total' => 'dropoff03_total', 'input' => 'dropoff03_other_input', 'price_input' => 'dropoff03_other_price'],
                                            ];
                                        @endphp
                                    
                                        @foreach ($dropoffs as $index => $dropoff)
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            {{-- Method Select + Other Input --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                <select
                                                    class="dropoff-select w-full border border-gray-300 rounded-lg px-2 py-1 bg-white focus:ring-2 focus:ring-blue-500"
                                                    id="dropoffmethod-{{ $index }}"
                                                    data-dropoff-name="{{ $bookings[$dropoff['method']] }}"
                                                    data-dropoff-rate="{{ $bookings[$dropoff['price']] }}"
                                                    data-dropoff-field="{{ $dropoff['method'] }}"
                                                    onchange="handleDropoffChangeOriginal(event)"
                                                >
                                                    <option value="other">Other</option>
                                                    <option value="Please Choose" selected>{{ $bookings[$dropoff['method']] }}</option>
                                                    @foreach ($dropoffOptions as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                    
                                                <input
                                                    type="text"
                                                    id="{{ $dropoff['input'] }}"
                                                    name="{{ str_replace('_method', '_other', $dropoff['method']) }}"
                                                    data-field="{{ $dropoff['method'] }}"
                                                    class="mt-2 hidden w-full border border-gray-300 rounded-lg px-2 py-1 bg-white focus:ring-2 focus:ring-blue-500 text-xs"
                                                    placeholder="Enter custom dropoff method"
                                                    value="{{ $bookings[$dropoff['method']] }}"
                                                    onchange="handleCustomDropoffBlur('{{ $dropoff['input'] }}')"
                                                />
                                            </td>
                                    
                                            {{-- Rate Display + Editable Input --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 rate-value" data-dropoff-name="{{ $bookings[$dropoff['method']] }}">
                                                {{ $bookings[$dropoff['price']] }}
                                                <input
                                                    type="number"
                                                    id="{{ $dropoff['price_input'] }}"
                                                    name="{{ $dropoff['price_input'] }}"
                                                    data-field="{{ $dropoff['price'] }}"
                                                    class="mt-2 hidden w-full border border-gray-300 rounded-lg px-2 py-1 bg-white focus:ring-2 focus:ring-blue-500 text-xs"
                                                    value="{{ $bookings[$dropoff['price']] }}"
                                                    onchange="handleCustomDropoffPrice('{{ $dropoff['price_input'] }}')"
                                                />
                                            </td>
                                    
                                            {{-- Pax Input --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 pax-value" data-dropoff-name="{{ $bookings[$dropoff['method']] }}">
                                                <input 
                                                    type="number" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 bg-white focus:ring-2 focus:ring-blue-500 text-xs" 
                                                    value="{{ $bookings[$dropoff['pax']] }}" 
                                                    min="1" 
                                                    step="1"
                                                    onchange="updatePaxValueDropoffOriginal(event, '{{ $dropoff['method'] }}')"
                                                />
                                            </td>
                                    
                                            {{-- Total --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value" data-dropoff-name="{{ $bookings[$dropoff['method']] }}">
                                                {{ $bookings[$dropoff['total']] }}
                                            </td>
                                    
                                            {{-- Delete Icon --}}
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 text-center">
                                                <svg 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    class="w-5 h-5 cursor-pointer"
                                                    viewBox="0 0 48 48"
                                                    onclick="deleteDropoff({{ $bookings->booking_id }}, '{{ $dropoff['method'] }}')"
                                                >
                                                    <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"/>
                                                    <path fill="#fff" d="M29.656,15.516l2.828,2.828-14.14,14.14-2.828-2.828L29.656,15.516z"/>
                                                    <path fill="#fff" d="M32.484,29.656l-2.828,2.828-14.14-14.14 2.828-2.828L32.484,29.656z"/>
                                                </svg>
                                            </td>
                                        </tr>
                                        @endforeach
                                    
                                        {{-- Total Dropoff Row --}}
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-4 py-2"></td>
                                            <td class="border border-gray-300 px-4 py-2 pax-value"></td>
                                            <td class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">Total (RM)</td>
                                            <td class="border border-gray-300 px-4 py-2 text-gray-700 total-value">{{ $total_dropoff }}</td>
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
                                        @php
                                            $optionals = [
                                                'optional01' => 'optional_code01',
                                                'optional02' => 'optional_code02',
                                                'optional03' => 'optional_code03',
                                                'optional04' => 'optional_code04',
                                                'optional05' => 'optional_code05',
                                            ];
                                        @endphp
                                    
                                        @foreach ($optionals as $index => $codeKey)
                                            @php
                                                $fieldPrefix = $index;
                                            @endphp
                                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100" data-row-id="row-{{ $loop->index }}">
                                                <td class="border px-4 py-2 text-xs text-gray-700">
                                                    <select
                                                        class="optional-select w-full border rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                        data-optional-field="{{ $fieldPrefix . '_desc' }}"
                                                        onchange="handleOptionalChangeOriginal(event)"
                                                    >
                                                        <option value="Please Choose" selected>{{ $bookings->{$fieldPrefix . '_desc'} }}</option>
                                                        @foreach ($optionalOptions as $option)
                                                            <option value="{{ $option }}">{{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border px-4 py-2 text-xs text-gray-700 sst-value">
                                                    {{ $bookings->{$fieldPrefix . '_GST'} }}
                                                </td>
                                                <td class="border px-4 py-2 text-xs text-gray-700 code-value">
                                                    {{ $bookings->{$fieldPrefix . '_bill_to'} }}
                                                </td>
                                                <td class="border px-4 py-2 text-xs text-gray-700 qty-value">
                                                    <input 
                                                        type="number" 
                                                        class="w-full border rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs" 
                                                        value="{{ $bookings->{$fieldPrefix . '_pax'} }}" 
                                                        min="1" 
                                                        step="1"
                                                        onchange="updateQtyOriginalValue(event, '{{ $fieldPrefix . '_desc' }}', '{{ $fieldPrefix . '_pax' }}')" 
                                                    />
                                                </td>
                                                <td class="border px-4 py-2 text-xs text-gray-700 price-value">
                                                    {{ $bookings->{$fieldPrefix . '_price'} }}
                                                </td>
                                                <td class="border px-4 py-2 text-xs text-gray-700 total-value">
                                                    {{ $bookings->{$fieldPrefix . '_total'} }}
                                                </td>
                                                <td class="border px-4 py-2 text-xs text-gray-700">
                                                    <svg 
                                                        xmlns="http://www.w3.org/2000/svg" 
                                                        width="20" height="20" viewBox="0 0 48 48" 
                                                        class="cursor-pointer"
                                                        onclick="deleteOptionalOriginal({{ $bookings->booking_id }}, '{{ $fieldPrefix . '_desc' }}')"
                                                    >
                                                        <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                                                        <path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path>
                                                        <path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
                                                    </svg>
                                                </td>
                                            </tr>
                                        @endforeach
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
                <br/>
                {{-- <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 px-4 py-3 flex justify-end space-x-4 z-50">
                    <button
                        type="button"
                        id="back"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 text-xs"
                        onclick="back()"
                    >
                        Back
                    </button>
                    <button
                        type="button"
                        id="save"
                        class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300 text-xs"
                        onclick="save('save')"
                    >
                        Save
                    </button>
                    <button
                        type="button"
                        id="form2"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 text-xs"
                        onclick="save('saveNext')"
                    >
                        Save & Next
                    </button>
                </div>                                 --}}
                <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 px-4 py-3 flex justify-end gap-3 z-50 shadow-md">
                    <!-- Navigation Buttons -->
                    <button
                        type="button"
                        id="btn-back"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition text-sm"
                        onclick="back()"
                        aria-label="Go Back"
                    >
                        Back
                    </button>
                
                    <button
                        type="button"
                        id="btn-next"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition text-sm"
                        onclick="next()"
                        aria-label="Go to Next Step"
                    >
                        Next
                    </button>
                
                    <!-- Save Buttons -->
                    <button
                        type="button"
                        id="btn-save"
                        class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition text-sm"
                        onclick="save('save')"
                        aria-label="Save Form"
                    >
                        Save
                    </button>
                
                    <button
                        type="button"
                        id="btn-save-next"
                        class="px-6 py-3 bg-green-700 text-white rounded-md hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 transition text-sm"
                        onclick="save('saveNext')"
                        aria-label="Save and Proceed"
                    >
                        Save & Next
                    </button>
                </div>

                                
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    function save(type) {
        const pathSegments = window.location.pathname.split('/').filter(Boolean);
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3];
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1];
            amendId = pathSegments[2];
        }

        const rows = document.querySelectorAll('tbody tr');
        const paxData = {
            amendid: amendId,
            pickupData: [],
            dropoffData: [],
        };

        // First: PICKUP rows (if you have a separate tbody for pickup)
        const pickupRows = document.querySelectorAll('tbody.pickup-rows tr');
        pickupRows.forEach((row, idx) => {
            const selectEl = row.querySelector('select.pickup-select');
            const paxInput = row.querySelector('td.pax-value input');
            const totalTd = row.querySelector('td.total-value');

            if (!selectEl || !paxInput || !totalTd) return;

            const pickupField = selectEl.dataset.pickupField;
            const pickupRate = parseFloat(paxInput.dataset.pickupRate || selectEl.dataset.pickupRate);

            paxData.pickupData.push({
                pickup_name: pickupField,
                pickup_rate: pickupRate,
                pickup_pax: parseInt(paxInput.value),
                pickup_total: parseFloat(totalTd.textContent.trim()),
                pickup_selected: selectEl.value !== 'other'
                    ? selectEl.options[selectEl.selectedIndex].text.trim()
                    : document.getElementById(selectEl.dataset.pickupField.replace('_method', '_other_input')).value.trim()
            });
        });

        // Then: DROPOFF rows (separate tbody)
        const dropoffRows = document.querySelectorAll('tbody.dropoff-rows tr');
        dropoffRows.forEach((row, idx) => {
            const selectElDropoff = row.querySelector('select.dropoff-select');
            const paxInput = row.querySelector('td.pax-value input');
            const totalTd = row.querySelector('td.total-value');

            if (!selectElDropoff || !paxInput || !totalTd) return;

            const dropoffField = selectElDropoff.dataset.dropoffField;
            const dropoffRate = parseFloat(paxInput.dataset.dropoffRate || selectElDropoff.dataset.dropoffRate);

            paxData.dropoffData.push({
                dropoff_name: dropoffField,
                dropoff_rate: dropoffRate,
                dropoff_pax: parseInt(paxInput.value),
                dropoff_total: parseFloat(totalTd.textContent.trim()),
                dropoff_selected: selectElDropoff.value !== 'other'
                    ? selectElDropoff.options[selectElDropoff.selectedIndex].text.trim()
                    : document.getElementById(selectElDropoff.dataset.dropoffField.replace('_method', '_other_input')).value.trim()
            });
        });

        const optionalRows = document.querySelectorAll('tbody tr'); // Update if you have a specific class

        paxData.optionalData = [];

        optionalRows.forEach(row => {
            const selectEl = row.querySelector('select.optional-select'); // Assuming class is reused
            const gstTd = row.querySelector('td.sst-value');
            const codeTd = row.querySelector('td.code-value');
            const qtyInput = row.querySelector('input[type="number"]');
            const priceTd = row.querySelector('td.price-value');
            const totalTd = row.querySelector('td.total-value');

            if (!selectEl || !qtyInput || !priceTd || !totalTd || !codeTd || !gstTd) return;

            paxData.optionalData.push({
                optional_field: selectEl.dataset.optionalField,
                optional_selected: selectEl.options[selectEl.selectedIndex].text.trim(),
                optional_gst: gstTd.textContent.trim(),
                optional_code: codeTd.textContent.trim(),
                optional_qty: parseInt(qtyInput.value),
                optional_price: parseFloat(priceTd.textContent.trim()),
                optional_total: parseFloat(totalTd.textContent.trim())
            });
        });

        console.log(paxData);

        fetch(`{{ url('/form3') }}/${bookingId}/save`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                type,
                booking_id: bookingId,
                ...paxData
            })
        }).then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert('Successfully saved!');
                if (type == 'saveNext') {
                    window.location.href = "{{ url('form4') }}/" + bookingId + "/" + amendId;
                } else {
                    location.reload();
                }
            }
        }).catch(err => {
            console.error('Save failed', err);
        });
    }


    function back() {

        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }
        window.location.href = "{{ url('form2') }}/" + bookingId + "/" + amendId;

    }
    function next() {

        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }
        window.location.href = "{{ url('form4') }}/" + bookingId + "/" + amendId;

    }

    function showForm3() {

        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        window.location.href = "{{ url('form4') }}/" + bookingId + "/" + amendId;
    }

    function updatePaxValue(event, rowId, id) {
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
        } else {
            bookingId = pathSegments[1]; 
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
        } else {
            bookingId = pathSegments[1]; 
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean);
        const hostname = window.location.hostname;

        let bookingId = (hostname === 'localhost') ? pathSegments[3] : pathSegments[1];
        let amendId = (hostname === 'localhost') ? pathSegments[4] : pathSegments[2];

        const select = event.target;
        const optionalName = select.value;
        const optionalField = select.getAttribute('data-optional-field');
        const row = select.closest('tr');
        console.log(row);

        const baseUrl = window.location.origin;

        fetch(`{{ url('/form3') }}/${bookingId}/optionalOriginal`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendid: amendId,
                optional_name: optionalName,
                optionalField: optionalField,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // row.querySelector('.qty-value input').value = data.optional_qty;
                row.querySelector('.sst-value').textContent = data.data.optional_sst;
                row.querySelector('.code-value').textContent = data.data.optional_code;
                row.querySelector('.price-value').textContent = data.data.optional_price;
                // row.querySelector('.total-value').textContent = data.optional_total;
            } else {
                alert(data.message || 'Failed to fetch optional arrangement details');
            }
        })
        .catch(error => {
            console.error('Error fetching optional details:', error);
        });
    }

    function updateQtyOriginalValue(event, descfield, qtyfield) {
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        const newqtyValue = event.target.value;
        const row = event.target.closest('tr');
        const price = parseFloat(row.querySelector('.price-value').textContent) || 0;

        // Calculate and update total on the frontend
        const total = (newqtyValue * price).toFixed(2);
        row.querySelector('.total-value').textContent = total;

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
                console.log(data);
                // location.reload();
                
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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let amendId;

        if (hostname === 'localhost') {
            amendId = pathSegments[4];
        } else {
            amendId = pathSegments[2];
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
        } else {
            bookingId = pathSegments[1]; 
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
        } else {
            bookingId = pathSegments[1]; 
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        const pickupName = event.target.value;  // Get the selected value

        const dataField = event.target.getAttribute('data-pickup-field');
        const pickupId = '';
        const pickupRate = 0;

        if (dataField == 'pickup01_method') {
            const pickupId = event.target.getAttribute('data-pickup-name'); // Pickup ID
            const pickupRate = event.target.getAttribute('data-pickup-rate'); // Pickup ID

            const otherInput = document.getElementById('pickup01_other_input');
            const otherInputPrice = document.getElementById('pickup01_other_price');

            if (pickupName === 'other') {
                if (otherInput) {
                    otherInput.classList.remove('hidden');
                    otherInput.focus();
                }

                if (otherInputPrice) {
                    otherInputPrice.classList.remove('hidden');
                    otherInputPrice.focus();
                }
                return; // Don't continue if waiting for user input
            } else {
                if (otherInput) {
                    otherInput.classList.add('hidden');
                    otherInput.value = '';
                }
            }
        } else if (dataField == 'pickup02_method') {
            const pickupId = event.target.getAttribute('data-pickup2-name'); // Pickup ID
            const pickupRate = event.target.getAttribute('data-pickup2-rate'); // Pickup ID
            const otherInput = document.getElementById('pickup02_other_input');
            const otherInputPrice = document.getElementById('pickup02_other_price');

            if (pickupName === 'other') {
                if (otherInput) {
                    otherInput.classList.remove('hidden');
                    otherInput.focus();
                }

                if (otherInputPrice) {
                    otherInputPrice.classList.remove('hidden');
                    otherInputPrice.focus();
                }
                return; // Don't continue if waiting for user input
            } else {
                if (otherInput) {
                    otherInput.classList.add('hidden');
                    otherInput.value = '';
                }
            }
        } else {
            const pickupId = event.target.getAttribute('data-pickup3-name'); // Pickup ID
            const pickupRate = event.target.getAttribute('data-pickup3-rate'); // Pickup ID

            const otherInput = document.getElementById('pickup03_other_input');
            const otherInputPrice = document.getElementById('pickup03_other_price');

            if (pickupName === 'other') {
                if (otherInput) {
                    otherInput.classList.remove('hidden');
                    otherInput.focus();
                }

                if (otherInputPrice) {
                    otherInputPrice.classList.remove('hidden');
                    otherInputPrice.focus();
                }
                return; // Don't continue if waiting for user input
            } else {
                if (otherInput) {
                    otherInput.classList.add('hidden');
                    otherInput.value = '';
                }
            }
        }

        if (pickupName != 'other') {
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
                    const rateField = data.price_field; // e.g., pickup01_price
                    const rate = data.pickup_rate;

                    // Find input and update its value
                    const input = document.querySelector(`input[data-field="${rateField}"]`);
                    if (input) {
                        input.value = rate;

                        // Update visible rate value in the same <td>
                        const td = input.closest('td');
                        if (td) {
                            // Remove previous text and set new rate before input
                            td.childNodes[0].nodeValue = ' ' + rate;
                        }
                    }

                    // Optionally trigger a total update here
                    // updateTotalPickup();
                } else {
                    alert(data.message || 'Failed to fetch pickup details');
                }
            })
            .catch(error => {
                console.error('Error fetching pickup details:', error);
            });
        }
    }

    function handleCustomPickupBlur(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;

        // Grab the input value
        const otherValue = input.value.trim();
        const dataField = input.getAttribute('data-field');

        // If the value is empty, stop execution
        if (!otherValue) return;

        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        // Send the request
        fetch(`{{ url('/form3') }}/${bookingId}/other`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendid: amendId,
                pickup_name: otherValue,
                pickup_id: 'other',
                pickup_rate: 0,
                pickup_field: dataField,
                type: 'update rate',
                arrange_type: 'pickup',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to save custom pickup');
            }
        })
        .catch(error => {
            console.error('Error saving custom pickup:', error);
        });
    }

    function handleCustomPickupPrice(inputId) {
        // const pax = document.getElementById('pickup01_pax_input').value;
        const input = document.getElementById(inputId);
        if (!input) return;

        // Grab the input value
        const otherValue = input.value.trim();
        console.log(otherValue);
        const dataField = input.getAttribute('data-field');

        // If the value is empty, stop execution
        if (!otherValue) return;

        const bookingId = window.location.pathname.split('/')[4];
        const amendId = window.location.pathname.split('/')[5];

        // Send the request
        fetch(`{{ url('/form3') }}/${bookingId}/other`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendid: amendId,
                pickup_name: otherValue,
                pickup_id: 'other',
                pickup_rate: 0,
                pickup_field: dataField,
                type: 'update rate',
                arrange_type: 'pickup',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to save custom pickup');
            }
        })
        .catch(error => {
            console.error('Error saving custom pickup:', error);
        });
    }

    function handleCustomDropoffBlur(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;

        // Grab the input value
        const otherValue = input.value.trim();
        const dataField = input.getAttribute('data-field');

        // If the value is empty, stop execution
        if (!otherValue) return;

        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        // Send the request
        fetch(`{{ url('/form3') }}/${bookingId}/otherDropoff`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendid: amendId,
                dropoff_name: otherValue,
                dropoff_id: 'other',
                dropoff_rate: 0,
                dropoff_field: dataField,
                type: 'update rate',
                arrange_type: 'dropoff',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to save custom pickup');
            }
        })
        .catch(error => {
            console.error('Error saving custom pickup:', error);
        });
    }

    function handleCustomDropoffPrice(inputId) {
        // const pax = document.getElementById('pickup01_pax_input').value;
        const input = document.getElementById(inputId);
        if (!input) return;

        // Grab the input value
        const otherValue = input.value.trim();
        const dataField = input.getAttribute('data-field');

        // If the value is empty, stop execution
        if (!otherValue) return;

        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        // Send the request
        fetch(`{{ url('/form3') }}/${bookingId}/otherDropoff`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendid: amendId,
                dropoff_name: otherValue,
                dropoff_id: 'other',
                dropoff_rate: 0,
                dropoff_field: dataField,
                type: 'update rate',
                arrange_type: 'dropoff',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to save custom pickup');
            }
        })
        .catch(error => {
            console.error('Error saving custom pickup:', error);
        });
    }

    // function updatePaxValueOriginal(event, field) {
    //     const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
    //     const hostname = window.location.hostname;

    //     let bookingId, amendId;

    //     if (hostname === 'localhost') {
    //         bookingId = pathSegments[3]; 
    //         amendId = pathSegments[4];
    //     } else {
    //         bookingId = pathSegments[1]; 
    //         amendId = pathSegments[2];
    //     }

    //     const newPaxValue = event.target.value;
        
    //     fetch(`{{ url('/form3') }}/${bookingId}`, {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //         },
    //         body: JSON.stringify({
    //             pickup_pax_value: newPaxValue,
    //             amendid:   amendId,
    //             booking_id: bookingId,
    //             field: field,
    //             type: 'update total',
    //             arrange_type: 'pickup',
    //             original: 'original'
    //         })
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             // document.querySelector(`.total-value[data-row-id="${id}"]`).innerText = data.pickup_total_rate;
    //             // location.reload();
    //         } else {
    //             alert(data.message || 'Failed to fetch pickup details');
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Error fetching pickup details:', error);
    //     });

    // }

    function updatePaxValueOriginal(event, field) {
        const pathSegments = window.location.pathname.split('/').filter(Boolean);
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        const input = event.target;
        const newPaxValue = parseInt(input.value);
        const row = input.closest('tr');

        // Get rate from the .rate-value td in the same row
        const rateTd = row.querySelector('td.rate-value');
        let rate = parseFloat(rateTd.textContent.trim());
        if (isNaN(rate)) rate = 0;

        // Calculate new total
        const newTotal = rate * newPaxValue;

        // Update total <td> in the DOM
        const totalTd = row.querySelector('td.total-value');
        if (totalTd) {
            totalTd.textContent = newTotal.toFixed(2);
        }

        // Also update the final summary total row
        updateTotalPickup();

        // Send updated pax value to backend
        fetch(`{{ url('/form3') }}/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                pickup_pax_value: newPaxValue,
                amendid: amendId,
                booking_id: bookingId,
                field: field,
                type: 'update total',
                arrange_type: 'pickup',
                original: 'original'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Failed to update pax');
            }
        })
        .catch(error => {
            console.error('Error updating pax:', error);
        });
    }

    function updateTotalPickup() {
        let totalPickup = 0;

        // Loop through each rate and pax in the table rows
        document.querySelectorAll('tr').forEach(row => {
            const rateTd = row.querySelector('td.rate-value');
            const paxInput = row.querySelector('td.pax-value input');
            const totalTd = row.querySelector('td.total-value');

            if (rateTd && paxInput && totalTd) {
                let rate = parseFloat(rateTd.textContent.trim());
                let pax = parseInt(paxInput.value);

                if (isNaN(rate)) rate = 0;
                if (isNaN(pax)) pax = 0;

                const rowTotal = rate * pax;
                totalTd.textContent = rowTotal.toFixed(2);

                totalPickup += rowTotal;
            }
        });

        // Update the final total row (last .total-value cell)
        const totalCells = document.querySelectorAll('td.total-value');
        if (totalCells.length > 0) {
            const lastTotalCell = totalCells[totalCells.length - 1];
            lastTotalCell.textContent = totalPickup.toFixed(2);
        }
    }

    function updateTotalDropoff() {
        let totalDropoff = 0;

        // Loop through each rate and pax in the table rows
        document.querySelectorAll('tr').forEach(row => {
            const rateTd = row.querySelector('td.rate-value');
            const paxInput = row.querySelector('td.pax-value input');
            const totalTd = row.querySelector('td.total-value');

            if (rateTd && paxInput && totalTd) {
                let rate = parseFloat(rateTd.textContent.trim());
                let pax = parseInt(paxInput.value);

                if (isNaN(rate)) rate = 0;
                if (isNaN(pax)) pax = 0;

                const rowTotal = rate * pax;
                totalTd.textContent = rowTotal.toFixed(2);

                totalDropoff += rowTotal;
            }
        });

        // Update the final total row (last .total-value cell)
        const totalCells = document.querySelectorAll('td.total-value');
        if (totalCells.length > 0) {
            const lastTotalCell = totalCells[totalCells.length - 1];
            lastTotalCell.textContent = totalDropoff.toFixed(2);
        }
    }



    function handleDropoffChangeOriginal(event) {
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        const dropoffName = event.target.value;  // Get the selected value

        const dataField = event.target.getAttribute('data-dropoff-field');
        const dropoffId = '';
        const dropoffRate = 0;

        if (dataField == 'dropoff01_method') {
            const dropoffId = event.target.getAttribute('data-dropoff-name'); // Pickup ID
            const dropoffRate = event.target.getAttribute('data-dropoff-rate'); // Pickup ID

            const otherInput = document.getElementById('dropoff01_other_input');
            const otherInputPrice = document.getElementById('dropoff01_other_price');

            if (dropoffName === 'other') {
                if (otherInput) {
                    otherInput.classList.remove('hidden');
                    otherInput.focus();
                }

                if (otherInputPrice) {
                    otherInputPrice.classList.remove('hidden');
                    otherInputPrice.focus();
                }
                return; // Don't continue if waiting for user input
            } else {
                if (otherInput) {
                    otherInput.classList.add('hidden');
                    otherInput.value = '';
                }
            }
        } else if (dataField == 'dropoff02_method') {
            const dropoffId = event.target.getAttribute('data-dropoff2-name'); // Pickup ID
            const dropoffRate = event.target.getAttribute('data-dropoff2-rate'); // Pickup ID

            const otherInput = document.getElementById('dropoff02_other_input');
            const otherInputPrice = document.getElementById('dropoff02_other_price');

            if (dropoffName === 'other') {
                if (otherInput) {
                    otherInput.classList.remove('hidden');
                    otherInput.focus();
                }

                if (otherInputPrice) {
                    otherInputPrice.classList.remove('hidden');
                    otherInputPrice.focus();
                }
                return; // Don't continue if waiting for user input
            } else {
                if (otherInput) {
                    otherInput.classList.add('hidden');
                    otherInput.value = '';
                }
            }
        } else {
            const dropoffId = event.target.getAttribute('data-dropoff3-name'); // Pickup ID
            const dropoffRate = event.target.getAttribute('data-dropoff3-rate'); // Pickup ID

            const otherInput = document.getElementById('dropoff03_other_input');
            const otherInputPrice = document.getElementById('dropoff03_other_price');

            if (dropoffName === 'other') {
                if (otherInput) {
                    otherInput.classList.remove('hidden');
                    otherInput.focus();
                }

                if (otherInputPrice) {
                    otherInputPrice.classList.remove('hidden');
                    otherInputPrice.focus();
                }
                return; // Don't continue if waiting for user input
            } else {
                if (otherInput) {
                    otherInput.classList.add('hidden');
                    otherInput.value = '';
                }
            }
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
                    const rateField = data.price_field; // e.g., pickup01_price
                    const rate = data.dropoff_rate;

                    // Find input and update its value
                    const input = document.querySelector(`input[data-field="${rateField}"]`);
                    if (input) {
                        input.value = rate;

                        // Update visible rate value in the same <td>
                        const td = input.closest('td');
                        if (td) {
                            // Remove previous text and set new rate before input
                            td.childNodes[0].nodeValue = ' ' + rate;
                        }
                    }

                    // Optionally trigger a total update here
                    // updateTotalPickup();
                } else {
                    alert(data.message || 'Failed to fetch pickup details');
                }
        })
        .catch(error => {
            console.error('Error fetching dropoff details:', error);
        });

    }

    function updatePaxValueDropoffOriginal(event, field) {
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let bookingId, amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

        const input = event.target;
        const newPaxValue = parseInt(input.value);
        const row = input.closest('tr');

        // Get rate from the .rate-value td in the same row
        const rateTd = row.querySelector('td.rate-value');
        let rate = parseFloat(rateTd.textContent.trim());
        if (isNaN(rate)) rate = 0;

        // Calculate new total
        const newTotal = rate * newPaxValue;

        // Update total <td> in the DOM
        const totalTd = row.querySelector('td.total-value');
        if (totalTd) {
            totalTd.textContent = newTotal.toFixed(2);
        }

        // Also update the final summary total row
        updateTotalDropoff();

        // Send updated pax value to backend
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
            if (!data.success) {
                alert(data.message || 'Failed to update pax');
            }
        })
        .catch(error => {
            console.error('Error updating pax:', error);
        });

    }

    function deletePickup(bookingId, pickupmethod) {
        if (!confirm("Are you sure you want to delete this pickup method?")) {
            return;
        }
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

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
        const pathSegments = window.location.pathname.split('/').filter(Boolean); // removes empty segments
        const hostname = window.location.hostname;

        let amendId;

        if (hostname === 'localhost') {
            bookingId = pathSegments[3]; 
            amendId = pathSegments[4];
        } else {
            bookingId = pathSegments[1]; 
            amendId = pathSegments[2];
        }

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
