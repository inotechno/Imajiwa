import React, { useMemo, memo, useRef, useEffect, useState } from "react";
import { createRoot } from "react-dom/client";
import { Tldraw } from "tldraw";
import { useSync } from "@tldraw/sync";
import "tldraw/tldraw.css";

// Disable HMR
if (import.meta.hot) {
    import.meta.hot.accept(() => {});
}

// Configuration
const SYNC_SERVER_URL = import.meta.env.VITE_TLDRAW_SYNC_URL || 'wss://socket.imajiwa.id';
const HTTP_SERVER_URL = SYNC_SERVER_URL.replace('ws://', 'http://').replace('wss://', 'https://');

// Store reference to prevent unmount issues
let globalStoreRef = null;
let globalProjectId = null;

function TldrawBoardWrapper({ projectId, userId, userName }) {
    const mountedRef = useRef(true);
    const [ready, setReady] = useState(false);
    
    // Stable URI - Reverted to prevent reconnection loops on prop changes
    const uri = useMemo(() => {
        console.log('[TLDRAW] Creating URI for project:', projectId);
        return `${SYNC_SERVER_URL}/connect/${projectId}`;
    }, [projectId]);
    
    // Stable assets config
    const assets = useMemo(() => ({
        async upload(asset, file) {
            // Generate a unique ID - asset.id might be undefined or malformed
            const assetId = asset?.id 
                ? asset.id.replace('asset:', '') 
                : `upload_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
            
            console.log('[ASSET] Starting upload:', { assetId, fileName: file.name, fileType: file.type });
            
            try {
                const uploadUrl = `${HTTP_SERVER_URL}/uploads/${assetId}`;
                console.log('[ASSET] Upload URL:', uploadUrl);
                
                const response = await fetch(uploadUrl, {
                    method: 'PUT',
                    body: file,
                    headers: {
                        'Content-Type': file.type || 'application/octet-stream',
                    },
                });
                
                console.log('[ASSET] Response status:', response.status);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('[ASSET] Upload error response:', errorText);
                    throw new Error(`Upload failed: ${response.status} - ${errorText}`);
                }
                
                const resultUrl = `${HTTP_SERVER_URL}/uploads/${assetId}`;
                console.log('[ASSET] Upload successful, returning URL:', resultUrl);
                return resultUrl;
            } catch (error) {
                console.error('[ASSET] Upload failed:', error);
                throw error;
            }
        },
        resolve(asset) {
            console.log('[ASSET] Resolving asset:', asset?.id, 'src:', asset?.props?.src);
            if (asset?.props?.src) return asset.props.src;
            if (asset?.id) {
                const assetId = asset.id.replace('asset:', '');
                const url = `${HTTP_SERVER_URL}/uploads/${assetId}`;
                console.log('[ASSET] Resolved from ID:', url);
                return url;
            }
            console.log('[ASSET] Could not resolve asset');
            return null;
        },
    }), []);

    const store = useSync({
        uri,
        assets,
    });

    // Cache store globally
    useEffect(() => {
        if (store && projectId) {
            globalStoreRef = store;
            globalProjectId = projectId;
        }
    }, [store, projectId]);
    
    // Delayed ready state to prevent flicker
    useEffect(() => {
        const timer = setTimeout(() => {
            if (mountedRef.current) {
                setReady(true);
            }
        }, 100);
        
        return () => {
            mountedRef.current = false;
            clearTimeout(timer);
        };
    }, []);

    // Handle mount - register asset handlers & set user info
    const handleMount = (editor) => {
        console.log('[TLDRAW] Editor mounted');
        
        // Set User Name for Presence
        if (userName) {
            console.log('[TLDRAW] Setting user name:', userName);
            editor.user.updateUserPreferences({
                name: userName,
            });
        }

        // Register external asset handler for file uploads
        editor.registerExternalAssetHandler('file', async ({ file }) => {
            const assetId = `upload_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
            console.log('[ASSET] Handling file upload:', { assetId, fileName: file.name, fileType: file.type, fileSize: file.size });
            
            try {
                const uploadUrl = `${HTTP_SERVER_URL}/uploads/${assetId}`;
                console.log('[ASSET] Uploading to:', uploadUrl);
                
                const response = await fetch(uploadUrl, {
                    method: 'PUT',
                    body: file,
                    headers: {
                        'Content-Type': file.type || 'application/octet-stream',
                    },
                });
                
                console.log('[ASSET] Upload response status:', response.status);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('[ASSET] Upload failed:', errorText);
                    throw new Error(`Upload failed: ${response.status}`);
                }
                
                const src = `${HTTP_SERVER_URL}/uploads/${assetId}`;
                console.log('[ASSET] Upload successful, src:', src);
                
                // Get image dimensions
                let w = 500, h = 500;
                if (file.type.startsWith('image/')) {
                    try {
                        const img = await new Promise((resolve, reject) => {
                            const image = new Image();
                            image.onload = () => resolve(image);
                            image.onerror = reject;
                            image.src = URL.createObjectURL(file);
                        });
                        w = img.width;
                        h = img.height;
                        URL.revokeObjectURL(img.src);
                    } catch (e) {
                        console.warn('[ASSET] Could not get image dimensions:', e);
                    }
                }
                
                return {
                    id: `asset:${assetId}`,
                    type: 'image',
                    typeName: 'asset',
                    props: {
                        name: file.name,
                        src: src,  // This is critical!
                        w,
                        h,
                        mimeType: file.type || 'application/octet-stream',
                        isAnimated: file.type === 'image/gif',
                    },
                    meta: {},
                };
            } catch (error) {
                console.error('[ASSET] Upload error:', error);
                throw error;
            }
        });
        
        // Register URL handler (for pasting URLs)
        editor.registerExternalAssetHandler('url', async ({ url }) => {
            console.log('[ASSET] Handling URL:', url);
            return {
                id: `asset:url_${Date.now()}`,
                type: 'bookmark',
                typeName: 'asset',
                props: {
                    src: url,
                    title: '',
                    description: '',
                    image: '',
                    favicon: '',
                },
                meta: {},
            };
        });
    };

    return (
        <div style={{ position: 'absolute', inset: 0, width: '100%', height: '100%' }}>
            <Tldraw 
                store={store}
                onMount={handleMount}
            />
        </div>
    );
}

