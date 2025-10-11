<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Cache;

class FirebaseUserController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

        // Create Firestore database connection
        $this->firestore = $factory->createFirestore()->database();
    }

    public function index(Request $request)
    {
        $role = $request->query('role', null);
        $limit = (int) $request->query('limit', 10);
        $pageToken = $request->query('page_token', null);

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role is required (driver, vendor, user)',
            ], 400);
        }

        // Cache key for performance
        $cacheKey = "firebase_users_all_fields_{$role}_{$pageToken}_{$limit}";

        $data = Cache::remember($cacheKey, 5, function () use ($role, $limit, $pageToken) {
            $collection = $this->firestore->collection('users')
                ->where('role', '==', $role)
                ->limit($limit);

            if ($pageToken) {
                $collection = $collection->startAfter([$pageToken]);
            }

            $documents = $collection->documents();
            $users = [];
            $lastDoc = null;

            foreach ($documents as $document) {
                $docData = $document->data();

                // Include all fields dynamically
                $docData['id'] = $document->id();

                $users[] = $docData;
                $lastDoc = $document;
            }

            $nextPageToken = $lastDoc ? $lastDoc->id() : null;

            return [
                'users' => $users,
                'next_page_token' => $nextPageToken,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully',
            'meta' => [
                'role' => $role,
                'limit' => $limit,
                'next_page_token' => $data['next_page_token'],
                'count' => count($data['users']),
            ],
            'data' => $data['users'],
        ]);
    }
}
