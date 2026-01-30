<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $category = Category::count();
        $product  = Product::count();
        $order    = Order::count();
        $user     = User::where('role', 'customer')->count();


        $totalRevenue = Order::where('payment_status', 'paid')
            ->sum('grand_total');

        $months = collect([
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ]);

        
        $ordersRaw = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyOrders = $months->mapWithKeys(function ($month, $index) use ($ordersRaw) {
            return [
                $month => $ordersRaw[$index + 1] ?? 0
            ];
        });

        $revenueRaw = Order::selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyRevenue = $months->mapWithKeys(function ($month, $index) use ($revenueRaw) {
            return [
                $month => $revenueRaw[$index + 1] ?? 0
            ];
        });

     
        $latestOrders = Order::with('getcustomer')
            ->latest()
            ->take(6)
            ->get();


        return view('Admin.Dashboard.dashboard', compact(
            'category',
            'product',
            'order',
            'user',
            'totalRevenue',
            'monthlyOrders',
            'monthlyRevenue',
            'latestOrders'
        ));
    }
    public function profile()
    {
        return view('Admin.Auth.profile');
    }
    public function update(Request $request)
    {
        $id =Auth::user()->id;
        $user = User::where('id',$id)->first();
        $newimage = $user->image;

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'phone'   => 'required|digits:10',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'address' => 'required|string|max:255',
            'image'   => 'image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete('user/' . $user->image);
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('user', $filename, 'public');
            $newimage = $filename;
        }

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'image'   => $newimage,
            'address' => $request->address,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile Updated Successfully',
        ], 200);
    }

    public function chat()
    {
        $adminId = Auth::id();

        $userIds = ChatMessage::where('sender_id', $adminId)
            ->orWhere('receiver_id', $adminId)
            ->get()
            ->flatMap(function ($chat) use ($adminId) {
                return [$chat->sender_id, $chat->receiver_id];
            })
            ->unique()
            ->reject(fn($id) => $id == $adminId);

        $chats = User::whereIn('id', $userIds)
            ->with(['sentMessages' => function ($q) use ($adminId) {
                $q->where('receiver_id', $adminId)->where('is_seen', 0);
            }])
            ->get();

        return view('Admin.Dashboard.chat', compact('chats'));
    }

    public function show($userId)
    {
        $adminId = Auth::id();

        $messages = ChatMessage::where(function ($q) use ($userId, $adminId) {
            $q->where('sender_id', $userId)->where('receiver_id', $adminId);
        })->orWhere(function ($q) use ($userId, $adminId) {
            $q->where('sender_id', $adminId)->where('receiver_id', $userId);
        })->orderBy('id')->get();
        ChatMessage::where('sender_id', $userId)
            ->where('receiver_id', $adminId)
            ->update(['is_seen' => 1]);

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        ChatMessage::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->user_id,
            'message'     => $request->message,
            'is_seen'     => 0
        ]);

        return response()->json(['status' => true]);
    }

    public function unreadCount()
    {
        $count = ChatMessage::where('receiver_id', Auth::id())
            ->where('is_seen', 0)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function updatechat(Request $request)
    {
        $adminId = Auth::id();

        ChatMessage::where('id', $request->id)
            ->where('sender_id', $adminId)
            ->update(['message' => $request->message]);

        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $adminId = Auth::id();

        ChatMessage::where('id', $request->id)
            ->where('sender_id', $adminId) 
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully'
        ]);
    }
}
