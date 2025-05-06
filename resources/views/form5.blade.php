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
                            <br />
                            <div class="overflow-x-auto">
                                <table class="table-auto min-w-[600px] w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">Date</th>
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">Amount</th>
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">Bank</th>
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">Bank Details</th>
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($receipts as $key => $receipt)
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <input type="hidden" name="aiid[]" id="aiid_{{ $key }}" value="{{ $receipt->AI_ID }}">
                                            
                                            <td class="border border-gray-300 px-2 py-2">
                                                {{-- <input type="date" name="date[]" id="datePicker_{{ $key }}" class="border px-2 py-1 w-full text-xs" 
                                                    value="{{ $receipt->paid_date ? \Carbon\Carbon::parse($receipt->paid_date)->format('Y-m-d') : '' }}"> --}}
                                                {{ $receipt->paid_date ? \Carbon\Carbon::parse($receipt->paid_date)->format('Y-m-d') : '' }}
                                            </td>
                            
                                            <td class="border border-gray-300 px-2 py-2">
                                                {{-- <input type="number" name="amount[]" id="amount_{{ $key }}" class="w-full border rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500" 
                                                    value="{{ $receipt->amount }}"> --}}
                                                {{ $receipt->amount }}
                                            </td>
                            
                                            <td class="border border-gray-300 px-2 py-2">
                                                {{-- <input type="text" name="bank[]" id="bank_{{ $key }}" class="w-full border rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500"  --}}
                                                    {{-- value="{{ $receipt->bank }}"> --}}
                                                 {{ $receipt->bank }}
                                            </td>
                            
                                            <td class="border border-gray-300 px-2 py-2">
                                                {{-- <input type="text" name="bank_details[]" id="bank_details_{{ $key }}" class="w-full border rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500" 
                                                    value="{{ $receipt->bank_details }}"> --}}
                                                {{ $receipt->bank_details }}
                                            </td>
                            
                                            <td class="border border-gray-300 px-2 py-2">
                                                {{ $receipt->ID }}
                                            </td>
                                        </tr>
                                        @endforeach                             
                            
                                        <!-- Summary Rows -->
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-2 py-2"><strong>Last Paid: {{ $lastpaid->paid_date ?? 0 }}</strong></td>
                                            <td class="border border-gray-300 px-2 py-2" colspan=4>
                                                {{ number_format($totalpay ?? 0, 2) }}
                                            </td>
                                        </tr> 
                                        <tr class="bg-gray-100 hover:bg-gray-200 text-xs">
                                            <td class="border border-gray-300 px-2 py-2"><strong>Balance (RM)</strong></td>
                                            <td class="border border-gray-300 px-2 py-2" colspan=4>
                                                {{ number_format(($grand_total_with_sst - $totalpay) ?? 0, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>    
                                </table>
                                <br />
                                <table class="table-auto min-w-[600px] w-full border border-gray-300 text-left">
                                    <thead class="bg-gray-100">
                                        <tr class="text-xs">
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">Date</th>
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">Amount</th>
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">Bank</th>
                                            <th class="border border-gray-300 px-2 py-2 font-semibold text-gray-700">Bank Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                            <td class="border border-gray-300 px-2 py-2">
                                                <input type="date" name="date" id="datePicker" class="border px-2 py-1 w-full text-xs" 
                                                    value="">
                                               
                                            </td>
                            
                                            <td class="border border-gray-300 px-2 py-2">
                                                <input type="number" name="amount" id="amount" class="w-full border rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500" 
                                                    value="">
                                                
                                            </td>
                            
                                            {{-- <td class="border border-gray-300 px-2 py-2">
                                                <input type="text" name="bank" id="bank" class="w-full border rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500" value="">
                                                
                                            </td> --}}
                                            <td class="border border-gray-300 px-2 py-2">
                                                <select name="bank" id="bank" class="w-full border rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500">
                                                    <option value="">Select a bank</option>
                                                    <option value="HLBB">HLB</option>
                                                    <option value="MBB">MBB</option>
                                                    <option value="RHB">RHB</option>
                                                    <option value="UOB">UOB</option>
                                                    <option value="Cash">Cash</option>
                                                </select>
                                            </td>
                            
                                            <td class="border border-gray-300 px-2 py-2">
                                                <input type="text" name="bank_details" id="bank_details" class="w-full border rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500" 
                                                    value="">
                                            </td>
                                        </tr>
                                    </tbody>    
                                </table>
                            </div>
                            

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
                            
                                <button onclick="generatepayment()" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition text-sm">Generate Payment</button>
                            
                                <button onclick="viewinvoice()" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition text-sm">View Invoice</button>
                            </div>
            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

<script>
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

    function save() {
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

        let rows = document.querySelectorAll("tbody tr:not(:last-child):not(:nth-last-child(2))");
        let receiptData = [];

        rows.forEach((row, index) => {
            let aiInput = row.querySelector("input[name='aiid[]']");
            let dateInput = row.querySelector("input[name='date[]']");
            let amountInput = row.querySelector("input[name='amount[]']");
            let bankInput = row.querySelector("input[name='bank[]']");
            let bankDetailsInput = row.querySelector("input[name='bank_details[]']");

            // ✅ Skip empty rows (if all inputs are missing)
            if (!aiInput && !dateInput && !amountInput && !bankInput && !bankDetailsInput) {
                console.warn(`Row ${index + 1} is empty, skipping...`);
                return;
            }

            if (aiInput && dateInput && amountInput && bankInput && bankDetailsInput) {
                let amountValue = amountInput.value.trim();
                receiptData.push({
                    ai_id: aiInput.value.trim(),
                    date: dateInput.value.trim(),
                    amount: amountValue !== "" ? parseFloat(amountValue) : 0,
                    bank: bankInput.value.trim(),
                    bank_details: bankDetailsInput.value.trim(),
                    amend_id: amendId
                });
            } else {
                console.warn(`Missing input fields in row ${index + 1}, skipping...`);
            }
        });

        const saveButton = document.getElementById("saveButton");
        if (saveButton) saveButton.disabled = true;

        fetch(`{{ url('/form5') }}/${bookingId}/save`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ receiptData })
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            alert("Successfully Updated!");
            // window.location.href = `{{ url('form5') }}/${bookingId}/${amendId}`;
        })
        .catch(error => {
            console.error("Error updating records:", error);
            alert("An error occurred while updating records. Please try again.");
        })
        .finally(() => {
            if (saveButton) saveButton.disabled = false;
        });
    }

    function viewinvoice() {
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
        window.location.href = "{{ url('invoice') }}/" + bookingId + "/" + amendId;

    }

    function generatepayment() {
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

        const paymentDetails = {
            date : document.getElementById('datePicker').value,
            amount : document.getElementById('amount').value,
            bank : document.getElementById('bank').value,
            bank_details : document.getElementById('bank_details').value,
        };
        console.log(paymentDetails);

        fetch(`{{ url('/form5') }}/${bookingId}/addPayment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                amendId : amendId,
                paymentDetails
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to add a new row');
            }
        })
        .catch(error => {
            console.error('Error fetching pickup details:', error);
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
        window.location.href = "{{ url('form4') }}/" + bookingId + "/" + amendId;

    }


</script>
