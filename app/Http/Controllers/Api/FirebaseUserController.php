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
//        $this->firebase = (new \Kreait\Firebase\Factory())
//            ->withServiceAccount(storage_path('storage/app/firebase/credentials.json'))
//            ->createFirestore();
//
//        $this->firestore = $this->firebase->database();

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

            // Initialize counters
            $total = 0;
            $active = 0;
            $inactive = 0;
            $documentVerified = 0;

            foreach ($documents as $document) {
                $docData = $document->data();
                $docData['id'] = $document->id();

                $users[] = $docData;
                $lastDoc = $document;

                // Counting logic
                $total++;

                if (isset($docData['active']) && $docData['active'] === true) {
                    $active++;
                } else {
                    $inactive++;
                }

                if (!empty($docData['isDocumentVerify']) && $docData['isDocumentVerify'] === true) {
                    $documentVerified++;
                }
            }

            $nextPageToken = $lastDoc ? $lastDoc->id() : null;

            return [
                'users' => $users,
                'next_page_token' => $nextPageToken,
                'counts' => [
                    'total' => $total,
                    'active' => $active,
                    'inactive' => $inactive,
                    'document_verified' => $documentVerified,
                ],
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
            'counts' => $data['counts'],
            'data' => $data['users'],
        ]);
    }
}
