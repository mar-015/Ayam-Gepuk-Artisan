<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->middleware('auth');
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', LeaveRequest::class);
        
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isManager()) {
            $leaveRequests = LeaveRequest::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $leaveRequests = LeaveRequest::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('leave-requests.index', compact('leaveRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', LeaveRequest::class);
        return view('leave-requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', LeaveRequest::class);
        
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:vacation,sick,personal',
            'reason' => 'required|string|max:255',
        ]);

        $leaveRequest = LeaveRequest::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            ...$validated
        ]);

        return redirect()->route('leave-requests.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        $this->authorize('view', $leaveRequest);
        return view('leave-requests.show', compact('leaveRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Approve the specified resource.
     */
    public function approve(LeaveRequest $leaveRequest)
    {
        $this->authorize('approve', $leaveRequest);

        $leaveRequest->update([
            'status' => 'approved',
            'admin_remarks' => request('admin_remarks'),
        ]);

        $this->notificationService->notifyLeaveRequestUpdate($leaveRequest);

        return redirect()->back()
            ->with('success', 'Leave request approved successfully.');
    }

    /**
     * Reject the specified resource.
     */
    public function reject(LeaveRequest $leaveRequest)
    {
        $this->authorize('reject', $leaveRequest);

        $leaveRequest->update([
            'status' => 'rejected',
            'admin_remarks' => request('admin_remarks'),
        ]);

        $this->notificationService->notifyLeaveRequestUpdate($leaveRequest);

        return redirect()->back()
            ->with('success', 'Leave request rejected successfully.');
    }
}
