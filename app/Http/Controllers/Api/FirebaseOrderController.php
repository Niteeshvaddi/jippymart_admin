<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;

class FirebaseOrderController extends Controller
{
    protected $firestore; // Changed from $database to $firestore for consistency

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

        $this->firestore = $factory->createFirestore()->database();
    }

    public function index(Request $request)
    {
        $limit = (int) $request->query('limit', 10); // default 50 orders per page
        $pageToken = $request->query('page_token', null);    // For pagination

        // Optional: filter by status or vendorID if you want
        $statusFilter = $request->query('status', null); // Renamed to avoid conflict
        $vendorID = $request->query('vendorID', null);

        $cacheKey = "firebase_orders_all_fields_{$pageToken}_{$limit}_{$statusFilter}_{$vendorID}";

        $data = Cache::remember($cacheKey, 5, function () use ($limit, $pageToken, $statusFilter, $vendorID) {
            $collection = $this->firestore->collection('restaurant_orders')->limit($limit);

            if ($pageToken) {
                $collection = $collection->startAfter([$pageToken]);
            }

            $documents = $collection->documents();
            $orders = [];
            $lastDoc = null;

            // Initialize counters inside the closure
            $total = 0;
            $activeOrders = 0;
            $completed = 0;
            $pending = 0;
            $cancelled = 0;

            foreach ($documents as $document) {
                $data = $document->data();
                $data['id'] = $document->id();

                // Convert any NaN or Inf to 0 (or null if you prefer)
                array_walk_recursive($data, function (&$value) {
                    if (is_float($value) && (is_nan($value) || is_infinite($value))) {
                        $value = 0;
                    }
                });

                $orders[] = $data;
                $lastDoc = $document;

                $total++;

                // ✅ Check order status - FIXED: Use $data instead of undefined $docData
                if (isset($data['status'])) {
                    $status = strtolower(trim($data['status']));

                    if (in_array($status, ['order placed', 'order accepted', 'order shipped', 'in transit', 'driver pending'])) {
                        $activeOrders++;
                    }

                    if ($status === 'order completed') {
                        $completed++;
                    }

                    if (in_array($status, ['order placed', 'driver pending', 'in transit'])) {
                        $pending++;
                    }

                    if (in_array($status, ['order rejected', 'driver rejected', 'order cancelled', 'cancelled'])) {
                        $cancelled++;
                    }
                }
            }

            $nextPageToken = $lastDoc ? $lastDoc->id() : null;

            return [
                'orders' => $orders,
                'next_page_token' => $nextPageToken,
                'counters' => [ // Return counters so they're available outside closure
                    'total' => $total,
                    'activeOrders' => $activeOrders,
                    'completed' => $completed,
                    'pending' => $pending,
                    'cancelled' => $cancelled,
                ]
            ];
        });

        // Extract counters from the cached data
        $counters = $data['counters'] ?? [
            'total' => 0,
            'activeOrders' => 0,
            'completed' => 0,
            'pending' => 0,
            'cancelled' => 0,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Orders fetched successfully',
            'meta' => [
                'limit' => $limit,
                'next_page_token' => $data['next_page_token'],
                'count' => count($data['orders']),
                'total_orders' => $counters['total'],
                'active_orders' => $counters['activeOrders'],
                'completed_orders' => $counters['completed'],
                'pending_orders' => $counters['pending'],
                'cancelled_orders' => $counters['cancelled'],
            ],
            'data' => $data['orders'],
        ]);
    }
}
