import React from "react";
import ReactDOM from "react-dom/client";
import { Tldraw } from "@tldraw/tldraw";
import "@tldraw/tldraw/tldraw.css";

document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("whiteboard");
    if (!el) return;

    const boardData = JSON.parse(el.dataset.canvas ?? "{}");
    const root = ReactDOM.createRoot(el);
    root.render(<WhiteboardApp initialData={boardData} />);
});

function WhiteboardApp({ initialData }) {
    const handleMount = (editor) => {
        // ✅ Restore data sebelumnya
        try {
            if (initialData && Object.keys(initialData).length > 0) {
                editor.store.loadSnapshot(initialData);
            }
        } catch (err) {
            console.warn("Failed to restore board:", err);
        }

        // ✅ Auto-save tiap 10 detik
        setInterval(() => {
            try {
                const snapshot = editor.store.getStoreSnapshot(); // ✅ FIX di sini
                Livewire.dispatch("saveBoardSnapshot", snapshot);
            } catch (e) {
                console.warn("Failed to save board snapshot:", e);
            }
        }, 10000);
    };

    return (
        <div style={{ width: "100%", height: "100%" }}>
            <Tldraw
                inferLicense={false}
                showMultiplayerMenu={false}
                hideUi={false}
                persistenceKey="imajiwa-whiteboard"
                onMount={handleMount}
            />
        </div>
    );
}
