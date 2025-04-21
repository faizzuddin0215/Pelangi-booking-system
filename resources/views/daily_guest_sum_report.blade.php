@extends('layouts.app')

@section('content')
@php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    use Illuminate\Support\Carbon;
@endphp
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

    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

</script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printArea, #printArea * {
            visibility: visible;
        }
        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        /* Reduce the overall text size */
        #printArea {
            font-size: 8px !important; /* Adjust as needed */
        }

        /* Reduce table font size */
        #printArea table {
            font-size: 7px !important; /* Smaller text in table */
            border-collapse: collapse; /* Remove extra spacing */
        }

        /* Reduce padding inside table cells */
        #printArea th, #printArea td {
            padding: 2px 4px !important; /* Less padding inside cells */
            border: 1px solid black !important; /* Ensure visible borders */
        }

        /* Minimize column width */
        #printArea th, #printArea td {
            width: auto !important; /* Shrink columns to fit content */
            white-space: nowrap; /* Prevent wrapping */
        }
        @page {
        size: A4 portrait; /* Or use 'letter' */
        margin: 5mm; /* Reduce margin to fit more content */
        }
    }   

</style>

<div class="max-w-full mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                <form method="post" action="{{ route('daily_guest_sum_report.filter') }}">
                    @csrf
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center text-sm">
                            <label for="fromdate" class="mr-2 text-sm">Check In Date</label>
                            <input type="date" name="fromdate" id="fromdate" class="form-input border rounded p-2 text-sm" required value="{{ old('fromdate', \Carbon\Carbon::parse($formatted_fdate)->format('Y-m-d')) }}">
                        </div>
                        
                        <div class="w-full sm:w-auto">
                            <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full sm:w-auto text-sm">Submit</button>
                        </div>
                        <button onclick="printDiv('printArea')" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Print</button>

                    </div>
                </form>
                <div class="flex flex-col space-y-4">
                    <div class="card bg-white shadow rounded-lg">
                        <div class="p-4">
                            <div id="printArea" class="text-xs print:text-[6px]">
                                <div class="text-xl">Pax Report ({{$formatted_fdate}})</div>
                                <div class="overflow-x-auto text-xs print:text-[12px]">
                                    <table class="table-auto w-full border-collapse border border-gray-300">
                                        <thead>
                                            <tr class="bg-gray-100 text-left">
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[20px]">#</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Check In</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Check Out</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Days</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Contact Name (Company)</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Pax</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Rooms</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Room Allocated</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Remarks</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">ID</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Code</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($checkIn && count($checkIn) > 0)
                                                <tr>
                                                    <td colspan="12" class="border border-gray-300 p-4 text-center">
                                                        Check In Guests
                                                    </td>
                                                </tr>
                                                @foreach ($checkIn as $group)
                                                @php $row = $group->first(); @endphp
                                                <tr class="odd:bg-white even:bg-gray-50">
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[50px] print:w-[20px]">{{ $loop->iteration }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row->check_in }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row->check_out }}
                                                    </td>
                                                    @if ($row->nights)
                                                        <td class="border border-gray-300 p-2 print:p-[2px]">
                                                            {{ $row->nights + 1 }}
                                                        </td> 
                                                    @else
                                                        <td class="border border-gray-300 p-2 print:p-[2px]">
                                                            0
                                                        </td>
                                                    @endif

                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {{$row->group_name}} ({{ $row->company }})
                                                    </td>

                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[35px]">
                                                        {{ $row->pax_adult ?? '_' }} {{ $row->pax_child ?? '_' }} {{ $row->pax_toddler ?? '_' }} {{ $row->pax_pax_foc_tl ?? '_' }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[100px] print:w-[60px]">
                                                        @php
                                                            $roomTypes = ['Q', 'T', 'D', 'DL'];
                                                            $deluxeRoomTypes = ['Deluxe_Q', 'Deluxe_T', 'Deluxe_D'];

                                                            $standardCounts = array_map(fn($type) => $row->room_type_count[$type] ?? '_', $roomTypes);
                                                            $deluxeCounts = array_map(fn($type) => $row->room_type_count[$type] ?? '_', $deluxeRoomTypes);
                                                        @endphp
                                                        {{ implode(' ', $standardCounts) }} @ {{ implode(' ', $deluxeCounts) }}
                                                        {{-- @foreach($row->room_type_count as $roomType => $count)
                                                            {{ $count }}
                                                        @endforeach --}}
                                                    </td>
                                                    
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {{ implode(' ', $group->pluck('rooms')->filter()->toArray()) }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">{{ $row->internal_remarks }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        <a href="{{ url('form') }}?booking={{ $row->booking_id }}" 
                                                            class="text-blue-500 print:text-black">
                                                            {{ $row->booking_id }}
                                                        </a>
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[30px]">
                                                        NL ({{ $row->pax_adult + $row->pax_child + $row->pax_toddler }}) {{ $row->optional_code }} {{ $row->optional_code2 }} {{ $row->optional_code3 }} {{ $row->optional_code4 }} {{ $row->optional_code5 }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[30px]">
                                                        {{ $row->balance_amount }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12" class="border border-gray-300 p-4 text-center">
                                                        No data available
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($inHouse && count($inHouse) > 0)
                                                <tr>
                                                    <td colspan="12" class="border border-gray-300 p-4 text-center">
                                                        In-house Guests
                                                    </td>
                                                </tr>
                                                @foreach ($inHouse as $group)
                                                @php $row = $group->first(); @endphp
                                                <tr class="odd:bg-white even:bg-gray-50">
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[50px] print:w-[20px]">{{ $loop->iteration }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row->check_in }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row->check_out }}
                                                    </td>
                                                    @if ($row->nights)
                                                        <td class="border border-gray-300 p-2 print:p-[2px]">
                                                            {{ $row->nights + 1 }}
                                                        </td> 
                                                    @else
                                                        <td class="border border-gray-300 p-2 print:p-[2px]">
                                                            0
                                                        </td>
                                                    @endif

                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {{$row->group_name}} ({{ $row->company }})
                                                    </td>

                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[35px]">
                                                        {{ $row->pax_adult ?? '_' }} {{ $row->pax_child ?? '_' }} {{ $row->pax_toddler ?? '_' }} {{ $row->pax_pax_foc_tl ?? '_' }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[100px] print:w-[60px]">
                                                        @php
                                                            $roomTypes = ['Q', 'T', 'D', 'DL'];
                                                            $deluxeRoomTypes = ['Deluxe_Q', 'Deluxe_T', 'Deluxe_D'];

                                                            $standardCounts = array_map(fn($type) => $row->room_type_count[$type] ?? '_', $roomTypes);
                                                            $deluxeCounts = array_map(fn($type) => $row->room_type_count[$type] ?? '_', $deluxeRoomTypes);
                                                        @endphp
                                                        {{ implode(' ', $standardCounts) }} @ {{ implode(' ', $deluxeCounts) }}
                                                        {{-- @foreach($row->room_type_count as $roomType => $count)
                                                            {{ $count }}
                                                        @endforeach --}}
                                                    </td>
                                                    
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {{ implode(' ', $group->pluck('rooms')->filter()->toArray()) }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">{{ $row->internal_remarks }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        <a href="{{ url('form') }}?booking={{ $row->booking_id }}" 
                                                            class="text-blue-500 print:text-black">
                                                            {{ $row->booking_id }}
                                                        </a>
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[30px]">
                                                        NL ({{ $row->pax_adult + $row->pax_child + $row->pax_toddler }}) {{ $row->optional_code }} {{ $row->optional_code2 }} {{ $row->optional_code3 }} {{ $row->optional_code4 }} {{ $row->optional_code5 }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[30px]">
                                                        {{ $row->balance_amount }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12" class="border border-gray-300 p-4 text-center">
                                                        No data available
                                                    </td>
                                                </tr>
                                            @endif
                                            
                                            @if ($checkOut && count($checkOut) > 0)
                                                <tr>
                                                    <td colspan="12" class="border border-gray-300 p-4 text-center">
                                                        Check Out Guests
                                                    </td>
                                                </tr>
                                                @foreach ($checkOut as $group)
                                                @php $row = $group->first(); @endphp
                                                <tr class="odd:bg-white even:bg-gray-50">
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[50px] print:w-[20px]">{{ $loop->iteration }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row->check_in }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row->check_out }}
                                                    </td>
                                                    @if ($row->nights)
                                                        <td class="border border-gray-300 p-2 print:p-[2px]">
                                                            {{ $row->nights + 1 }}
                                                        </td> 
                                                    @else
                                                        <td class="border border-gray-300 p-2 print:p-[2px]">
                                                            0
                                                        </td>
                                                    @endif

                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {{$row->group_name}} ({{ $row->company }})
                                                    </td>

                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[35px]">
                                                        {{ $row->pax_adult ?? '_' }} {{ $row->pax_child ?? '_' }} {{ $row->pax_toddler ?? '_' }} {{ $row->pax_pax_foc_tl ?? '_' }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[100px] print:w-[60px]">
                                                        @php
                                                            $roomTypes = ['Q', 'T', 'D', 'DL'];
                                                            $deluxeRoomTypes = ['Deluxe_Q', 'Deluxe_T', 'Deluxe_D'];

                                                            $standardCounts = array_map(fn($type) => $row->room_type_count[$type] ?? '_', $roomTypes);
                                                            $deluxeCounts = array_map(fn($type) => $row->room_type_count[$type] ?? '_', $deluxeRoomTypes);
                                                        @endphp
                                                        {{ implode(' ', $standardCounts) }} @ {{ implode(' ', $deluxeCounts) }}
                                                        {{-- @foreach($row->room_type_count as $roomType => $count)
                                                            {{ $count }}
                                                        @endforeach --}}
                                                    </td>
                                                    
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {{ implode(' ', $group->pluck('rooms')->filter()->toArray()) }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">{{ $row->internal_remarks }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        <a href="{{ url('form') }}?booking={{ $row->booking_id }}" 
                                                            class="text-blue-500 print:text-black">
                                                            {{ $row->booking_id }}
                                                        </a>
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[30px]">
                                                        NL ({{ $row->pax_adult + $row->pax_child + $row->pax_toddler }}) {{ $row->optional_code }} {{ $row->optional_code2 }} {{ $row->optional_code3 }} {{ $row->optional_code4 }} {{ $row->optional_code5 }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[60px] print:w-[30px]">
                                                        {{ $row->balance_amount }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12" class="border border-gray-300 p-4 text-center">
                                                        No data available
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        </tbody>
                                        <tbody>
                                            <td colspan="5">Generated: <?=date('d/m/Y g:i:s');?></td>
                                        </tbody>                            
                                    </table>
                                    {{-- <div class="mt-4">
                                        {{ $bookings->links() }}
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection