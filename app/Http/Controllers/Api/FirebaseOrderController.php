<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kreait\Firebase\Factory;

class FirebaseOrderController extends Controller
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

        // Create Firestore database connection
        $this->firestore = $factory->createFirestore()->database();
    }

    // Fetch all orders or filter by restaurant_id / status
    public function index(Request $request)
    {
//        $limit = (int) $request->query('limit', 10);         // Number of orders per page
        $limit = (int) $request->query('limit', 50); // default 50 orders per page
        $pageToken = $request->query('page_token', null);    // For pagination

        // Optional: filter by status or vendorID if you want
        $status = $request->query('status', null);
        $vendorID = $request->query('vendorID', null);

        $cacheKey = "firebase_orders_all_fields_{$pageToken}_{$limit}_{$status}_{$vendorID}";

        $data = Cache::remember($cacheKey, 5, function () use ($limit, $pageToken, $status, $vendorID) {
            $collection = $this->firestore->collection('restaurant_orders')->limit($limit);

            if ($pageToken) {
                $collection = $collection->startAfter([$pageToken]);
            }

            $documents = $collection->documents();
//            $orders = [];
//            $lastDoc = null;
//
//            foreach ($documents as $document) {
//                $docData = $document->data();
//                $docData['id'] = $document->id(); // include document ID dynamically
//
//                // Optional filters
//                if ($status && isset($docData['status']) && $docData['status'] != $status) {
//                    continue;
//                }
//                if ($vendorID && isset($docData['vendorID']) && $docData['vendorID'] != $vendorID) {
//                    continue;
//                }
//
//                $orders[] = $docData;
//                $lastDoc = $document;
//            }
            $orders = [];
            //            $lastDoc = null;

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

            }
            $nextPageToken = $lastDoc ? $lastDoc->id() : null;

            return [
                'orders' => $orders,
                'next_page_token' => $nextPageToken,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Orders fetched successfully',
            'meta' => [
                'limit' => $limit,
                'next_page_token' => $data['next_page_token'],
                'count' => count($data['orders']),
            ],
            'data' => $data['orders'],
        ]);
    }
}
