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
                {{-- <form method="post" action="{{ route('room_list_report.filter') }}">
                    @csrf
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center text-sm">
                            <label for="fromdate" class="mr-2 text-sm">Check In Date</label>
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
                </form> --}}
                <div class="flex flex-col space-y-4">
                    <div class="card bg-white shadow rounded-lg">
                        <div class="p-4">
                            <div id="printArea" class="text-xs print:text-[6px]">
                                <div class="text-xl">Name List Report</div>
                                <div class="overflow-x-auto text-xs print:text-[7px]">
                                    <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="border border-gray-300 p-2 w-[20px]">#</th>
                                                <th class="border border-gray-300 p-2">Booking ID</th>
                                                <th class="border border-gray-300 p-2">Name</th>
                                                <th class="border border-gray-300 p-2">IC/Passport</th>
                                                <th class="border border-gray-300 p-2">Nationality</th>
                                                <th class="border border-gray-300 p-2">Age</th>
                                                <th class="border border-gray-300 p-2">Gender</th>
                                                <th class="border border-gray-300 p-2">DOB</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($name_list_details as $row)
                                            <tr class="odd:bg-white even:bg-gray-50">
                                                <td class="border border-gray-300 p-2 text-center">
                                                    {{ $loop->iteration + ($name_list_details->currentPage() - 1) * $name_list_details->perPage() }}
                                                </td>
                                                <td class="border border-gray-300 p-2">{{ $row->bookingID }}</td>
                                                <td class="border border-gray-300 p-2">{{ $row->name }}</td>
                                                <td class="border border-gray-300 p-2">{{ $row->IC }}</td>
                                                <td class="border border-gray-300 p-2">{{ $row->nationality }}</td>
                                                <td class="border border-gray-300 p-2">
                                                    @if ($row->DOB)
                                                        {{ \Carbon\Carbon::parse($row->DOB)->age }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="border border-gray-300 p-2 text-center">
                                                    {{ isset($row->gender) ? ($row->gender == 1 ? 'L' : 'P') : '-' }}
                                                </td>
                                                <td class="border border-gray-300 p-2">{{ $row->DOB }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="border border-gray-300 p-4 text-center text-gray-500">
                                                    No data available
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" class="border border-gray-300 p-2 text-right text-xs text-gray-500">
                                                    Generated: {{ now()->format('d/m/Y g:i:s A') }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                {{-- Pagination --}}
                                @if ($name_list_details->hasPages())
                                    <div class="flex justify-center mt-4 space-x-1">
                                        {{-- Previous Page Link --}}
                                        @if ($name_list_details->onFirstPage())
                                            <span class="px-3 py-1 text-sm bg-gray-200 text-gray-500 rounded">Previous</span>
                                        @else
                                            <a href="{{ $name_list_details->previousPageUrl() }}" class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">Previous</a>
                                        @endif
                                
                                        {{-- Limited Pagination Elements --}}
                                        @php
                                            $currentPage = $name_list_details->currentPage();
                                            $lastPage = $name_list_details->lastPage();
                                            $start = max($currentPage - 2, 1);
                                            $end = min($currentPage + 2, $lastPage);
                                        @endphp
                                
                                        @if ($start > 1)
                                            <a href="{{ $name_list_details->url(1) }}" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">1</a>
                                            @if ($start > 2)
                                                <span class="px-2">...</span>
                                            @endif
                                        @endif
                                
                                        @for ($page = $start; $page <= $end; $page++)
                                            @if ($page == $currentPage)
                                                <span class="px-3 py-1 text-sm bg-blue-700 text-white rounded">{{ $page }}</span>
                                            @else
                                                <a href="{{ $name_list_details->url($page) }}" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">{{ $page }}</a>
                                            @endif
                                        @endfor
                                
                                        @if ($end < $lastPage)
                                            @if ($end < $lastPage - 1)
                                                <span class="px-2">...</span>
                                            @endif
                                            <a href="{{ $name_list_details->url($lastPage) }}" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">{{ $lastPage }}</a>
                                        @endif
                                
                                        {{-- Next Page Link --}}
                                        @if ($name_list_details->hasMorePages())
                                            <a href="{{ $name_list_details->nextPageUrl() }}" class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">Next</a>
                                        @else
                                            <span class="px-3 py-1 text-sm bg-gray-200 text-gray-500 rounded">Next</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection