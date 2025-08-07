# Real-Time Order Notification System

## Overview

This implementation adds a global real-time notification system to the admin panel that automatically detects when new orders are placed and shows instant notifications to administrators, regardless of which page they're currently viewing.

## Features

### 1. Real-Time Order Detection
- **Firebase Firestore Listener**: Continuously monitors the `restaurant_orders` collection for new documents
- **Timestamp Comparison**: Prevents showing notifications for existing orders when the page loads
- **Automatic Reconnection**: Handles connection errors and automatically retries

### 2. Toast Notifications
- **Visual Alerts**: Shows toast notifications in the top-right corner
- **Clickable**: Clicking the notification navigates to the orders page
- **Auto-dismiss**: Notifications automatically disappear after 5 seconds
- **Sound Alert**: Optional audio notification (gentle beep sound)

### 3. Header Badge Indicator
- **Notification Bell**: Added to the header with a red badge
- **Counter**: Shows the number of new orders received
- **Auto-clear**: Badge automatically clears after 30 seconds
- **Manual Clear**: Badge clears when visiting the orders page

### 4. Dashboard Integration
- **Live Counter Updates**: Order count on dashboard updates in real-time
- **Test Button**: Development tool to simulate new orders

## Technical Implementation

### Files Modified

1. **`resources/views/layouts/app.blade.php`**
   - Added global notification system JavaScript
   - Added CSS styles for notification bell
   - Integrated with existing Firebase setup

2. **`resources/views/layouts/header.blade.php`**
   - Added notification bell icon with badge
   - Positioned in the header navigation

3. **`resources/views/home.blade.php`**
   - Added test button for simulating new orders
   - Integrated with existing dashboard functionality

4. **`app/Http/Controllers/OrderController.php`**
   - Added test method for creating sample orders
   - Includes proper error handling

5. **`routes/web.php`**
   - Added test route for order simulation

### Key Components

#### 1. Firebase Real-Time Listener
```javascript
// Listen for new documents in restaurant_orders collection
ordersRef.onSnapshot((snapshot) => {
    snapshot.docChanges().forEach((change) => {
        if (change.type === 'added') {
            // Process new order
        }
    });
});
```

#### 2. Toast Notification System
```javascript
$.toast({
    heading: 'New Order Received!',
    text: `Order #${orderData.id} from ${orderData.vendor.title}`,
    position: 'top-right',
    icon: 'info',
    hideAfter: 5000,
    onClick: function() {
        window.location.href = '/orders';
    }
});
```

#### 3. Badge Management
```javascript
function updateNotificationBadge() {
    const badge = document.getElementById('new-orders-badge');
    const newCount = parseInt(badge.textContent) || 0 + 1;
    badge.textContent = newCount;
    badge.style.display = 'block';
}
```

## How It Works

### 1. Initialization
- System starts when the page loads
- Gets the latest order timestamp to avoid showing old orders
- Establishes real-time connection to Firebase

### 2. Order Detection
- Firebase Firestore listener monitors the `restaurant_orders` collection
- When a new document is added, the system compares timestamps
- Only shows notifications for orders newer than the last known order

### 3. Notification Display
- Shows toast notification with order details
- Plays optional sound alert
- Updates header badge counter
- Updates dashboard order count (if on dashboard)

### 4. User Interaction
- Clicking notification navigates to orders page
- Badge automatically clears after 30 seconds
- Visiting orders page manually clears the badge

## Testing

### Test Button
A test button is available on the dashboard to simulate new orders:

1. Navigate to the dashboard (`/dashboard`)
2. Click the "Test New Order" button
3. A test order will be created in Firebase
4. The notification system should trigger immediately

### Manual Testing
You can also test by:
1. Creating orders through the mobile app
2. Manually adding documents to the `restaurant_orders` collection in Firebase Console
3. Using the Firebase Admin SDK to create test orders

## Configuration

### Firebase Setup
The system uses the existing Firebase configuration:
- **Collection**: `restaurant_orders`
- **Required Fields**: `id`, `vendor`, `createdAt`, `status`
- **Optional Fields**: `products`, `total`

### Customization Options

#### 1. Notification Duration
```javascript
hideAfter: 5000, // 5 seconds
```

#### 2. Badge Auto-clear Time
```javascript
setTimeout(() => {
    badge.style.display = 'none';
}, 30000); // 30 seconds
```

#### 3. Sound Volume
```javascript
notificationSound.volume = 0.3; // 30% volume
```

#### 4. Notification Position
```javascript
position: 'top-right', // Can be: top-left, top-right, bottom-left, bottom-right
```

## Troubleshooting

### Common Issues

1. **Notifications not showing**
   - Check browser console for Firebase connection errors
   - Verify Firebase configuration is correct
   - Ensure user has proper permissions

2. **Sound not playing**
   - Modern browsers require user interaction before playing audio
   - Check browser autoplay policies
   - Verify audio element creation

3. **Badge not updating**
   - Check if element with ID `new-orders-badge` exists
   - Verify CSS styles are loaded
   - Check for JavaScript errors

### Debug Mode
The system includes debug functions accessible via console:
```javascript
// Access notification system functions
window.orderNotificationSystem.initializeOrderListener();
window.orderNotificationSystem.showNewOrderNotification(orderData);
window.orderNotificationSystem.clearNotificationBadge();
```

## Security Considerations

1. **Firebase Rules**: Ensure proper Firestore security rules are in place
2. **Authentication**: The system respects existing user authentication
3. **Rate Limiting**: Consider implementing rate limiting for the test endpoint
4. **Data Validation**: Validate order data before processing

## Performance Considerations

1. **Connection Management**: System automatically handles connection errors
2. **Memory Usage**: Proper cleanup of event listeners
3. **Network Efficiency**: Only listens for new documents, not all changes
4. **Browser Compatibility**: Works with modern browsers supporting Firebase

## Future Enhancements

1. **Notification Preferences**: Allow users to customize notification settings
2. **Order Priority**: Different notifications for high-value orders
3. **Sound Customization**: Allow custom notification sounds
4. **Push Notifications**: Extend to browser push notifications
5. **Mobile App Integration**: Sync notifications with mobile admin app

## Support

For issues or questions:
1. Check browser console for error messages
2. Verify Firebase configuration
3. Test with the provided test button
4. Review this documentation for troubleshooting steps 