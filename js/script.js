const chatbox = jQuery.noConflict();

chatbox(() => {
    // Chatbox UI controls
    chatbox(".chatbox-open").click(() => {
        chatbox(".chatbox-popup, .chatbox-close").fadeIn();
        chatbox(".chatbox-open").hide(); // hide open button
    });

    chatbox(".chatbox-close").click(() => {
        chatbox(".chatbox-popup, .chatbox-close").fadeOut();
        chatbox(".chatbox-open").fadeIn(); // bring back open button
    });

    chatbox(".chatbox-maximize").click(() => {
        chatbox(".chatbox-popup, .chatbox-open, .chatbox-close").fadeOut();
        chatbox(".chatbox-panel").css("display", "flex").hide().fadeIn();
    });

    chatbox(".chatbox-minimize").click(() => {
        chatbox(".chatbox-panel").fadeOut(() => {
            chatbox(".chatbox-popup, .chatbox-open, .chatbox-close").fadeIn();
        });
    });

    chatbox(".chatbox-panel-close").click(() => {
        chatbox(".chatbox-panel").fadeOut(() => {
            chatbox(".chatbox-open").fadeIn();
        });
    });

    chatbox(".chatbox-open").click(() => {
        chatbox(".chatbox-popup").fadeIn();
        chatbox(".chatbox-open").hide();
        chatbox(".chatbox-close").addClass("active");
    });

    chatbox(".chatbox-close").click(() => {
        chatbox(".chatbox-popup").fadeOut();
        chatbox(".chatbox-open").fadeIn();
        chatbox(".chatbox-close").removeClass("active");
    });

    // Select checkboxes in both popup and panel
    const $popupTasks = chatbox(".chatbox-popup .task-checkbox");
    const $panelTasks = chatbox(".chatbox-panel .task-checkbox");

    // Total tasks (assumes both lists are the same)
    const totalTasks = $popupTasks.length;

    function updateProgress() {
        const completed = $popupTasks.filter(":checked").length;

        // Update both popup and panel progress bars
        chatbox(".chatbox-popup #setup-progress").val(completed);
        chatbox(".chatbox-popup #progress-text").text(
            `${completed} of ${totalTasks} steps`,
        );

        chatbox(".chatbox-panel #setup-progress").val(completed);
        chatbox(".chatbox-panel #progress-text").text(
            `${completed} of ${totalTasks} steps`,
        );
    }

    // Sync popup -> panel
    $popupTasks.on("change", function() {
        const index = $popupTasks.index(this);
        const checked = this.checked;
        $panelTasks.eq(index).prop("checked", checked);
        updateProgress();
    });

    // Sync panel -> popup
    $panelTasks.on("change", function() {
        const index = $panelTasks.index(this);
        const checked = this.checked;
        $popupTasks.eq(index).prop("checked", checked);
        updateProgress();
    });

    // Initialize progress bar on page load
    updateProgress();
});
