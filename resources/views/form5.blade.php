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
                            <a href="{{ url('form5', [$bookings->booking_id, $amendId]) }}" class="text-indigo-600 font-semibold">
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
                    {{-- <p>
                        <strong>Days:</strong> <span id="days">{{ $days }}</span> |  
                        <strong>Night:</strong> <span id="night">{{ $nights }}</span>
                    </p> --}}
                </div>
            </div>
            <br />
            <div class="form-container flex flex-col gap-8">
                <div class="pickup-table-container w-full">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Booking Summary</h2>
                    <div class="w-full overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300 text-xs">
                                <tbody>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            Package Amount (RM)
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            RM {{ number_format($bookings->package_total, 2) }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            Land Transfer (RM)
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                           RM {{ number_format($bookings->landtransfer_total, 2) }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            Optional Arrangement (RM)
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            RM {{ number_format($bookings->optional_total, 2) }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            Optional Arrangement (RM) SST Free
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            RM {{ number_format($total_optional_no_sst, 2) }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            Total Amount No SST (RM)
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            RM {{ number_format($total_amount_no_sst, 2) }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            8% SST (RM)
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            RM {{ number_format($total_sst, 2) }}
                                        </td>
                                    </tr><tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            Grand Total with SST (RM)
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            RM {{ number_format($grand_total_with_sst, 2) }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            Deposit Amount (RM)
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex items-center space-x-2">
                                                <label class="text-gray-700">RM</label>
                                                <input 
                                                    id="deposit"
                                                    type="text" 
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs"
                                                    onkeyup="changeDeposit(this.value)" 
                                                    value="{{ $bookings->deposit_amount ? $bookings->deposit_amount : '0.00'}}"
                                                />
                                            </div>
                                        </td>
                                        
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            Amount Due (RM)
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            RM {{ number_format($amount_due, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const bookingId = window.location.pathname.split('/')[4];
    const amendId = window.location.pathname.split('/')[5];

    let typingTimers = {};
    const doneTypingInterval = 1000; // Delay before sending update (1 second)

    function changeDeposit(value) {
        let field = 'deposit_amount'
        // Clear previous timeout
        clearTimeout(typingTimers[field]);

        // Set a new timeout to delay the request
        typingTimers[field] = setTimeout(() => {
            fetch(`{{ url('/form5') }}/${bookingId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ field: field, value: value, amendid: amendId})
            })
            .then(response => response.json())
            .then(data => alert('Updated successfully!'))
            .catch(error => console.error("Error updating field:", error));
        }, doneTypingInterval);

    }

</script>
