@extends('layouts.app')

@section('content')

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
                            <a href="{{ url('form5', [$bookings->booking_id, $amendId]) }}" class="hover:text-indigo-500">
                                Summary & Payment
                            </a>
                        </li>
                        <li><span class="text-gray-400">|</span></li>
                        <li>
                            <a href="{{ url('invoice', [$bookings->booking_id, $amendId]) }}" class="text-indigo-600 font-semibold">
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

            <div class="container py-4 max-w-4xl mx-auto">
                <div class="card border-0" id="printArea">
                    <div class="card-header text-black text-center rounded-top">
                        <h2 class="mb-0">
                            <strong>REDANG PELANGI RESORT TOUR & TRAVEL SDN BHD</strong> 
                            <span class="text-sm">(KKKP/PL3245) (375670-K)</span>
                        </h2>                        
                        <p class="mb-0">2A, Jalan Syed Hussin, 20100 Kuala Terengganu, Terengganu, Malaysia</p>
                        <p class="mb-0">Tel: 09-624 2158, 09-626 1189, 019-9834 158, 019-9837 1 | Fax: 09-623 5202</p>
                        <p class="mb-0">Web: <a href="http://www.redangpelangi.com" class="text-black">www.redangpelangi.com</a> | Email: <a href="mailto:reservation@redangpelangi.com" class="text-black">reservation@redangpelangi.com</a></p>
                    </div>
                    <hr class="border-1 border-black">
                    <div class="p-6 text-center">
                        <table class="w-full text-sm">
                            <tr class="">
                                <th class="p-1 text-left">Attention</th>
                                <td class="p-1 text-left">{{ $bookings->attention }}</td>
                                <th class="p-1 text-right">Date</th>
                                <td class="p-1 text-left">{{ $bookings->date }}</td>
                            </tr>
                            <tr>
                                <th class="p-1 text-left">Company</th>
                                <td class="p-1 text-left">{{ $bookings->company }}</td>
                                <th class="p-1 text-right">From</th>
                                <td class="p-1 text-left">{{ $bookings->handle_by }}</td>
                            </tr>
                            <tr class="">
                                <th class="p-1 text-left">Email</th>
                                <td class="p-1 text-left">{{ $bookings->email }}</td>
                                <th class="p-1 text-right">Booking No</th>
                                <td class="p-1 text-blue-600 text-left">{{ $bookings->booking_id }}</td>
                            </tr>
                            <tr>
                                <th class="p-1 text-left">Fax</th>
                                <td class="p-1 text-left">{{ $bookings->fax }}</td>
                                <th class="p-1 text-right">Password</th>
                                <td class="p-1 text-red-600 text-left">{{ $bookings->password }}</td>
                            </tr>
                        </table>
                        
                        <h3 class="text-xl font-bold uppercase my-6 bg-yellow-100 p-1">Proforma Invoice</h3>

                        <table class="w-full text-left text-sm">
                            <tr class="">
                                <th class="p-1">Date of Visit</th>
                                <td class="p-1">{{ $bookings->check_in }}</td>
                                <th class="p-1">To</th>
                                <td class="p-1">{{ $bookings->check_out }}</td>
                                <td class="p-1"> {{ $days }}D{{ $nights }}N</td>
                            </tr>
                            <tr>
                                <th class="p-1 ">Group Name</th>
                                <td class="p-1">{{ $bookings->group_name }}</td>
                                <th class="p-1">Mobile No</th>
                                <td class="p-1">{{ $bookings->telephone }}</td>
                            </tr>
                            {{-- <tr class="">
                                <th class="p-1 ">Pax</th>
                                <td class="p-1 " colspan="3">Adults: <span class="font-bold text-blue-600">{{ $bookings->adults }}</span>, Children: <span class="font-bold text-green-600">{{ $bookings->children }}</span>, Total: <span class="font-bold text-red-600">{{ $bookings->total }}</span></td>
                            </tr> --}}
                        </table>
                        <table class="w-full text-left border border-black border-collapse text-sm">
                            <tr class="border-b border-black bg-gray-200">
                                <th class="p-1 border-r border-black"></th>
                                <th class="p-1 border-r border-black text-right">QTY</th>
                                <th class="p-1 border-r border-black text-right">Unit Price (RM)</th>
                                <th class="p-1 text-right">Sub Total (RM)</th>
                            </tr>
                            {{-- @if($bookings->d_adult_pax)
                                <tr class="border-b border-black">
                                    <td class="p-1 border-r border-black">Adult in Double Deluxe Rooms</td>
                                    <td class="p-1 border-r border-black">{{ $bookings->d_adult_pax }}</td>
                                    <td class="p-1 border-r border-black">{{ number_format($bookings->d_adult_price, 2) }}</td>
                                    <td class="p-1">{{ number_format($bookings->d_adult_pax * $bookings->d_adult_price, 2) }}</td>
                                </tr>
                            @endif        
                            @if($bookings->d_triple_pax)
                                <tr class="border-b border-black">
                                    <td class="p-1 border-r border-black">Adult in Triple Deluxe Rooms</td>
                                    <td class="p-1 border-r border-black">{{ $bookings->d_triple_pax }}</td>
                                    <td class="p-1 border-r border-black">{{ number_format($bookings->d_triple_price, 2) }}</td>
                                    <td class="p-1">{{ number_format($bookings->d_triple_pax * $bookings->d_triple_price, 2) }}</td>
                                </tr>
                            @endif           
                            @if($bookings->d_quad_pax)
                                <tr class="border-b border-black">
                                    <td class="p-1 border-r border-black">Adult in Quad Deluxe Rooms</td>
                                    <td class="p-1 border-r border-black">{{ $bookings->d_quad_pax }}</td>
                                    <td class="p-1 border-r border-black">{{ number_format($bookings->d_quad_price, 2) }}</td>
                                    <td class="p-1">{{ number_format($bookings->d_quad_pax * $bookings->d_quad_price, 2) }}</td>
                                </tr>
                            @endif           

                            @if($bookings->d_adult_m_pax)
                                <tr class="border-b border-black">
                                    <td class="p-1 border-r border-black">Adult in Double Deluxe Rooms With Mattress</td>
                                    <td class="p-1 border-r border-black">{{ $bookings->d_adult_m_pax }}</td>
                                    <td class="p-1 border-r border-black">{{ number_format($bookings->d_adult_m_price, 2) }}</td>
                                    <td class="p-1">{{ number_format($bookings->d_adult_m_pax * $bookings->d_adult_m_price, 2) }}</td>
                                </tr>
                            @endif            --}}
                            @php
                                $roomTypes = [
                                    'd_adult' => 'Adult in Double Deluxe Rooms',
                                    't_adult' => 'Adult in Triple Deluxe Rooms',
                                    'q_adult' => 'Adult in Quad Deluxe Rooms',
                                    'd_adult_m' => 'Adult in Double Deluxe Rooms With Mattress',
                                    't_adult_m' => 'Adult in Triple Deluxe Rooms With Mattress',
                                    'q_adult_m' => 'Adult in Quad Deluxe Rooms With Mattress',

                                    'd_child' => 'Child in Double Deluxe Rooms',
                                    't_child' => 'child in Triple Deluxe Rooms',
                                    'q_child' => 'child in Quad Deluxe Rooms',
                                    'd_child_m' => 'child in Double Deluxe Rooms With Mattress',
                                    't_child_m' => 'child in Triple Deluxe Rooms With Mattress',
                                    'q_child_m' => 'child in Quad Deluxe Rooms With Mattress',

                                    'd_toddler' => 'Toddler in Double Deluxe Rooms',
                                    't_toddler' => 'Toddler in Triple Deluxe Rooms',
                                    'q_toddler' => 'Toddler in Quad Deluxe Rooms',

                                    'deluxe_d_adult' => 'Adult in Double Deluxe Rooms (Seaview)',
                                    'deluxe_t_adult' => 'Adult in Triple Deluxe Rooms (Seaview)',
                                    'deluxe_q_adult' => 'Adult in Quad Deluxe Rooms (Seaview)',
                                    'deluxe_d_adult_m' => 'Adult in Double Deluxe Rooms With Mattress (Seaview)',
                                    'deluxe_t_adult_m' => 'Adult in Triple Deluxe Rooms With Mattress (Seaview)',
                                    'deluxe_q_adult_m' => 'Adult in Quad Deluxe Rooms With Mattress (Seaview)',

                                    'deluxe_d_child' => 'Child in Double Deluxe Rooms (Seaview)',
                                    'deluxe_t_child' => 'child in Triple Deluxe Rooms (Seaview)',
                                    'deluxe_q_child' => 'child in Quad Deluxe Rooms (Seaview)',
                                    'deluxe_d_child_m' => 'child in Double Deluxe Rooms With Mattress (Seaview)',
                                    'deluxe_t_child_m' => 'child in Triple Deluxe Rooms With Mattress (Seaview)',
                                    'deluxe_q_child_m' => 'child in Quad Deluxe Rooms With Mattress (Seaview)',

                                    'deluxe_d_toddler' => 'Toddler in Double Deluxe Rooms (Seaview)',
                                    'deluxe_t_toddler' => 'Toddler in Triple Deluxe Rooms (Seaview)',
                                    'deluxe_q_toddler' => 'Toddler in Quad Deluxe Rooms (Seaview)',

                                ];
                            @endphp

                            @foreach ($roomTypes as $key => $label)
                                @php
                                    $pax = $bookings->{$key . '_pax'};
                                    $price = $bookings->{$key . '_price'};
                                @endphp

                                @if($pax)
                                    <tr class="border-b border-black">
                                        <td class="p-1 border-r border-black">{{ $label }}</td>
                                        <td class="p-1 border-r border-black text-right">{{ $pax }}</td>
                                        <td class="p-1 border-r border-black text-right">{{ number_format($price, 2) }}</td>
                                        <td class="p-1 text-right">{{ number_format($pax * $price, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            @php
                                $transports = [
                                    'pickup01' => 'Pickup',
                                    'pickup02' => 'Pickup',
                                    'pickup03' => 'Pickup',
                                    'pickup04' => 'Pickup',
                                    'dropoff01' => 'Dropoff',
                                    'dropoff02' => 'Dropoff',
                                    'dropoff03' => 'Dropoff',
                                    'dropoff04' => 'Dropoff',
                                ];
                            @endphp

                            @foreach ($transports as $key => $type)
                                @php
                                    $pax = $bookings->{$key . '_pax'};
                                    $method = $bookings->{$key . '_method'};
                                    $price = $bookings->{$key . '_price'};
                                    $total = $bookings->{$key . '_total'};
                                @endphp

                                @if($pax)
                                    <tr class="border-b border-black">
                                        <td class="p-1 border-r border-black">{{ $method }}</td>
                                        <td class="p-1 border-r border-black text-right">{{ $pax }}</td>
                                        <td class="p-1 border-r border-black text-right">{{ number_format($price, 2) }}</td>
                                        <td class="p-1 text-right">{{ number_format($total, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            @php
                                $optionals = [
                                    'optional01' => 'Optional',
                                    'optional02' => 'Optional',
                                    'optional03' => 'Optional',
                                    'optional03' => 'Optional',
                                ];
                            @endphp

                            @foreach ($optionals as $key => $type)
                                @php
                                    $pax = $bookings->{$key . '_pax'};
                                    $desc = $bookings->{$key . '_desc'};
                                    $price = $bookings->{$key . '_price'};
                                    $total = $bookings->{$key . '_total'};
                                @endphp

                                @if($pax)
                                    <tr class="border-b border-black">
                                        <td class="p-1 border-r border-black">{{ $desc }}</td>
                                        <td class="p-1 border-r border-black text-right">{{ $pax }}</td>
                                        <td class="p-1 border-r border-black text-right">{{ number_format($price, 2) }}</td>
                                        <td class="p-1 text-right">{{ number_format($total, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr class="border-b border-black">
                                <td class="p-1 border-r border-black" colspan="2"></td>
                                <th class="p-1 border-r border-black text-right">Grand Total (RM)</th>
                                <th class="p-1 text-right">{{ number_format($grand_total_with_sst, 2) }}</th>
                            </tr>
                            <tr class="border-b border-black">
                                <td class="p-1 border-r border-black" colspan="2"></td>
                                <th class="p-1 border-r border-black text-right">Deposit (RM)</th>
                                <th class="p-1 text-right">{{ number_format($bookings->deposit_amount ? $bookings->deposit_amount : 0, 2) }}</th>
                            </tr>
                            <tr class="border-b border-black">
                                <td class="p-1 border-r border-black" colspan="2"></td>
                                <th class="p-1 border-r border-black text-right">Balance (RM)</th>
                                <th class="p-1 text-right">{{ number_format(($grand_total_with_sst - $totalpay) ?? 0, 2) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <button onclick="printDiv('printArea')" class="bg-blue-500 text-white px-4 py-2 rounded text-sm text-right">Print</button>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

