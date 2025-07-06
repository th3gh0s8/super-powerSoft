const chatbox = jQuery.noConflict();

chatbox(() => {
    // ========================
    // Chatbox UI controls
    // ========================
    // Open popup: show popup + close button, hide open button
    // Open popup
    chatbox(".chatbox-open").click(() => {
        chatbox(".chatbox-popup").show().attr("aria-hidden", "false");
        chatbox(".chatbox-close").show().attr("aria-hidden", "false");
        chatbox(".chatbox-open").hide();
    });

    // Close popup
    chatbox(".chatbox-close").click(() => {
        chatbox(".chatbox-popup").hide().attr("aria-hidden", "true");
        chatbox(".chatbox-close").hide().attr("aria-hidden", "true");
        chatbox(".chatbox-open").show();
    });

    // Maximize to full-screen panel
    chatbox(".chatbox-maximize").click(() => {
        chatbox(".chatbox-popup, .chatbox-open, .chatbox-close").hide();
        chatbox(".chatbox-panel").css("display", "flex").show();
    });

    // Minimize back to popup
    chatbox(".chatbox-minimize").click(() => {
        chatbox(".chatbox-panel").hide();
        chatbox(".chatbox-popup, .chatbox-open, .chatbox-close").show();
    });

    // Close full-screen panel
    chatbox(".chatbox-panel-close").click(() => {
        chatbox(".chatbox-panel").hide();
        chatbox(".chatbox-open").show();
    });

    // ========================
    // Progress bar logic
    // ========================

    function updateProgress() {
        const $popupTasks = chatbox(".chatbox-popup .task-checkbox");
        const $panelTasks = chatbox(".chatbox-panel .task-checkbox");

        const totalTasks = Math.max($popupTasks.length, $panelTasks.length);
        const completed = $popupTasks.filter(":checked").length;

        // Update progress bars max and value
        chatbox(".chatbox-popup .setup-progress").attr("max", totalTasks).val(
            completed,
        );
        chatbox(".chatbox-panel .setup-progress").attr("max", totalTasks).val(
            completed,
        );

        // Update progress text
        chatbox(".chatbox-popup .progress-text").text(
            `${completed} of ${totalTasks} steps`,
        );
        chatbox(".chatbox-panel .progress-text").text(
            `${completed} of ${totalTasks} steps`,
        );
    }

    // ========================
    // Checkbox syncing (dynamic)
    // ========================

    // Sync from popup -> panel
    chatbox(document).on(
        "change",
        ".chatbox-popup .task-checkbox",
        function() {
            const $popupTasks = chatbox(".chatbox-popup .task-checkbox");
            const $panelTasks = chatbox(".chatbox-panel .task-checkbox");

            const index = $popupTasks.index(this);
            const checked = this.checked;

            if ($panelTasks.eq(index).length) {
                $panelTasks.eq(index).prop("checked", checked);
            }

            updateProgress();
        },
    );

    // Sync from panel -> popup
    chatbox(document).on(
        "change",
        ".chatbox-panel .task-checkbox",
        function() {
            const $popupTasks = chatbox(".chatbox-popup .task-checkbox");
            const $panelTasks = chatbox(".chatbox-panel .task-checkbox");

            const index = $panelTasks.index(this);
            const checked = this.checked;

            if ($popupTasks.eq(index).length) {
                $popupTasks.eq(index).prop("checked", checked);
            }

            updateProgress();
        },
    );

    // ========================
    // Global click handling
    // ========================

    // Prevent clicks inside chatbox from closing it
    chatbox(".chatbox-popup, .chatbox-panel").on(
        "click",
        (e) => e.stopPropagation(),
    );

    // Prevent clicks on control buttons from bubbling up
    chatbox(
        ".chatbox-open, .chatbox-close, .chatbox-maximize, .chatbox-minimize, .chatbox-panel-close",
    ).on(
        "click",
        (e) => e.stopPropagation(),
    );

    // Close/minimize chatbox on outside click
    chatbox(document).on("click", function(e) {
        const $target = chatbox(e.target);

        if (
            chatbox(".chatbox-popup").is(":visible") ||
            chatbox(".chatbox-panel").is(":visible")
        ) {
            if (
                !$target.closest(".chatbox-popup, .chatbox-panel").length &&
                !$target.is(
                    ".chatbox-open, .chatbox-close, .chatbox-maximize, .chatbox-minimize, .chatbox-panel-close",
                )
            ) {
                chatbox(".chatbox-popup, .chatbox-panel, .chatbox-close")
                    .fadeOut();
                chatbox(".chatbox-open").fadeIn();
            }
        }
    });

    // Close chatbox with Escape key
    chatbox(document).on("keydown", function(e) {
        if (e.key === "Escape") {
            chatbox(".chatbox-popup, .chatbox-panel, .chatbox-close").fadeOut();
            chatbox(".chatbox-open").fadeIn();
        }
    });

    // ========================
    // Initialize progress on load
    // ========================
    updateProgress();
});
