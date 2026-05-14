import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

// فقط اگر کاربر لاگین کرده Echo رو راه‌اندازی کن
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
            window.Livewire.dispatch("board-updated");
            window.Livewire.dispatch("member-updated");

            // show toast for member join/remove
            if (notification.toast_type === "inviteMember") {
                window.Livewire.dispatch("show_toast", {
                    type: notification.toast_type,
                    message: notification.message,
                    url: notification.url,
                    board_slug: notification.board_slug,
                    board_id: notification.board_id,
                    was_pending: notification.was_pending,
                });
            }

            // redirect user if its removed from a board
            if (notification.toast_type === "removeMember") {
                const currentPath = window.location.pathname;
                const boardPath = `/board/${notification.board_slug}`;
                if (currentPath === boardPath) {
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 2000);
                }
            }

            // update board
            if (
                notification.toast_type === "boardUpdate" &&
                notification.action === "archived"
            ) {
                // redirect user to index for archive
                setTimeout(() => {
                    window.location.href = "/";
                }, 1500);
            }
        },
    );
}
