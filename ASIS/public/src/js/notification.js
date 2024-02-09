import Toastify from "toastify-js";

(function () {
    "use strict";

    // Basic non sticky adminNotification
    $("#basic-non-sticky-adminNotification-toggle").on("click", function () {
        Toastify({
            node: $("#basic-non-sticky-adminNotification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Basic sticky adminNotification
    $("#basic-sticky-adminNotification-toggle").on("click", function () {
        Toastify({
            node: $("#basic-non-sticky-adminNotification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Success adminNotification
    $("#success-adminNotification-toggle").on("click", function () {
        Toastify({
            node: $("#success-adminNotification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Notification with actions
    $("#adminNotification-with-actions-toggle").on("click", function () {
        Toastify({
            node: $("#adminNotification-with-actions-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Notification with avatar
    $("#adminNotification-with-avatar-toggle").on("click", function () {
        // Init toastify
        let avatarNotification = Toastify({
            node: $("#adminNotification-with-avatar-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: false,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();

        // Close adminNotification event
        $(avatarNotification.toastElement)
            .find('[data-dismiss="adminNotification"]')
            .on("click", function () {
                avatarNotification.hideToast();
            });
    });

    // Notification with split buttons
    $("#adminNotification-with-split-buttons-toggle").on("click", function () {
        // Init toastify
        let splitButtonsNotification = Toastify({
            node: $("#adminNotification-with-split-buttons-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: false,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();

        // Close adminNotification event
        $(splitButtonsNotification.toastElement)
            .find('[data-dismiss="adminNotification"]')
            .on("click", function () {
                splitButtonsNotification.hideToast();
            });
    });

    // Notification with buttons below
    $("#adminNotification-with-buttons-below-toggle").on("click", function () {
        // Init toastify
        Toastify({
            node: $("#adminNotification-with-buttons-below-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });
})();
