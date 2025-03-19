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
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                <form method="post" action="{{ route('room_list_report.filter') }}">
                    @csrf
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center">
                            <label for="fromdate" class="mr-2">Booking Date</label>
                            <input type="date" name="fromdate" id="fromdate" class="form-input border rounded p-2" required value="{{ old('fromdate', $fdate) }}">
                        </div>
                        <div>
                            <input class="form-input border rounded p-2" type="search" name="search" placeholder="Search By Booking ID" value="{{ $search }}">
                        </div>
                        <div class="w-full sm:w-auto">
                            <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full sm:w-auto">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="flex flex-col space-y-4">
                    <div class="card bg-white shadow rounded-lg">
                        <div class="p-4">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr>
                                            <th colspan="8" class="text-left font-bold text-gray-700 border-b border-gray-300 p-2">Room List Report</th>
                                        </tr>
                                        <tr class="bg-gray-100 text-left">
                                            <th class="border border-gray-300 p-2">Check In</th>
                                            <th class="border border-gray-300 p-2">Check Out</th>
                                            <th class="border border-gray-300 p-2">Days</th>
                                            <th class="border border-gray-300 p-2">Contact Name (Company)</th>
                                            <th class="border border-gray-300 p-2">Pax</th>
                                            <th class="border border-gray-300 p-2">Rooms</th>
                                            <th class="border border-gray-300 p-2">Room Allocated</th>
                                            <th class="border border-gray-300 p-2">Remarks</th>
                                            <th class="border border-gray-300 p-2">Booking ID</th>
                                            <th class="border border-gray-300 p-2">Name List</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $cnt => $group)
                                        @php $row = $group->first(); @endphp
                                        <tr class="odd:bg-white even:bg-gray-50">
                                            <td class="border border-gray-300 p-2">
                                                {{ $row->check_in }}
                                            </td>
                                            <td class="border border-gray-300 p-2">
                                                {{ $row->check_out }}
                                            </td>
                                            <td class="border border-gray-300 p-2">
                                                {{ $row->nights }}
                                            </td>
                                            <td class="border border-gray-300 p-2">
                                                {{$row->group_name}} ({{ $row->company }})
                                            </td>

                                            <td class="border border-gray-300 p-2">
                                                <div>Adult: {{ $row->pax_adult }}</div>
                                                <div>Child: {{ $row->pax_child }}</div>
                                                <div>Toddler: {{ $row->pax_toddler }}</div>
                                            </td>
                                            <td class="border border-gray-300 p-2">

                                            </td>
                                            <td class="border border-gray-300 p-2">
                                                {{-- @foreach ($group as $room)
                                                    @if ($room->rooms)
                                                        <div>{{ $room->rooms }}</div>
                                                    @endif
                                                @endforeach --}}
                                            </td>
                                            <td class="border border-gray-300 p-2">{{ $row->internal_remarks }}</td>
                                            <td class="border border-gray-300 p-2">
                                                {{ $row->booking_id }}
                                            </td>
                                            <td class="border border-gray-300 p-2">NL ({{ $row->pax_adult + $row->pax_child + $row->pax_toddler }})</td>
                                        </tr>
                                        @endforeach
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
@endsection