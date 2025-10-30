@extends('layouts.main')

@section('title', 'Food List')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-8">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-semibold text-gray-800 flex items-center gap-2">
                🍿 Food Inventory
            </h1>
<a href="{{ route('food.create') }}" 
   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-3xl shadow transition duration-200 ease-in-out">
   + Add Food
</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Food Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Owner Phone</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Expiry Date</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($food as $foodItem)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $foodItem->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $foodItem->owner_phone ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ \Carbon\Carbon::parse($foodItem->expiry_date)->isPast() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $foodItem->expiry_date }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $foodItem->quantity }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $foodItem->notes ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('food.edit', $foodItem->id) }}">update</a>

                            <form action="{{ route('food.destroy', $foodItem->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this food item?')">
                               
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>

                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($food->isEmpty())
            <div class="text-center py-10 text-gray-500">
                <i class="fa-solid fa-utensils text-4xl mb-2"></i>
                <p>No food items available.</p>
            </div>
        @endif
    </div>
</div>

@endsection
