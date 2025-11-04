import React, { useEffect, useRef } from "react";
import { createRoot } from "react-dom/client";
import { Tldraw } from "@tldraw/tldraw";
import "@tldraw/tldraw/tldraw.css";

export default function WhiteboardApp({
    boardId,
    initialSnapshot,
    saveSnapshotUrl,
}) {
    const editorRef = useRef(null);
    let saveTimeout = null;

    // ✅ Auto-save (debounce 1 detik)
    const handleSave = (editor) => {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            try {
                const snapshot = editor.store.serialize(); // ✅ tetap berlaku di v4
                if (window.Livewire && saveSnapshotUrl) {
                    window.Livewire.find(saveSnapshotUrl)?.call(
                        "saveBoardSnapshot",
                        snapshot
                    );
                }
            } catch (err) {
                console.error("Error saving snapshot:", err);
            }
        }, 1000);
    };

    // ✅ Listen broadcast realtime
    useEffect(() => {
        if (!window.Echo) return;
        const channel = window.Echo.private(`whiteboard.${boardId}`).listen(
            ".WhiteboardUpdated",
            (e) => {
                if (editorRef.current && e.userId !== window.Laravel?.userId) {
                    try {
                        // ✅ v4 tidak pakai loadSnapshot, gunakan replaceAllRecords
                        const data = e.snapshot;
                        if (data && data.records) {
                            editorRef.current.store.clear(); // bersihkan dulu
                            editorRef.current.store.put(data.records); // lalu isi ulang
                        }
                    } catch (err) {
                        console.warn("Snapshot sync error:", err);
                    }
                }
            }
        );
        return () => channel.stopListening(".WhiteboardUpdated");
    }, [boardId]);

    return (
        <div style={{ width: "100%", height: "100vh", background: "#fff" }}>
            <Tldraw
                onMount={(editor) => {
                    editorRef.current = editor;

                    // ✅ v4: load snapshot manual
                    if (initialSnapshot && initialSnapshot.records) {
                        try {
                            editor.store.clear();
                            editor.store.put(initialSnapshot.records);
                        } catch (err) {
                            console.warn("Initial load error:", err);
                        }
                    }

                    // ✅ Dengarkan perubahan user dan simpan otomatis
                    editor.store.listen(() => handleSave(editor), {
                        source: "user",
                    });
                }}
            />
        </div>
    );
}

// ✅ Pastikan createRoot hanya dipanggil sekali
document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("whiteboard-container");
    if (!el) return;

    // Cek apakah sudah pernah di-mount
    if (el._tldrawMounted) return;
    el._tldrawMounted = true;

    const props = JSON.parse(el.dataset.props);
    const root = createRoot(el);
    root.render(<WhiteboardApp {...props} />);
});
