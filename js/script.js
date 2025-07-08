const chatbox = jQuery.noConflict();

chatbox(() => {
    // ========================

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

        // Update progress text and bar in the current container only
        container.find(".tasks h2").text(
            `Tasks (${completed}/${totalTasks} completed)`,
        );
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
    chatbox(document).on("change", ".task-checkbox", function() {
        const isPopup = chatbox(this).closest(".chatbox-popup").length > 0;
        const otherContainer = isPopup
            ? chatbox(".chatbox-panel")
            : chatbox(".chatbox-popup");
        const $this = chatbox(this);
        const index = chatbox(".task-checkbox").index(this);

        otherContainer.find(".task-checkbox").eq(index).prop(
            "checked",
            this.checked,
        );

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    // Sync from panel -> popup and update progress in both containers
    // Parent checkbox checks/unchecks all subtasks
    chatbox(document).on("change", ".parent-task", function() {
        const parentId = this.id;
        const isChecked = this.checked;

        chatbox(`.sub-task[data-parent="${parentId}"]`).prop(
            "checked",
            isChecked,
        );
        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    // Subtask auto-check parent if all are checked
    chatbox(document).on("change", ".sub-task", function() {
        const parentId = chatbox(this).data("parent");
        const $siblings = chatbox(`.sub-task[data-parent="${parentId}"]`);
        const allChecked =
            $siblings.length === $siblings.filter(":checked").length;

        chatbox(`#${parentId}`).prop("checked", allChecked);
        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    const template = document.querySelector("#task-template");

    if (template) {
        // Clone and insert into popup
        const popupContent = template.content.cloneNode(true);
        chatbox(".chatbox-popup").append(popupContent);

        // Clone and insert into panel
        const panelContent = template.content.cloneNode(true);
        chatbox(".chatbox-panel").append(panelContent);

        // Initialize progress immediately for both
        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    }
    // Parent task controls subtasks
    chatbox(document).on("change", ".parent-task", function() {
        const parentId = this.id;
        const isChecked = this.checked;

        chatbox(`.sub-task[data-parent="${parentId}"]`).prop(
            "checked",
            isChecked,
        );

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    // Subtasks update parent task
    chatbox(document).on("change", ".sub-task", function() {
        const parentId = chatbox(this).data("parent");
        const $siblings = chatbox(`.sub-task[data-parent="${parentId}"]`);
        const allChecked =
            $siblings.length === $siblings.filter(":checked").length;

        chatbox(`#${parentId}`).prop("checked", allChecked);

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });
});
