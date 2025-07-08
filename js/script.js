const chatbox = jQuery.noConflict();

let ytPlayer; // 👈 Move outside chatbox scope so YouTube API can call it

// ✅ Global YouTube API callback
function onYouTubeIframeAPIReady() {
    ytPlayer = new YT.Player("yt-player", {
        height: "360",
        width: "640",
        videoId: "dQw4w9WgXcQ", // Initial video
        events: {
            onReady: (event) => {
                console.log("YouTube Player Ready!");
            },
        },
    });
}

chatbox(() => {
    function loadTutorial(videoId) {
        if (ytPlayer && ytPlayer.loadVideoById) {
            ytPlayer.loadVideoById(videoId);
        }
    }

    // ========================
    // Chatbox UI controls
    // ========================
    chatbox(".chatbox-open").click(() => {
        chatbox(".chatbox-popup").show().attr("aria-hidden", "false");
        chatbox(".chatbox-close").show().attr("aria-hidden", "false");
        chatbox(".chatbox-open").hide();

        loadTutorial("dQw4w9WgXcQ"); //  Load the video each time
    });

    chatbox(".chatbox-close").click(() => {
        chatbox(".chatbox-popup").hide().attr("aria-hidden", "true");
        chatbox(".chatbox-close").hide().attr("aria-hidden", "true");
        chatbox(".chatbox-open").show();

        if (ytPlayer && ytPlayer.stopVideo) ytPlayer.stopVideo(); //  Stop video when closing
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

    chatbox(document).keydown((e) => {
        if (e.key === "Escape") {
            chatbox(".chatbox-popup, .chatbox-close").fadeOut();
            chatbox(".chatbox-open").fadeIn();
        }
    });

    chatbox(document).mouseup((e) => {
        const popup = chatbox(".chatbox-popup");
        if (!popup.is(e.target) && popup.has(e.target).length === 0) {
            popup.fadeOut();
            chatbox(".chatbox-open").fadeIn();
        }
    });

    // ========================
    // Progress bar logic
    // ========================
    function syncParents(container) {
        container.find(".parent-task").each(function() {
            const parentId = this.id;
            const $subTasks = container.find(
                `.sub-task[data-parent="${parentId}"]`,
            );
            const allChecked = $subTasks.length > 0 &&
                $subTasks.length === $subTasks.filter(":checked").length;
            chatbox(this).prop("checked", allChecked);

            // 🔒 Lock parent if all subtasks are done
            chatbox(this).prop("disabled", allChecked);
        });
    }

    function updateProgress(container) {
        const $subTasks = container.find(".sub-task");
        const $standaloneTasks = container.find(".standalone");

        const totalTasks = $subTasks.length + $standaloneTasks.length;
        const completedTasks = $subTasks.filter(":checked").length +
            $standaloneTasks.filter(":checked").length;

        container.find(".tasks h2").text(
            `Tasks (${completedTasks}/${totalTasks} completed)`,
        );

        $subTasks.filter(":checked").prop("disabled", true);
        $standaloneTasks.filter(":checked").prop("disabled", true);

        container.find(".setup-progress").attr("max", totalTasks).val(
            completedTasks,
        );
        container.find(".progress-text").text(
            `${completedTasks} of ${totalTasks} steps`,
        );

        syncParents(container);
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

    // ========================
    // Toggle subtasks visibility
    // ========================
    chatbox(document).on("click", ".parent-task + label", function() {
        const $parentLi = chatbox(this).closest("li");
        $parentLi.toggleClass("expanded");
    });

    // Auto expand if parent checked
    chatbox(document).on("change", ".parent-task", function() {
        const $parentLi = chatbox(this).closest("li");
        if (this.checked) {
            $parentLi.addClass("expanded");
        } else {
            $parentLi.removeClass("expanded");
        }
    });

    chatbox(document).on("change", ".parent-task", function() {
        const $this = chatbox(this);
        if ($this.prop("disabled")) {
            this.checked = true;
            return;
        }

        const parentId = this.id;
        const isChecked = this.checked;
        const $subTasks = chatbox(`.sub-task[data-parent="${parentId}"]`);
        $subTasks.prop("checked", isChecked).prop("disabled", isChecked);

        if (isChecked) $this.prop("disabled", true);

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    chatbox(document).on("change", ".sub-task", function() {
        const parentId = chatbox(this).data("parent");
        const $siblings = chatbox(`.sub-task[data-parent="${parentId}"]`);
        const allChecked =
            $siblings.length === $siblings.filter(":checked").length;

        const $parent = chatbox(`#${parentId}`);
        $parent.prop("checked", allChecked);
        if (allChecked) $parent.prop("disabled", true);

        updateProgress(chatbox(".chatbox-popup"));
        updateProgress(chatbox(".chatbox-panel"));
    });

    // ========================
    // Insert template content
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
