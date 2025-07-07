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

    function updateProgress(container) {
        const $tasks = container.find(".task-checkbox");
        const totalTasks = $tasks.length;
        const completed = $tasks.filter(":checked").length;

        // Update the tasks header in this container only
        container.find(".tasks h2").text(
            `Tasks (${completed}/${totalTasks} completed)`,
        );

        // Lock checked boxes only here
        $tasks.filter(":checked").prop("disabled", true);

        // Update the progress bar and progress text inside this container
        container.find(".setup-progress").attr("max", totalTasks).val(
            completed,
        );
        container.find(".progress-text").text(
            `${completed} of ${totalTasks} steps`,
        );
    }

    // ========================
    // Checkbox syncing (dynamic)
    // ========================

    // Sync from popup -> panel and update progress in both containers
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
                if (checked) {
                    $panelTasks.eq(index).prop("disabled", true);
                }
            }

            if (checked) {
                chatbox(this).prop("disabled", true);
            }

            updateProgress(chatbox(".chatbox-popup"));
            updateProgress(chatbox(".chatbox-panel"));
        },
    );

    // Sync from panel -> popup and update progress in both containers
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
                if (checked) {
                    $popupTasks.eq(index).prop("disabled", true);
                }
            }

            if (checked) {
                chatbox(this).prop("disabled", true);
            }

            updateProgress(chatbox(".chatbox-popup"));
            updateProgress(chatbox(".chatbox-panel"));
        },
    );
});
