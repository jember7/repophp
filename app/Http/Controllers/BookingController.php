<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BookingController extends Controller
{
    public function store1(Request $request)
    {
        // Validation for the incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'expert_id' => 'required|exists:users,id',
            'expert_name' => 'required|string',
            'user_name' => 'required|string',
            'status' => 'nullable|string',
            'timestamp' => 'nullable|date',
            'note' => 'nullable|string',
            'rate' => 'nullable|string',
            'expert_address' => 'nullable|string',
            'expert_image_url' => 'nullable|string',
            'user_address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $validator->errors()
            ], 400);
        }

        // Create a new booking
        $booking = Booking::create([
            'user_id' => $request->userId,
            'expert_id' => $request->expertId,
            'expert_name' => $request->expertName,
            'user_name' => $request->userName,
            'status' => $request->status,
            'timestamp' => $request->timestamp,
        ]);

        // Return success response
        return response()->json([
            'message' => 'Booking successfully created',
            'data' => $booking
        ], 201);
    }
    public function getExpertBookings($userId)
{
    // Logic to fetch completed bookings for the given expert
    $bookings = Booking::where('expert_id', $userId)->where('status', 'completed')->get();
    return response()->json($bookings);
}

public function getOngoingBookings($userId)
{
    // Logic to fetch ongoing bookings for the given expert
    $bookings = Booking::where('expert_id', $userId)->where('status', 'ongoing')->get();
    return response()->json($bookings);
}
    // Method to create a new booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'expert_id' => 'required|exists:users,id',
            'expert_name' => 'required|string',
            'user_name' => 'required|string',
            'status' => 'nullable|string',
            'timestamp' => 'nullable|date',
            'note' => 'nullable|string',
            'rate' => 'nullable|string',
            'expert_address' => 'nullable|string',
            'expert_image_url' => 'nullable|string',
            'user_address' => 'nullable|string',
        ]);

        $booking = Booking::create([
            'user_id' => $validated['user_id'],
            'expert_id' => $validated['expert_id'],
            'expert_name' => $validated['expert_name'],
            'user_name' => $validated['user_name'],
            'status' => $validated['status'] ?? 'Pending',  // Default to "Pending"
            'timestamp' => $validated['timestamp'] ?? now(),
            'note' => $validated['note'] ?? null,
            'rate' => $validated['rate'] ?? null,
            'expert_address' => $validated['expert_address'],
            'expert_image_url' => $validated['expert_image_url'] ?? null,
            'user_address' => $validated['user_address'] ?? null,
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'data' => $booking,
        ], 201);
    }

    // Method to update the booking status (e.g., to "Accepted" or "Completed")
    public function updateBookingStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Accepted,Completed',
        ]);

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->status = $validated['status'];
        $booking->save();

        return response()->json([
            'message' => 'Booking status updated successfully',
            'data' => $booking,
        ]);
    }
}
