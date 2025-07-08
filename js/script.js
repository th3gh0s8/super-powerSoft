const chatbox = jQuery.noConflict();

chatbox(() => {
    // ========================
    // Chatbox UI controls
    // ========================
    chatbox(".chatbox-open").click(() => {
        chatbox(".chatbox-popup").show().attr("aria-hidden", "false");
        chatbox(".chatbox-close").show().attr("aria-hidden", "false");
        chatbox(".chatbox-open").hide();
    });

    chatbox(".chatbox-close").click(() => {
        chatbox(".chatbox-popup").hide().attr("aria-hidden", "true");
        chatbox(".chatbox-close").hide().attr("aria-hidden", "true");
        chatbox(".chatbox-open").show();
    });

    chatbox(".chatbox-maximize").click(() => {
        chatbox(".chatbox-popup, .chatbox-open, .chatbox-close").hide();
        chatbox(".chatbox-panel").css("display", "flex").show();
    });

    chatbox(".chatbox-minimize").click(() => {
        chatbox(".chatbox-panel").hide();
        chatbox(".chatbox-popup, .chatbox-open, .chatbox-close").show();
    });

    chatbox(".chatbox-panel-close").click(() => {
        chatbox(".chatbox-panel").hide();
        chatbox(".chatbox-open").show();
    });

    // ========================
    // Progress bar logic
    // ========================
    function updateProgress(container) {
        const $subTasks = container.find(".sub-task"); // 👈 Only count subtasks
        const totalSubTasks = $subTasks.length;
        const completedSubTasks = $subTasks.filter(":checked").length;

        container.find(".tasks h2").text(
            `Tasks (${completedSubTasks}/${totalSubTasks} completed)`,
        );

        $subTasks.filter(":checked").prop("disabled", true);

        container.find(".setup-progress").attr("max", totalSubTasks).val(
            completedSubTasks,
        );
        container.find(".progress-text").text(
            `${completedSubTasks} of ${totalSubTasks} steps`,
        );
    }

    // ========================
    // Checkbox syncing (dynamic)
    // ========================
    chatbox(document).on("change", ".task-checkbox", function() {
        const isPopup = chatbox(this).closest(".chatbox-popup").length > 0;
        const otherContainer = isPopup
            ? chatbox(".chatbox-panel")
            : chatbox(".chatbox-popup");
        const index = chatbox(".task-checkbox").index(this);

        otherContainer.find(".task-checkbox").eq(index).prop(
            "checked",
            this.checked,
        );

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    // Parent task controls subtasks
    chatbox(document).on("change", ".parent-task", function() {
        const $this = chatbox(this);

        // 🔒 If parent is locked, stop
        if ($this.prop("disabled")) {
            this.checked = true; // Keep it checked visually
            return;
        }

        const parentId = this.id;
        const isChecked = this.checked;

        // Check/uncheck and lock/unlock all subtasks
        const $subTasks = chatbox(`.sub-task[data-parent="${parentId}"]`);
        $subTasks.prop("checked", isChecked);

        if (isChecked) {
            // ✅ Lock subtasks and parent
            $subTasks.prop("disabled", true);
            $this.prop("disabled", true);
        } else {
            // 🔓 Unlock subtasks and parent
            $subTasks.prop("disabled", false);
        }

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    // Subtasks update parent task
    chatbox(document).on("change", ".sub-task", function() {
        const parentId = chatbox(this).data("parent");
        const $siblings = chatbox(`.sub-task[data-parent="${parentId}"]`);
        const allChecked =
            $siblings.length === $siblings.filter(":checked").length;

        const $parent = chatbox(`#${parentId}`);
        $parent.prop("checked", allChecked);

        // 🔒 Lock parent if all subtasks completed
        if (allChecked) {
            $parent.prop("disabled", true);
        }

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    // ========================
    // Insert template content and initialize progress
    // ========================
    const template = document.querySelector("#task-template");

    if (template) {
        const popupContent = template.content.cloneNode(true);
        chatbox(".chatbox-popup").append(popupContent);

        const panelContent = template.content.cloneNode(true);
        chatbox(".chatbox-panel").append(panelContent);

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    }
});
