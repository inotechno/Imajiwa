import React, { useEffect, useRef } from "react";
import { createRoot } from "react-dom/client";
import { Tldraw, getSnapshot } from "@tldraw/tldraw";
import "@tldraw/tldraw/tldraw.css";

export default function WhiteboardApp({
    boardId,
    initialSnapshot,
    saveSnapshotUrl,
}) {
    const editorRef = useRef(null);
    let saveTimeout;

    /** 🧩 Auto Save dengan debounce */
    function handleSave(editor, saveSnapshotUrl) {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            const snapshot = getSnapshot(editor.store);
            console.log("🧩 Sending snapshot to Livewire:", snapshot);

            if (window.Livewire && saveSnapshotUrl) {
                const component = window.Livewire.find(saveSnapshotUrl);
                console.log("🎯 Found Livewire component:", component);

                if (component) {
                    component.call("saveBoardSnapshot", snapshot);
                    console.log("📡 Snapshot sent to Livewire.");
                } else {
                    console.warn("⚠️ Komponen Livewire tidak ditemukan!");
                }
            }
        }, 1000);
    }

    /** 🔁 Realtime listener (Laravel Echo) */
    useEffect(() => {
        if (!window.Echo) return;

        const channel = window.Echo.private(`whiteboard.${boardId}`).listen(
            ".WhiteboardUpdated",
            (e) => {
                if (editorRef.current && e.userId !== window.Laravel?.userId) {
                    try {
                        const editor = editorRef.current;
                        const snapshot = normalizeSnapshot(e.snapshot);
                        editor.loadSnapshot(snapshot);
                    } catch (err) {
                        console.warn("⚠️ Snapshot sync error:", err);
                    }
                }
            }
        );

        return () => channel.stopListening(".WhiteboardUpdated");
    }, [boardId]);

    /** 🎨 Render TLDraw */
    return (
        <div style={{ width: "100%", height: "100vh", background: "#fff" }}>
            <Tldraw
                onMount={(editor) => {
                    editorRef.current = editor;

                    // Tunggu editor siap sebelum load snapshot
                    const loadBoard = () => {
                        try {
                            let snapshot = normalizeSnapshot(initialSnapshot);
                            if (!snapshot || !snapshot.records)
                                snapshot = createDefaultSnapshot();

                            // Gunakan API resmi loadSnapshot
                            editor.loadSnapshot(snapshot);

                            // Cek apakah currentPageId valid
                            const instance =
                                editor.store.get("instance:default");
                            if (!instance?.currentPageId) {
                                const pageId = "page:page";
                                const fixedSnapshot = createDefaultSnapshot();
                                editor.loadSnapshot(fixedSnapshot);
                            }

                            // Aktifkan autosave
                            editor.store.listen(() => handleSave(editor)); // ✅ tanpa filter source
                        } catch (err) {
                            console.warn("⚠️ Load snapshot gagal total:", err);
                            const fallback = createDefaultSnapshot();
                            editor.loadSnapshot(fallback);
                        }
                    };

                    // Event onReady lebih aman
                    if (editor.isReady) {
                        loadBoard();
                    } else {
                        editor.on("ready", loadBoard);
                    }
                }}
            />
        </div>
    );
}

/* ===================================================
   🧩 Normalisasi Snapshot (format v3 → v4)
=================================================== */
function normalizeSnapshot(snapshot) {
    try {
        if (!snapshot) return createDefaultSnapshot();

        // Versi baru (v4)
        if (snapshot.records) {
            const records = { ...snapshot.records };
            const pageKeys = Object.keys(records).filter((k) =>
                k.startsWith("page:")
            );
            const firstPageId = pageKeys[0] ?? "page:page";
            ensureBaseRecords(records, firstPageId);
            return { schema: snapshot.schema ?? { schemaVersion: 2 }, records };
        }

        // Versi lama (v3)
        if (snapshot.document?.store) {
            const records = snapshot.document.store;
            const pageKeys = Object.keys(records).filter((k) =>
                k.startsWith("page:")
            );
            const firstPageId = pageKeys[0] ?? "page:page";
            ensureBaseRecords(records, firstPageId);
            return {
                schema: snapshot.document.schema ?? { schemaVersion: 2 },
                records,
            };
        }
    } catch (err) {
        console.warn("⚠️ normalizeSnapshot error:", err);
    }

    return createDefaultSnapshot();
}

/* ===================================================
   🧱 Buat struktur TLDraw minimal agar tidak crash
=================================================== */
function ensureBaseRecords(records, pageId = "page:page") {
    if (!records["document:document"]) {
        records["document:document"] = {
            id: "document:document",
            typeName: "document",
            name: "Untitled Document",
            meta: {},
        };
    }

    if (!records[pageId]) {
        records[pageId] = {
            id: pageId,
            typeName: "page",
            name: "Page 1",
            meta: {},
        };
    }

    if (!records["instance:default"]) {
        records["instance:default"] = {
            id: "instance:default",
            typeName: "instance",
            currentPageId: pageId,
            camera: { x: 0, y: 0, z: 1 },
            isFocusMode: false,
            isGridMode: false,
            isToolLocked: false,
            isDebugMode: false,
            exportBackground: true,
            meta: {},
        };
    }

    const pageStateId = `instance_page_state:${pageId}`;
    if (!records[pageStateId]) {
        records[pageStateId] = {
            id: pageStateId,
            typeName: "instance_page_state",
            pageId,
            camera: { x: 0, y: 0, z: 1 },
            editingShapeId: null,
            selectedShapeIds: [],
            meta: {},
        };
    }

    if (!records["instance_presence:default"]) {
        records["instance_presence:default"] = {
            id: "instance_presence:default",
            typeName: "instance_presence",
            userId: "default",
            camera: { x: 0, y: 0, z: 1 },
            meta: {},
        };
    }
}

/* ===================================================
   🧩 Snapshot Default (fallback aman)
=================================================== */
function createDefaultSnapshot() {
    const pageId = "page:page";
    const records = {};
    ensureBaseRecords(records, pageId);
    return { schema: { schemaVersion: 2 }, records };
}

/* ===================================================
   🚀 Mount otomatis
=================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("whiteboard-container");
    if (!el || el._tldrawMounted) return; // ✅ cegah render ulang

    el._tldrawMounted = true; // 🔒 kunci supaya hanya 1x mount

    const waitForProps = setInterval(() => {
        if (el.dataset.props && el.dataset.props !== "undefined") {
            clearInterval(waitForProps);

            try {
                const props = JSON.parse(el.dataset.props);
                console.log("✅ Props diterima di React:", props);
                const root = createRoot(el);
                root.render(<WhiteboardApp {...props} />);
            } catch (err) {
                console.error(
                    "❌ Gagal parse dataset.props:",
                    el.dataset.props,
                    err
                );
            }
        }
    }, 100);
});
