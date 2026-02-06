/**
 * Push Notification Service
 * Handles push notification subscription and management
 */

const VAPID_PUBLIC_KEY = process.env.VITE_VAPID_PUBLIC_KEY || '';

/**
 * Request push notification permission
 */
export async function requestPermission() {
  if (!('Notification' in window)) {
    console.warn('[PushNotifications] Notifications not supported');
    return false;
  }

  if (Notification.permission === 'granted') {
    return true;
  }

  const permission = await Notification.requestPermission();
  return permission === 'granted';
}

/**
 * Subscribe to push notifications
 */
export async function subscribeToPush() {
  if (!('serviceWorker' in navigator)) {
    console.warn('[PushNotifications] Service Worker not supported');
    return null;
  }

  if (!('PushManager' in window)) {
    console.warn('[PushNotifications] Push Manager not supported');
    return null;
  }

  try {
    // Request permission first
    const hasPermission = await requestPermission();
    if (!hasPermission) {
      console.warn('[PushNotifications] Permission denied');
      return null;
    }

    // Get service worker registration
    const registration = await navigator.serviceWorker.ready;

    // Check if already subscribed
    let subscription = await registration.pushManager.getSubscription();
    if (subscription) {
      console.log('[PushNotifications] Already subscribed');
      return subscription;
    }

    // Subscribe to push service
    if (!VAPID_PUBLIC_KEY) {
      console.warn('[PushNotifications] VAPID public key not configured');
      return null;
    }

    subscription = await registration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: urlBase64ToUint8Array(VAPID_PUBLIC_KEY),
    });

    console.log('[PushNotifications] Subscribed to push notifications');

    // Send subscription to backend
    await sendSubscriptionToBackend(subscription);

    return subscription;
  } catch (error) {
    console.error('[PushNotifications] Failed to subscribe:', error);
    return null;
  }
}

/**
 * Unsubscribe from push notifications
 */
export async function unsubscribeFromPush() {
  if (!('serviceWorker' in navigator)) {
    return false;
  }

  try {
    const registration = await navigator.serviceWorker.ready;
    const subscription = await registration.pushManager.getSubscription();

    if (subscription) {
      await subscription.unsubscribe();
      
      // Remove from backend
      await removeSubscriptionFromBackend(subscription);
      
      console.log('[PushNotifications] Unsubscribed from push notifications');
      return true;
    }

    return false;
  } catch (error) {
    console.error('[PushNotifications] Failed to unsubscribe:', error);
    return false;
  }
}

/**
 * Check if user is subscribed
 */
export async function isSubscribed() {
  if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
    return false;
  }

  try {
    const registration = await navigator.serviceWorker.ready;
    const subscription = await registration.pushManager.getSubscription();
    return subscription !== null;
  } catch (error) {
    console.error('[PushNotifications] Failed to check subscription:', error);
    return false;
  }
}

/**
 * Get current subscription
 */
export async function getSubscription() {
  if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
    return null;
  }

  try {
    const registration = await navigator.serviceWorker.ready;
    return await registration.pushManager.getSubscription();
  } catch (error) {
    console.error('[PushNotifications] Failed to get subscription:', error);
    return null;
  }
}

/**
 * Send subscription to backend
 */
async function sendSubscriptionToBackend(subscription) {
  try {
    const response = await fetch('/api/v1/push-subscriptions', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      credentials: 'include',
      body: JSON.stringify({
        endpoint: subscription.endpoint,
        keys: {
          p256dh: arrayBufferToBase64(subscription.getKey('p256dh')),
          auth: arrayBufferToBase64(subscription.getKey('auth')),
        },
      }),
    });

    if (!response.ok) {
      throw new Error('Failed to save subscription to backend');
    }

    console.log('[PushNotifications] Subscription saved to backend');
  } catch (error) {
    console.error('[PushNotifications] Failed to save subscription:', error);
  }
}

/**
 * Remove subscription from backend
 */
async function removeSubscriptionFromBackend(subscription) {
  try {
    const response = await fetch('/api/v1/push-subscriptions', {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      credentials: 'include',
      body: JSON.stringify({
        endpoint: subscription.endpoint,
      }),
    });

    if (!response.ok) {
      throw new Error('Failed to remove subscription from backend');
    }

    console.log('[PushNotifications] Subscription removed from backend');
  } catch (error) {
    console.error('[PushNotifications] Failed to remove subscription:', error);
  }
}

/**
 * Convert VAPID key from URL-safe base64 to Uint8Array
 */
function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
  const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }

  return outputArray;
}

/**
 * Convert ArrayBuffer to base64
 */
function arrayBufferToBase64(buffer) {
  const bytes = new Uint8Array(buffer);
  let binary = '';
  for (let i = 0; i < bytes.byteLength; i++) {
    binary += String.fromCharCode(bytes[i]);
  }
  return window.btoa(binary);
}
