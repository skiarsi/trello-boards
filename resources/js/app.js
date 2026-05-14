import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

if (window.authUserId) {
    window.Echo = new Echo({
        broadcaster: "reverb",
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: import.meta.env.VITE_REVERB_PORT,
        wssPort: import.meta.env.VITE_REVERB_PORT,
        forceTLS: false,
        enabledTransports: ["ws", "wss"],
    });

    window.Echo.private(`App.Models.User.${window.authUserId}`).notification(
        (notification) => {
            // ─── Board notifications ───────────────────────────────────
            if (notification.toast_type === "boardUpdate") {
                window.Livewire.dispatch("board-updated");

                if (notification.action === "archived") {
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 1500);
                }
            }

            // ─── Member notifications ──────────────────────────────────
            if (notification.toast_type === "inviteMember") {
                window.Livewire.dispatch("member-updated");
                window.Livewire.dispatch("show_toast", {
                    type: notification.toast_type,
                    message: notification.message,
                    url: notification.url,
                    board_slug: notification.board_slug,
                    board_id: notification.board_id,
                    was_pending: notification.was_pending,
                });
            }

            if (notification.toast_type === "removeMember") {
                window.Livewire.dispatch("member-updated");
                const currentPath = window.location.pathname;
                const boardPath = `/board/${notification.board_slug}`;
                if (currentPath === boardPath) {
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 2000);
                }
            }

            // ─── List notifications ────────────────────────────────────
            if (notification.action === "create_list") {
                window.Livewire.dispatch("list-created", {
                    list_id: notification.list_id,
                    list_slug: notification.list_slug,
                    board_slug: notification.board_slug,
                });
            }
        },
    );
}