// Use React.memo to prevent unnecessary rerenders
const MemoizedTldrawBoard = memo(TldrawBoardWrapper);

// Mount only once
let rootInstance = null;

function mountTldraw() {
    // Strict singleton check
    if (window.__TLDRAW_MOUNTED__) {
        console.log('[TLDRAW] Already mounted (singleton check)');
        return;
    }
    
    // Prevent concurrent mounting attempts
    if (window.__TLDRAW_MOUNTING__) {
        console.log('[TLDRAW] Mount already in progress');
        return;
    }
    window.__TLDRAW_MOUNTING__ = true;
    
    const container = document.getElementById('tldraw-root');
    if (!container) {
        console.warn('[TLDRAW] Container not found, aborting mount');
        window.__TLDRAW_MOUNTING__ = false;
        return;
    }

    let props = {};
    try {
        props = JSON.parse(container.dataset.props || '{}');
    } catch (e) {
        console.error('[TLDRAW] Props parse error:', e);
    }

    console.log('[TLDRAW] Mounting with projectId:', props.projectId, 'user:', props.userName);
    
    try {
        rootInstance = createRoot(container);
        rootInstance.render(
            <MemoizedTldrawBoard 
                projectId={props.projectId || 'default'}
                userId={props.userId}
                userName={props.userName || 'Guest'}
            />
        );
        window.__TLDRAW_MOUNTED__ = true;
    } catch (error) {
        console.error('[TLDRAW] Mount failed:', error);
    } finally {
        window.__TLDRAW_MOUNTING__ = false;
    }
}

// Initial mount check
if (!window.__TLDRAW_MOUNTED__) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', mountTldraw);
    } else {
        mountTldraw();
    }
}

export default MemoizedTldrawBoard;
