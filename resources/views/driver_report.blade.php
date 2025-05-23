
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

    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<style>
    /* @media print {
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
        
        #printArea {
            font-size: 8px !important; 
        }

        
        #printArea table {
            font-size: 7px !important; 
            border-collapse: collapse; 
        }

        
        #printArea th, #printArea td {
            padding: 2px 4px !important; 
            border: 1px solid black !important; 
        }

        
        #printArea th, #printArea td {
            width: auto !important; 
            white-space: nowrap; 
        }
        @page {
        size: A4 portrait; 
        margin: 5mm; 
        }
    }    */

</style>

<div class="max-w-full mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                <form method="post" action="{{ route('driver_report.filter') }}">
                    @csrf
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center text-sm">
                            <label for="fromdate" class="mr-2">Check In Date</label>
                            <input type="date" name="fromdate" id="fromdate" class="form-input border rounded p-2 text-sm" required value="{{ old('fromdate', $fdate) }}">
                        </div>
                        <div>
                            <input class="form-input border rounded p-2 text-sm" type="search" name="search" placeholder="Search By Booking ID" value="{{ $search }}">
                        </div>
                        <div class="w-full sm:w-auto">
                            <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full sm:w-auto text-sm">Submit</button>
                        </div>
                        <button onclick="printDiv('printArea')" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Print</button>
                    </div>
                </form>
                <div id="printArea" class="text-lg print:text-[6px]">
                    <div class="flex flex-col space-y-4">
                        
                        {{-- <div class="card bg-white shadow rounded-lg"> --}}
                            <div class="p-4 pb-5">
                                Driver Report 
                                ({{ \Carbon\Carbon::parse($fdate)->format('d/m/Y') }})
                                <div class="overflow-x-auto text-sm print:text-[7px]">
                                    <table class="table-auto w-full border-collapse border border-gray-300 text-[12px] print:text-[14px] leading-tight">
                                        <thead>
                                            <tr>
                                                <th colspan="8" class="text-left font-bold text-gray-700 border border-gray-800 p-2">PICKUP</th>
                                            </tr>
                                            <tr class="bg-gray-100 text-left">
                                                <th class="border border-gray-300 p-2 print:p-[2px]">#</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[400px] whitespace-nowrap">Group Name (Company)</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[300px] whitespace-nowrap">Contact</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[400px] whitespace-nowrap text-center">Pax</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[500px] whitespace-nowrap">Transport Type (Pax)</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[100px] whitespace-nowrap">Booking ID</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[100px] whitespace-nowrap">NL</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[100px] whitespace-nowrap">Driver</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bookings as $group)
                                            @php $row = $group->first(); @endphp
                                            <tr class="odd:bg-white even:bg-gray-50">
                                                <td class="border border-gray-300 p-2 print:p-[2px]">{{ $loop->iteration }}</td>
                                                <td class="border border-gray-300 p-2 print:p-[2px]">
                                                    {{ $row->group_name }}
                                                    @if(!empty($row->company))
                                                        ({{ $row->company }})
                                                    @endif
                                                </td>
                                                <td class="border border-gray-300 p-2 print:p-[2px] w-[50px]">{{ $row->group_contact }}</td>
                                                <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {{ $row->pax_adult ?: '' }}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {{ $row->pax_child ?: '' }}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {{ $row->pax_toddler ?: '' }}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {!! '&nbsp;' !!}
                                                        {{ $row->pax_foc_tl ?: '' }}
                                                </td>
                                                <td class="border border-gray-300 p-2 print:p-[2px]">
                                                    {!! implode('<br/>', array_filter([
                                                        $row->pickup01_method ? $row->pickup01_method . " ({$row->pickup01_pax})" : null,
                                                        $row->pickup02_method ? $row->pickup02_method . " ({$row->pickup02_pax})" : null,
                                                        $row->pickup03_method ? $row->pickup03_method . " ({$row->pickup03_pax})" : null,
                                                    ])) !!}
                                                </td>
                                                <td class="border border-gray-300 p-2 print:p-[2px]">
                                                    <a href="{{ url('form') }}?booking={{ $row->booking_id }}" 
                                                        class="text-blue-500 print:text-black">
                                                         {{ $row->booking_id }}
                                                     </a>
                                                </td>
                                                <td class="border border-gray-300 p-2 print:p-[2px]">NL ({{ $row->pax_adult + $row->pax_child + $row->pax_toddler }})</td>
                                                <td class="border border-gray-300 p-2 print:p-[2px]">
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="w-[550px]">
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $sumpax['sumpax_adult'] }}A 
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $sumpax['sumpax_child'] }}C 
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $sumpax['sumpax_toddler'] }}T 
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $sumpax['sumpax_tl'] }}T/L
                                                </td>
                                            </tr>
                                        </tbody>                                
                                    </table>
                                    {{-- <div class="mt-4">
                                        {{ $bookings->links() }}
                                    </div> --}}
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>                
                    <div class="flex flex-col space-y-4">
                        {{-- <div class="card bg-white shadow rounded-lg"> --}}
                            <div class="p-4">
                                <div class="overflow-x-auto text-sm print:text-[7px]">
                                    <table class="table-auto w-full border-collapse border border-gray-300 text-[12px] print:text-[14px] leading-tight">
                                        <thead>
                                            <tr>
                                                <th colspan="8" class="text-left font-bold text-gray-700 border border-gray-800 p-2">DROPOFF</th>
                                            </tr>
                                            <tr class="bg-gray-100 text-left">
                                                <th class="border border-gray-300 p-2 print:p-[2px]">#</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[400px] whitespace-nowrap">Group Name (Company)</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[300px] whitespace-nowrap">Contact</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[400px] whitespace-nowrap text-center">Pax</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[500px] whitespace-nowrap">Transport Type (Pax)</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[100px] whitespace-nowrap">Booking ID</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[100px] whitespace-nowrap">NL</th>
                                                <th class="border border-gray-300 p-2 print:p-[2px] w-[100px] whitespace-nowrap">Driver</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dropoffs as $group)
                                                @php
                                                    // Get the first row from the group to display common data
                                                    $row2 = $group->first();
                                                @endphp
                                                <tr class="odd:bg-white even:bg-gray-50">
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">{{ $loop->iteration }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {{ $row2->group_name }}@if(!empty($row2->company))
                                                        ({{ $row2->company }})
                                                        @endif
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">{{ $row2->group_contact }}</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]"> 
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $row2->pax_adult ?: '' }}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $row2->pax_child ?: '' }}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $row2->pax_toddler ?: '' }}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $row2->pax_foc_tl ?: '' }}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        {{-- {{ $row2->dropoff01_method ? $row2->dropoff01_method . " ({$row2->dropoff01_method}) <br/>" : null }} 
                                                        {{ $row2->dropoff02_method ? $row2->dropoff02_method . " ({$row2->dropoff02_method}) <br/>" : null }} 
                                                        {{ $row2->dropoff03_method ? $row2->dropoff03_method . " ({$row2->dropoff03_method})" : null }} --}}

                                                        {!! implode('<br/>', array_filter([
                                                            $row2->dropoff01_method ? $row2->dropoff01_method . " ({$row2->dropoff01_pax})" : null,
                                                            $row2->dropoff02_method ? $row2->dropoff02_method . " ({$row2->dropoff02_pax})" : null,
                                                            $row2->dropoff03_method ? $row2->dropoff03_method . " ({$row2->dropoff03_pax})" : null,
                                                        ])) !!}
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">
                                                        <a href="{{ url('form') }}?booking={{ $row2->booking_id }}" 
                                                            class="text-blue-500 print:text-black">
                                                            {{ $row2->booking_id }}
                                                        </a>
                                                    </td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]">NL ({{ $row2->pax_adult + $row2->pax_child + $row2->pax_toddler }})</td>
                                                    <td class="border border-gray-300 p-2 print:p-[2px]"></td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="w-[550px]">
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $sumpax_dropoff['sumpax_dropoff_adult'] }}A 
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $sumpax_dropoff['sumpax_dropoff_child'] }}C
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $sumpax_dropoff['sumpax_dropoff_toddler'] }}T
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {!! '&nbsp;' !!}
                                                    {{ $sumpax_dropoff['sumpax_dropoff_tl'] }}T/L
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    {{-- <div class="mt-4">
                                        {{ $bookings->links() }}
                                    </div> --}}
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
                </div>             
            </div>
        </div>
    </div>
</div>
@endsection