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
                {{-- <nav class="mb-4" aria-label="Breadcrumb">
                    <ol class="flex flex-wrap items-center space-x-3 text-sm text-gray-600 dark:text-gray-300">
                        
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
                            <a href="{{ url('form3', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Land Transfer & Optional
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form4', [$bookings->booking_id, $amendId]) }}" class="text-indigo-600 font-semibold">
                                Remarks
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form5', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Summary & Payment
                            </a>
                        </li>
                    </ol>
                </nav> --}}
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
                            <a href="{{ url('form3', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Land Transfer & Optional
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form4', [$bookings->booking_id, $amendId]) }}" class="text-indigo-600 font-semibold">
                                Remarks
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('form5', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Summary & Payment
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
                    <div class="w-full md:w-8/12 p-4">
                        <div class="form-container flex flex-col gap-8">
                            <div class="pickup-table-container w-full">
                                <h2 class="text-xs font-bold text-gray-700 mb-4">Remarks For Customer</h2>
                                <div id="custRemark" class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">
                                    {{-- <input 
                                        type="text" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                        placeholder="Enter your text here..."
                                        value="{{ $bookings->remarks_customer }}"
                                        oninput="updateField({{ $bookings->booking_id }}, 'remarks_customer', this.value)"
                                    /> --}}
                                    <textarea 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                        rows="3"
                                        placeholder="Enter your text here..."
                                        oninput="updateField({{ $bookings->booking_id }}, 'remarks_customer', this.value)"
                                        >{{ $bookings->remarks_customer }}
                                    </textarea>
                                </div>
                            </div>
                    
                            <div class="form-container flex flex-row gap-8">
                                <div class="pickup-table-container w-1/2">
                                    <h2 class="text-xs font-bold text-gray-700 mb-4">Internal Remarks</h2>
                                    <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">
                                        <input 
                                            type="text" 
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                            placeholder="Enter your text here..."
                                            value="{{ $bookings->internal_remarks }}"
                                            oninput="updateField({{ $bookings->booking_id }}, 'internal_remarks', this.value)"
                                        />
                                    </div>
                                </div>
                    
                                <div class="pickup-table-container w-1/2">
                                    <h2 class="text-xs font-bold text-gray-700 mb-4">Dive Centre</h2>
                                    <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">
                                        <input 
                                            type="text" 
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                            placeholder="Enter your text here..."
                                            value="{{ $bookings->divecentre_remarks }}"
                                            oninput="updateField({{ $bookings->booking_id }}, 'divecentre_remarks', this.value)"
                                        />
                                    </div>
                                </div>
                            </div>          
            
                        </div>
                        <br />
                        <div class="form-container flex flex-col gap-8">
                            <div class="pickup-table-container w-full">
                                <h2 class="text-xs font-bold text-gray-700 mb-4">Amendments</h2>
                                <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">
                                    <div class="overflow-x-auto">
                                        <table class="w-full border-collapse border border-gray-300 text-xs">
                                            <!-- Adjust column widths -->
                                            <colgroup>
                                                <col class="w-16"> <!-- First column width -->
                                                <col> <!-- Second column auto-adjusts -->
                                            </colgroup>
                                            <tbody>
                                                @foreach(range(1, 10) as $index)
                                                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $index }}</td>
                                                        <td class="border border-gray-300 px-4 py-2">
                                                            <input 
                                                                type="text" 
                                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 text-xs"
                                                                placeholder="Enter text" 
                                                                value="{{ $bookings->{'amend0' . $index} }}" 
                                                                oninput="updateField({{ $bookings->booking_id }}, 'amend0{{ $index }}', this.value)"
                                                            />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        window.location.href = "{{ url('form5') }}/" + bookingId + "/" + amendId;
        // Hide the "Next form 2" button
        // document.getElementById("form2").style.display = "none";
        // Show the "Next form 3" button
        // document.getElementById("form3-container").style.display = "flex";
    }

    let typingTimers = {};
    const doneTypingInterval = 1000; // Delay before sending update (1 second)

    function updateField(bookingId, field, value) {
        // Clear previous timeout
        clearTimeout(typingTimers[field]);
        const urlParams = new URLSearchParams(window.location.search);
        const amendId = window.location.pathname.split('/')[5];

        // Set a new timeout to delay the request
        typingTimers[field] = setTimeout(() => {
            fetch(`{{ url('/form4') }}/${bookingId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ field: field, value: value, amendid: amendId })
            })
            .then(response => response.json())
            .then(data => alert('Updated successfully!'))
            .catch(error => console.error("Error updating field:", error));
        }, doneTypingInterval);
    }

</script>
