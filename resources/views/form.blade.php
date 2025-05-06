@extends('layouts.app')

@section('content')
<style>
    .form-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin: 20px 0;
    }

    .form-section {
        flex: 1; /* Allow flexible width */
        min-width: 280px; /* Ensures it doesn’t get too small */
    }

    .first-section {
        flex: 3; /* Takes more space */
    }

    .second-section {
        flex: 2; /* Takes less space */
    }

    .third-section {
        flex: 1.5; /* Smallest section */
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .form-container {
            flex-direction: column;
        }

        .form-section {
            width: 100%;
        }
    }
</style>
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

    window.Laravel = { csrfToken: "{{ csrf_token() }}" };
</script>
@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    $booking_id = request()->query('booking');
    $amend_id = request()->query('amend');

    $booking = DB::table('bookings')->where('booking_id', $booking_id)->first();
    $generatedPassword = null;
    if ($booking_id) {
        $generatedPassword = DB::table('namelist.user')->where('booking_ID', $booking_id)->value('password');
    } else {
        $generatedPassword = Str::random(10);
    }

@endphp
<div class="max-w-full mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-center flex-wrap">
                @if ($booking_id)
                    <!-- Navigation -->
                    <nav class="mb-4">
                        <!-- Hamburger Button (Visible on Mobile) -->
                        <input type="checkbox" id="menu-toggle" class="peer hidden">
                        <label for="menu-toggle" class="md:hidden block text-gray-600 dark:text-gray-300 cursor-pointer">
                            ☰
                        </label>

                        <!-- Breadcrumb Menu (Hidden on Small Screens, Visible on Desktop) -->
                        <ol class="hidden md:flex flex-wrap items-center space-x-3 text-sm text-gray-600 dark:text-gray-300">
                            <li>
                                <a id="page1" href="{{ url('form') }}?booking={{ $booking_id }}" class="text-indigo-600 font-semibold">
                                    Basic Information
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="page2" href="{{ url('form2', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="hover:text-indigo-500">
                                    Room Details
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="page3" href="{{ url('form3', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="hover:text-indigo-500">
                                    Land Transfer & Optional
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="page4" href="{{ url('form4', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="hover:text-indigo-500">
                                    Remarks
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="page5" href="{{ url('form5', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="hover:text-indigo-500">
                                    Summary & Payment
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="invoice" href="{{ url('invoice', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="hover:text-indigo-500">
                                    Invoice
                                </a>
                            </li>
                        </ol>

                        <!-- Mobile Dropdown (Appears when Checkbox is Checked) -->
                        <ol class="hidden peer-checked:block md:hidden mt-2 space-y-2 text-gray-600 dark:text-gray-300 text-sm">
                            <li>
                                <a id="page1" href="{{ url('form') }}?booking={{ $booking_id }}" class="block p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                    Basic Information
                                </a>
                            </li>
                            <li>
                                <a id="page2" href="{{ url('form2', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="block p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                    Room Details
                                </a>
                            </li>
                            <li>
                                <a id="page3" href="{{ url('form3', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="block p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                    Land Transfer & Optional
                                </a>
                            </li>
                            <li>
                                <a id="page4" href="{{ url('form4', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="block p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                    Remarks
                                </a>
                            </li>
                            <li>
                                <a id="page5" href="{{ url('form5', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="block p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                    Summary & Payment
                                </a>
                            </li>
                            <li>
                                <a id="invoice" href="{{ url('invoice', ['booking_id' => $booking_id, 'amend_id' => $amend_id]) }}" class="block p-2 bg-gray-100 dark:bg-gray-700 rounded-md">
                                    Invoice
                                </a>
                            </li>
                        </ol>
                    </nav>

                @else
                    <!-- Navigation -->
                    <nav class="mb-4">
                        <!-- Hamburger Button (Mobile Only) -->
                        <input type="checkbox" id="menu-toggle" class="peer hidden">
                        <label for="menu-toggle" class="md:hidden block text-gray-600 dark:text-gray-300 cursor-pointer">
                            ☰
                        </label>

                        <!-- Breadcrumb Menu (Desktop) -->
                        <ol class="hidden md:flex flex-wrap items-center space-x-3 text-sm text-gray-600 dark:text-gray-300">
                            <li>
                                <a id="page1" href="{{ url('form') }}?booking={{ $booking_id }}" class="text-indigo-600 font-semibold">
                                    Basic Information
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="page2" href="" class="hover:text-indigo-500">
                                    Room Details
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="page3" href="" class="hover:text-indigo-500">
                                    Land Transfer & Optional
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="page4" href="" class="hover:text-indigo-500">
                                    Remarks
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="page5" href="" class="hover:text-indigo-500">
                                    Summary & Payment
                                </a>
                            </li>
                            <li><span class="text-gray-400">|</span></li>
                            <li>
                                <a id="invoice" href="" class="hover:text-indigo-500">
                                    Invoice
                                </a>
                            </li>
                        </ol>

                        <!-- Mobile Dropdown Menu (Appears when checked) -->
                        <ol class="hidden peer-checked:block md:hidden mt-2 space-y-2 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 p-3 rounded-md shadow-md text-sm">
                            <li>
                                <a id="page1" href="{{ url('form') }}?booking={{ $booking_id }}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Basic Information
                                </a>
                            </li>
                            <li>
                                <a id="page2" href="" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Room Details
                                </a>
                            </li>
                            <li>
                                <a id="page3" href="" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Land Transfer & Optional
                                </a>
                            </li>
                            <li>
                                <a id="page4" href="" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Remarks
                                </a>
                            </li>
                            <li>
                                <a id="page5" href="" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Summary & Payment
                                </a>
                            </li>
                            <li>
                                <a id="invoice" href="" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Invoice
                                </a>
                            </li>
                        </ol>
                    </nav>


                @endif
        
                <div id="booking-container" class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                </div>
            </div>
                
            <div class="flex flex-wrap sm:flex-nowrap justify-end items-center gap-2 p-4 bg-white dark:bg-gray-800 rounded-lg">
                <!-- Amend Button -->
                <button id="amendButton" onclick="amendBooking()" 
                    class="bg-indigo-600 text-sm text-white px-3 py-2 rounded-lg shadow-md 
                    hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    ✏️<span class="hidden sm:inline"> Amend</span> 
                </button>
            
                <div class="relative sm:w-auto">
                    <select name="amend" id="amend" 
                        class="w-20 sm:w-32 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                        dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 appearance-none">
                        <option value="">Amendment</option>
                        <option value=""></option>
                    </select>
                </div>
            
                <!-- Booking ID Input -->
                <input type="text" name="booking_id" id="booking_id" placeholder="Booking ID" 
                    class="w-20 sm:w-32 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 
                    dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 placeholder-gray-400">
            
                <!-- Search Button -->
                <button id="searchButton" onclick="searchBookingID()" 
                    class="bg-green-600 text-sm text-white px-3 py-2 rounded-lg shadow-md 
                    hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-500">
                    🔍 <span class="hidden sm:inline"> Search</span>
                </button>

                <button id="clearBooking" onclick="clearBooking()" 
                    aria-label="Clear Booking"
                    class="bg-red-600 text-sm text-white px-3 py-2 rounded-lg shadow-md 
                        hover:bg-red-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-500">
                    🔄 <span class="hidden sm:inline">Clear</span>
                </button>
            </div>
            {{-- <form method="POST" action="{{ route('form.submit') }}" id="form" onsubmit="handleFormSubmit(event)"> --}}
            @if (session('success'))
                <div class="p-4 mb-4 text-xs text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            <form method="POST" action="{{ route('form.submit') }}">
                 @csrf
                <div class="form-container">

                    <div class="form-section first-section space-y-4">
                        <input type="hidden" name="bookingid" id="bookingid" value="">
                        <input type="hidden" name="amendid" id="amendid" value="">
                        
                        <div class="flex items-center space-x-4">
                            <label for="name" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Name</label>
                            <input type="text" name="name" id="name" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label for="company" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Company</label>
                            <input type="text" name="company" id="company" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label for="address" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Address</label>
                            <input type="text" name="address" id="address" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label for="gstid" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">GST ID</label>
                            <input type="text" name="gstid" id="gstid" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label for="telephone" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Telephone</label>
                            <input type="text" name="telephone" id="telephone" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label for="fax" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Fax</label>
                            <input type="text" name="fax" id="fax" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label for="email" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Email</label>
                            <input type="text" name="email" id="email" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label for="contactname" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Contact Name</label>
                            <input type="text" name="contactname" id="contactname" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label for="contactno" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Contact Number</label>
                            <input type="text" name="contactno" id="contactno" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700">
                        </div>
                    </div>
                    

                    <div class="form-section second-section space-y-4">
                        <div class="flex items-center space-x-4">
                            <label for="date" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Date</label>
                            <div class="w-full md:w-2/3">
                                <input type="text" name="date" id="date" class="block w-full px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700" value="<?=date('d/m/Y');?>" readonly>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <label for="handleby" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">PIC</label>
                            <div class="w-full md:w-2/3">
                                <input type="text" name="handleby" id="handleby" class="block w-full px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <label for="lead" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Leads</label>
                            <div class="w-full md:w-2/3">
                                <select name="lead" id="lead" class="block w-full px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700">
                                    <option value="">-- Select Leads --</option>
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" {{ isset($booking_data['lead']) && $lead->id == $booking_data['lead'] ? 'selected' : '' }}>
                                            {{ $lead->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                        <div class="flex items-center space-x-4">
                            <label for="cancel" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Cancelled</label>
                            <div class="w-full md:w-2/3">
                                <select name="cancel" id="cancel" class="block w-full px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700">
                                    <option value="0" {{ old('cancel') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('cancel') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="flex items-center space-x-4">
                            <label for="password" class="text-xs font-medium text-gray-700 dark:text-gray-300 w-20">Password</label>
                            <div class="w-full md:w-2/3">
                                <input type="text" name="password" id="password" class="block w-full px-3 py-1.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700" value="{{ $generatedPassword }}">
                            </div>
                        </div>
                    </div>
                    @if ( $booking_id )
                        <div class="form-section third-section">
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
                                                    {{ number_format($booking->package_total, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                                <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                    Land Transfer
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                    {{ number_format($booking->landtransfer_total, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                                <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                    Optional Arrangement
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                    {{ number_format($booking->optional_total, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                            {{-- <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                                <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                    Optional Arrangement (RM) SST Free
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                    {{ number_format($total_optional_no_sst, 2, '.', ',') }}
                                                </td>
                                            </tr> --}}
                                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                                <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                    <strong>Total (RM)</strong>
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                    <strong>{{ number_format($booking->package_total + $booking->landtransfer_total + $booking->optional_total, 2, '.', ',') }}</strong>
                                                </td>
                                            </tr>
    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
    
                        </div>
                    @else
                        <div id="summaryContainer"></div>
                    @endif
                    
                </div>
                <br/>
                <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 px-4 py-3 flex justify-end space-x-4 z-50">
                    <button type="submit" id="saveForm" name="saveForm" class="px-6 py-3 bg-green-600 text-xs rounded-md text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Save
                    </button>

                    <button type="submit" id="saveNext" name="saveNext" class="ml-2 px-6 py-3 bg-indigo-600 text-xs rounded-md text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Save & Next
                    </button>
                </div>
            </form>
            {{-- <div id="confirmationModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Confirmation</h2>
                    <p class="text-gray-700 dark:text-gray-300 mt-4">Your form has been submitted successfully.</p>
                    <div class="mt-4 flex justify-end">
                        <button onclick="closeModal()" class="px-3 py-1.5 bg-gray-600 text-black rounded-md">Close</button>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>

@endsection

<script>

    const bookingId = new URL(window.location.href).searchParams.get('booking');

    if (bookingId) {
        // document.getElementById('formButton').textContent = 'Saved Changes';

        fetchBookingData(bookingId);
    }

    function clearBooking() {
        window.location.href = "{{ url('form') }}";
    }

    function searchBookingID() {
        var bookingId = document.getElementById('booking_id').value;
    
        if (bookingId) {

            const page2 = document.getElementById('page2');
            page2.href = `form2/${bookingId}/0`;
            const page3 = document.getElementById('page3');
            page3.href = `form3/${bookingId}/0`;
            const page4 = document.getElementById('page4');
            page4.href = `form4/${bookingId}0`;
            const page5 = document.getElementById('page5');
            page5.href = `form5/${bookingId}/0`;
            const invoice = document.getElementById('invoice');
            invoice.href = `invoice/${bookingId}/0`;

            fetchBookingData(bookingId, 0);

            document.getElementById('formButton').textContent = 'Saved Changes';
        } else {
            alert("Please enter a Booking ID.");
        }
    };

    function fetchBookingData(bookingId, amend) {
        if (amend == 0) {
            var amendId = 0;
        } else {
            var amendId = "{{ $amend_id }}";
        }
        amendID = amendId ? parseInt(amendId, 10) : 0;
        // Send an AJAX request to the server
        fetch('form/' + bookingId + '/getBookingData/' + amendID)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var amendBookingData = data.amendBooking;
                    console.log(amendBookingData);
                    populateAmendDropdown(amendBookingData, data.booking);
                    // Update form fields with the received data
                    fillFormFields(data.booking, data.password, amendID);
                } else {
                    alert('Booking not found.');
                }
            })
            .catch(error => {
                console.error('Error fetching booking data:', error);
            });

    }
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    function populateAmendDropdown(amendBookingData, booking) {
        const amendSelect = document.getElementById('amend');
        const amendValueFromURL = getQueryParam('amend'); // Get 'amend' value from URL
        
        // Clear existing options except the first one
        amendSelect.innerHTML = `<option value="0">${booking.booking_id}-0</option>`;

        let amendExists = false; // Track if the amend value exists

        // Loop through the data and create option elements
        amendBookingData.forEach(amendment => {
            const option = document.createElement('option');
            option.value = amendment.amend_id; // Set value
            option.textContent = `${amendment.booking_id}-${amendment.amend_id}`; // Set visible text
            amendSelect.appendChild(option);

            // Check if URL amend value exists in the dropdown
            if (amendment.amend_id === amendValueFromURL) {
                amendExists = true;
            }
        });

        // If the amend value exists in the dropdown, set it
        if (amendExists) {
            amendSelect.value = amendValueFromURL;
        }

        // Handle selection change
        amendSelect.onchange = function () {
            const selectedValue = this.value; // Get selected value
            handleAmendmentSelection(selectedValue, booking.booking_id);
        };
    }    
    function handleAmendmentSelection(amendID, bookingId) {

        if (bookingId) {
            bookingId = bookingId;
        } else {
            var bookingId = "{{ $booking_id }}";
        }
        if (bookingId) {
            // Send an AJAX request to the server
            fetch(`form/${bookingId}/getBookingAmendData?amendID=${amendID}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const page2 = document.getElementById('page2');
                    page2.href = `form2/${bookingId}/${amendID}`;
                    const page3 = document.getElementById('page3');
                    page3.href = `form3/${bookingId}/${amendID}`;
                    const page4 = document.getElementById('page4');
                    page4.href = `form4/${bookingId}/${amendID}`;
                    const page5 = document.getElementById('page5');
                    page5.href = `form5/${bookingId}/${amendID}`;

                    var amendBookingData = data.amendBooking;
                    populateAmendDropdown(amendBookingData, data.booking);
                    // Update form fields with the received data
                    fillFormFields(data.booking, data.password, amendID);
                } else {
                    alert('Booking not found.');
                }
            })
            .catch(error => {
                console.error('Error fetching booking data:', error);
            });
        }
    }
    
    function fillFormFields(booking, password, amendID) {
        // Update the form with the fetched data
        document.getElementById('bookingid').value = booking.booking_id;
        document.getElementById('name').value = booking.attention;
        document.getElementById('company').value = booking.company;
        document.getElementById('address').value = booking.address;
        document.getElementById('telephone').value = booking.telephone;
        document.getElementById('fax').value = booking.fax;
        document.getElementById('email').value = booking.email;
        document.getElementById('contactname').value = booking.group_name;
        document.getElementById('contactno').value = booking.group_contact;
        document.getElementById('date').value = booking.date;
        document.getElementById('handleby').value = booking.handle_by;
        document.getElementById('lead').value = booking.leads;
        document.getElementById('cancel').value = booking.cancel;
        document.getElementById('password').value = password;
        document.getElementById('amend').value = amendID;
        document.getElementById('amendid').value = amendID;
        document.getElementById('saveForm').value = 'saveForm';
        document.getElementById('saveNext').value = 'saveNext';

        // Select the container div
        const bookingContainer = document.getElementById('booking-container');
        // const navigatianContainer = document.getElementById('navigation-container');
        const summaryContainer = document.getElementById('summaryContainer') ;

        if (!bookingContainer) {
            console.error('Booking container not found.');
            return;
        }
        // Insert the booking data into the div dynamically
        if (amendID) {
            if (amendID == 0) {
                bookingContainer.innerHTML = `
                    <div class="text-lg font-semibold text-gray-900 dark:text-white text-right">#${booking.booking_id}-${booking.amend_id}</div>
                    <p class=" text-right">${booking.attention} <span class="text-gray-500">(${booking.company})</span></p>
                    <p class=" text-right">
                        <strong>Check In:</strong> <span class="text-black-500">${booking.check_in}</span> |
                        <strong>Check Out:</strong> <span class="text-black-500">${booking.check_out}</span>
                    </p>
                    <p class=" text-right"><strong>PIC:</strong> ${booking.handle_by}</p>
                    ${booking.days && booking.nights ? `
                        <p class=" text-right">
                            <strong>Days:</strong> <span class="text-black-500">${booking.days}</span> |
                            <strong>Night:</strong> <span class="text-black-500">${booking.nights}</span>
                        </p>
                    ` : ''}
                `;
            } else {
                bookingContainer.innerHTML = `
                    <div class="text-lg font-semibold text-gray-900 dark:text-white text-right">#${booking.booking_id}-${amendID}</div>
                    <p class=" text-right">${booking.attention} <span class="text-gray-500">(${booking.company})</span></p>
                    <p class=" text-right">
                        <strong>Check In:</strong> <span class="text-black-500">${booking.check_in}</span> |
                        <strong>Check Out:</strong> <span class="text-black-500">${booking.check_out}</span>
                    </p>
                    <p class=" text-right"><strong>PIC:</strong> ${booking.handle_by}</p>
                    ${booking.days && booking.nights ? `
                        <p class=" text-right">
                            <strong>Days:</strong> <span class="text-black-500">${booking.days}</span> |
                            <strong>Night:</strong> <span class="text-black-500">${booking.nights}</span>
                        </p>
                    ` : ''}
                `;
            }
        } else {
            bookingContainer.innerHTML = `
                <div class="text-lg font-semibold text-gray-900 dark:text-white text-right">#${booking.booking_id}</div>
                <p class="text-right">${booking.attention} <span class="text-gray-500">(${booking.company})</span></p>
                <p class=" text-right">
                    <strong>Check In:</strong> <span class="text-black-500">${booking.check_in}</span> |
                    <strong>Check Out:</strong> <span class="text-black-500">${booking.check_out}</span>
                </p>
                <p class=" text-right"><strong>PIC:</strong> ${booking.handle_by}</p>
                ${booking.days && booking.nights ? `
                    <p class=" text-right">
                        <strong>Days:</strong> <span class="text-black-500">${booking.days}</span> |
                        <strong>Night:</strong> <span class="text-black-500">${booking.nights}</span>
                    </p>
                ` : ''}
            `;
        }

        const packageTotal = Number(booking.package_total) || 0;
        const landTransferTotal = Number(booking.landtransfer_total) || 0;
        const optionalTotal = Number(booking.optional_total) || 0;

        let optional01_total = 0;
        let optional02_total = 0;
        let optional03total = 0;
        let optional04_total = 0;
        let optional05_total = 0;

        let optional01_total_no_sst = 0;
        let optional02_total_no_sst = 0;
        let optional03_total_no_sst = 0;
        let optional04_total_no_sst = 0;
        let optional05_total_no_sst = 0;

        if (booking.optional01_GST == 1) {
            optional01_total = booking.optional01_total;
        } else {
            optional01_total_no_sst = booking.optional01_total;
        }

        if (booking.optional02_GST == 1) {
            optional02_total = booking.optional02_total;
        } else {
            optional02_total_no_sst = booking.optional02_total;
        }

        if (booking.optional03_GST == 1) {
            optional03_total = booking.optional03_total;
        } else {
            optional03_total_no_sst = booking.optional03_total;
        }

        if (booking.optional04_GST == 1) {
            optional04_total = booking.optional04_total;
        } else {
            optional04_total_no_sst = booking.optional04_total;
        }

        if (booking.optional05_GST == 1) {
            optional05_total = booking.optional05_total;
        } else {
            optional05_total_no_sst = booking.optional05_total;
        }

        // const total_optional = optional01_total + optional02_total + optional03_total + optional04_total + optional05_total;
        const total_optional_no_sst = optional01_total_no_sst + optional02_total_no_sst + optional03_total_no_sst + optional04_total_no_sst + optional05_total_no_sst;

        const totalAmount = packageTotal + landTransferTotal + optionalTotal;

        var bookingId = "{{ $booking_id }}";

        if (!bookingId) {
            summaryContainer.innerHTML = `
            <div class="form-section third-section">
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
                                        ${booking.package_total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                    </td>
                                </tr>
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                    <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                        Land Transfer
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                        ${booking.landtransfer_total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                    </td>
                                </tr>
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                    <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                        Optional Arrangement
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                        ${booking.optional_total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                    </td>
                                </tr>
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 text-xs">
                                    <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                        <strong>Total (RM)</strong>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                        <strong>
                                            ${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            `;
        }

        // navigatianContainer.innerHTML = `
        //     <nav class="mb-4">
        //         <!-- Mobile Hamburger Button -->
        //         <input type="checkbox" id="menu-toggle" class="peer hidden">
        //         <label for="menu-toggle" class="md:hidden block text-gray-600 dark:text-gray-300 cursor-pointer p-2">
        //             ☰ Menu
        //         </label>

        //         <!-- Desktop Breadcrumb Menu -->
        //         <ol class="hidden md:flex flex-wrap items-center space-x-3 text-sm text-gray-600 dark:text-gray-300">
        //             <li>
        //                 <a href="form?booking=${booking.booking_id}" class="text-indigo-600 font-semibold">
        //                     Basic Information
        //                 </a>
        //             </li>
        //             <li><span class="text-gray-400">|</span></li>
        //             <li><a href="form2/${booking.booking_id}" class="hover:text-indigo-500">Room Details</a></li>
        //             <li><span class="text-gray-400">|</span></li>
        //             <li><a href="form3/${booking.booking_id}" class="hover:text-indigo-500">Land Transfer & Optional</a></li>
        //             <li><span class="text-gray-400">|</span></li>
        //             <li><a href="form4/${booking.booking_id}" class="hover:text-indigo-500">Remarks</a></li>
        //             <li><span class="text-gray-400">|</span></li>
        //             <li><a href="form5/${booking.booking_id}" class="hover:text-indigo-500">Summary & Payment</a></li>
        //             <li><span class="text-gray-400">|</span></li>
        //             <li><a href="invoice/${booking.booking_id}" class="hover:text-indigo-500">Invoice</a></li>
        //         </ol>

        //         <!-- Mobile Dropdown Menu (Hidden by default) -->
        //         <ol class="hidden peer-checked:block md:hidden mt-2 space-y-2 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 p-3 rounded-md shadow-md">
        //             <li>
        //                 <a href="form?booking=${booking.booking_id}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
        //                     Basic Information
        //                 </a>
        //             </li>
        //             <li>
        //                 <a href="form2/${booking.booking_id}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
        //                     Room Details
        //                 </a>
        //             </li>
        //             <li>
        //                 <a href="form3/${booking.booking_id}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
        //                     Land Transfer & Optional
        //                 </a>
        //             </li>
        //             <li>
        //                 <a href="form4/${booking.booking_id}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
        //                     Remarks
        //                 </a>
        //             </li>
        //             <li>
        //                 <a href="form5/${booking.booking_id}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
        //                     Summary & Payment
        //                 </a>
        //             </li>
        //             <li>
        //                 <a href="invoice/${booking.booking_id}" class="block p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
        //                     Invoice
        //                 </a>
        //             </li>
        //         </ol>
        //     </nav>
        // `;

    }

    function amendBooking() {
        let bookingId = new URL(window.location.href).searchParams.get('booking'); 
        const amendSelect = document.getElementById('amend');
        const amendid = amendSelect.value;

        if (!bookingId) {
            bookingId = document.getElementById('booking_id')?.value;
        }

        if (!bookingId) {
            alert("Booking ID is required.");
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`{{ url('/form') }}/${bookingId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ type: 'amend', amendid: amendid })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Booking amended successfully!");
                window.location.href = "{{ url('form') }}?booking=" + bookingId;
            } else {
                alert("Failed to amend booking. Please try again.");
                console.error("Error:", data);
            }
        })
        .catch(error => {
            alert("This booking amendmend already canceled, Please choose another booking amendmend.");
            console.error("Error updating booking:", error);
        });
    }
</script>
