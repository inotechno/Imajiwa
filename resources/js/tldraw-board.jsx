import React from "react";
import { createRoot } from "react-dom/client";
import "@tldraw/tldraw/tldraw.css";
import { Tldraw } from "@tldraw/tldraw";

document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("tldraw-root");

    if (el && !el._root) {
        const root = createRoot(el);
        root.render(<Tldraw options={{ locale: "en" }} />);
        el._root = root;
    }
});
