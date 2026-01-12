import "./bootstrap";

// Tldraw Sync now uses its own WebSocket connection via @tldraw/sync
// Laravel Echo/Pusher is no longer needed for board sync
console.log("App initialized (Tldraw Sync mode)");

import "./tldraw-board.jsx";
