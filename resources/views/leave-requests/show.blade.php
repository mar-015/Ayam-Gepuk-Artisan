<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Leave Request Details') }}
            </h2>
            <a href="{{ route('leave-requests.index') }}" class="text-blue-600 hover:text-blue-800">Back to List</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Request Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Information</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($leaveRequest->type === 'vacation') bg-blue-100 text-blue-800
                                            @elseif($leaveRequest->type === 'sick') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($leaveRequest->type) }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($leaveRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($leaveRequest->status === 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($leaveRequest->status) }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date Range</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $leaveRequest->start_date->format('M d, Y') }} - {{ $leaveRequest->end_date->format('M d, Y') }}
                                        <span class="text-gray-500">
                                            ({{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} days)
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Submitted On</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $leaveRequest->created_at->format('M d, Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Request Details -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Details</h3>
                            
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Reason</h4>
                                <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-4">
                                    {{ $leaveRequest->reason }}
                                </p>
                            </div>

                            @if($leaveRequest->admin_remarks)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Admin Remarks</h4>
                                    <p class="text-sm text-gray-900 bg-gray-50 rounded-lg p-4">
                                        {{ $leaveRequest->admin_remarks }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($leaveRequest->status === 'pending' && (auth()->user()->isAdmin() || auth()->user()->isManager()))
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Take Action</h3>
                            <div class="flex space-x-4">
                                <form action="{{ route('leave-requests.approve', $leaveRequest) }}" method="POST" class="flex-1">
                                    @csrf
                                    <div class="mb-4">
                                        <x-input-label for="approve_remarks" :value="__('Remarks (Optional)')" />
                                        <textarea id="approve_remarks" name="admin_remarks" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="2"></textarea>
                                    </div>
                                    <x-primary-button class="w-full justify-center">
                                        {{ __('Approve Request') }}
                                    </x-primary-button>
                                </form>

                                <form action="{{ route('leave-requests.reject', $leaveRequest) }}" method="POST" class="flex-1">
                                    @csrf
                                    <div class="mb-4">
                                        <x-input-label for="reject_remarks" :value="__('Rejection Reason')" />
                                        <textarea id="reject_remarks" name="admin_remarks" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="2" required></textarea>
                                    </div>
                                    <x-danger-button class="w-full justify-center">
                                        {{ __('Reject Request') }}
                                    </x-danger-button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
