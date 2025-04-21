@extends('layouts.app')

@section('content')
@php
    date_default_timezone_set('Asia/Kuala_Lumpur');
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
                <form method="post" action="{{ route('pax_report.filter') }}">
                    @csrf
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center text-sm">
                            <label for="fromdate" class="mr-2 text-sm">Check In Date</label>
                            <input type="date" name="fromdate" id="fromdate" class="form-input border rounded p-2 text-sm" required value="{{ old('fromdate', \Carbon\Carbon::parse($formatted_fdate)->format('Y-m-d')) }}">
                        </div>
                        
                        <div>
                            <select name="duration" class="form-select border rounded p-2 text-sm">
                                <option value="">Select Duration</option>
                                <option value="7_days" {{ $duration == '7_days' ? 'selected' : '' }}>7 Days</option>
                                <option value="1_month" {{ $duration == '1_month' ? 'selected' : '' }}>1 Month</option>
                            </select>
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
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Pelangi</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Check In</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">In House</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Check Out</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Breakfast</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Lunch/Dinner</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Rooms Check In</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Rooms In House</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Rooms Check Out</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px]">Rooms Used</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($results && count($results) > 0)
                                                @foreach ($results as $group)
                                                @php 
                                                    $group = collect($group);
                                                    $row = $group;
                                                @endphp
                                                <tr class="odd:bg-white even:bg-gray-50">
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[50px] print:w-[20px]">{{ $loop->iteration }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                       {{ $row['day'] }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row['check_in_count'] }}({{ $row['check_in_count_child'] }})
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row['in_house_count'] }}({{ $row['in_house_count_child'] }})
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row['check_out_count'] }}({{ $row['check_out_count_child'] }})
                                                    </td>

                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row['in_house_count'] + $row['check_out_count'] }}({{ $row['in_house_count_child'] + $row['check_out_count_child'] }})
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row['in_house_count'] + $row['check_in_count'] }}({{ $row['in_house_count_child'] + $row['check_in_count_child'] }})
                                                    </td>
                                                        
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row['room_check_in_count'] }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                        {{ $row['room_in_house_count'] }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[60px]">
                                                        {{ $row['room_check_out_count'] }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px] w-[85px] print:w-[50px]">
                                                       
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="10" class="border border-gray-300 p-4 text-center">
                                                        No data available
                                                    </td>
                                                </tr>
                                            @endif
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