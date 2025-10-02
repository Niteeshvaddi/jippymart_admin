<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Google\Client as Google_Client;

class NotificationController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($id='')
    {
        return view("notification.index")->with('id',$id);
    }

    public function send($id='')
    {
        return view('notification.send')->with('id',$id);
    }

    public function broadcastnotification(Request $request)
    {
        // Log the request for debugging
        \Log::info('Broadcast notification request', [
            'role' => $request->role,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        if(Storage::disk('local')->has('firebase/serviceAccount.json')){
            
            try {
                $client = new Google_Client();
                $client->setAuthConfig(storage_path('app/firebase/serviceAccount.json'));
                $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
                $client->setAccessType('offline');
                $client->refreshTokenWithAssertion();
                $client_token = $client->getAccessToken();
                
                if (!$client_token || !isset($client_token['access_token'])) {
                    \Log::error('Failed to get access token from Google Client');
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to authenticate with Firebase.'
                    ]);
                }
                
                $access_token = $client_token['access_token'];
                \Log::info('Successfully obtained Firebase access token');
            } catch (\Exception $e) {
                \Log::error('Google Client authentication error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication error: ' . $e->getMessage()
                ]);
            }

            $role = $request->role;
            
            if(!empty($access_token) && !empty($role)){

                $projectId = env('FIREBASE_PROJECT_ID', 'jippymart-27c08');
                $url = 'https://fcm.googleapis.com/v1/projects/'.$projectId.'/messages:send';

                // Map roles to topics
                $topicMap = [
                    'vendor' => 'restaurant',
                    'customer' => 'customer', 
                    'driver' => 'driver'
                ];
                
                $topic = $topicMap[$role] ?? 'default';
                
                \Log::info('Sending notification', [
                    'project_id' => $projectId,
                    'role' => $role,
                    'topic' => $topic,
                    'url' => $url
                ]);

                $data = [
                    'message' => [
                        'notification' => [
                            'title' => $request->subject,
                            'body' => $request->message,
                        ],
                        'topic' => $topic,
                        'android' => [
                            'notification' => [
                                'sound' => 'default'
                            ],
                            'priority' => 'high'
                        ],
                        'apns' => [
                            'payload' => [
                                'aps' => [
                                    'sound' => 'default',
                                    'badge' => 1
                                ]
                            ]
                        ]
                    ],
                ];

                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$access_token
                );

                \Log::info('FCM Request Data', ['data' => $data]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlError = curl_error($ch);
                curl_close($ch);
                
                \Log::info('FCM Response', [
                    'http_code' => $httpCode,
                    'result' => $result,
                    'curl_error' => $curlError
                ]);
                
                if ($result === FALSE || !empty($curlError)) {
                    \Log::error('FCM Send Error: ' . $curlError);
                    return response()->json([
                        'success' => false,
                        'message' => 'FCM Send Error: ' . $curlError
                    ]);
                }
                
                $resultData = json_decode($result, true);
                
                if ($httpCode >= 200 && $httpCode < 300) {
                    \Log::info('Notification sent successfully', ['result' => $resultData]);
                    return response()->json([
                        'success' => true,
                        'message' => 'Notification successfully sent to ' . $role . ' topic: ' . $topic,
                        'result' => $resultData
                    ]);
                } else {
                    \Log::error('FCM API Error', [
                        'http_code' => $httpCode,
                        'response' => $resultData
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'FCM API Error: ' . ($resultData['error']['message'] ?? 'Unknown error'),
                        'result' => $resultData
                    ]);
                }

            }else{
                \Log::error('Missing access token or role for notification');
                return response()->json([
                    'success' => false,
                    'message' => 'Missing access token or role to send notification.'
                ]);
            }

        }else{
            \Log::error('Firebase serviceAccount.json file not found in storage/app/firebase/');
            return response()->json([
                'success' => false,
                'message' => 'Firebase serviceAccount.json file not found. Please check your Firebase configuration.'
            ]);
        }
    }
    
    public function sendNotification(Request $request)
    {
        \Log::info('Individual notification request', [
            'fcm_token' => $request->fcm,
            'title' => $request->title,
            'message' => $request->message
        ]);

        if(Storage::disk('local')->has('firebase/serviceAccount.json')){
            
            try {
                $client = new Google_Client();
                $client->setAuthConfig(storage_path('app/firebase/serviceAccount.json'));
                $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
                $client->setAccessType('offline');
                $client->refreshTokenWithAssertion();
                $client_token = $client->getAccessToken();
                
                if (!$client_token || !isset($client_token['access_token'])) {
                    \Log::error('Failed to get access token from Google Client');
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to authenticate with Firebase.'
                    ]);
                }
                
                $access_token = $client_token['access_token'];
                \Log::info('Successfully obtained Firebase access token for individual notification');
            } catch (\Exception $e) {
                \Log::error('Google Client authentication error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication error: ' . $e->getMessage()
                ]);
            }

            $fcm_token = $request->fcm;
            
            if(!empty($access_token) && !empty($fcm_token)){

                $projectId = env('FIREBASE_PROJECT_ID', 'jippymart-27c08');
                $url = 'https://fcm.googleapis.com/v1/projects/'.$projectId.'/messages:send';

                $data = [
                    'message' => [
                        'notification' => [
                            'title' => $request->title,
                            'body' => $request->message,
                        ],
                        'token' => $fcm_token,
                        'android' => [
                            'notification' => [
                                'sound' => 'default'
                            ],
                            'priority' => 'high'
                        ],
                        'apns' => [
                            'payload' => [
                                'aps' => [
                                    'sound' => 'default',
                                    'badge' => 1
                                ]
                            ]
                        ]
                    ],
                ];

                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$access_token
                );

                \Log::info('FCM Individual Request Data', ['data' => $data]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlError = curl_error($ch);
                curl_close($ch);
                
                \Log::info('FCM Individual Response', [
                    'http_code' => $httpCode,
                    'result' => $result,
                    'curl_error' => $curlError
                ]);
                
                if ($result === FALSE || !empty($curlError)) {
                    \Log::error('FCM Send Error: ' . $curlError);
                    return response()->json([
                        'success' => false,
                        'message' => 'FCM Send Error: ' . $curlError
                    ]);
                }
                
                $resultData = json_decode($result, true);
                
                if ($httpCode >= 200 && $httpCode < 300) {
                    \Log::info('Individual notification sent successfully', ['result' => $resultData]);
                    return response()->json([
                        'success' => true,
                        'message' => 'Notification successfully sent to device',
                        'result' => $resultData
                    ]);
                } else {
                    \Log::error('FCM API Error', [
                        'http_code' => $httpCode,
                        'response' => $resultData
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'FCM API Error: ' . ($resultData['error']['message'] ?? 'Unknown error'),
                        'result' => $resultData
                    ]);
                }

            }else{
                \Log::error('Missing access token or FCM token for individual notification');
                return response()->json([
                    'success' => false,
                    'message' => 'Missing access token or FCM token to send notification.'
                ]);
            }

        }else{
            \Log::error('Firebase serviceAccount.json file not found in storage/app/firebase/');
            return response()->json([
                'success' => false,
                'message' => 'Firebase serviceAccount.json file not found. Please check your Firebase configuration.'
            ]);
        }
    }

}