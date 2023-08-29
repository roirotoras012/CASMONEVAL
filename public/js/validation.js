$(document).ready(function() {
    // Loop through each modal
    $('[id^="measure_modal-"]').each(function() {
        const modalId = this.id;
        const measureNumberSelect = $('#' + modalId + ' #measure_numbers');
        const strategicMeasureTextarea = $('#' + modalId + ' #add_measure');
        const addObjectiveButton = $('#' + modalId + ' #addMeasureButton');

        // Disable the button initially
        addObjectiveButton.prop('disabled', true);

        // Update button state based on input fields
        function updateButtonState() {
            if (measureNumberSelect.val() !== '' && strategicMeasureTextarea.val().trim() !== '') {
                addObjectiveButton.prop('disabled', false);
            } else {
                addObjectiveButton.prop('disabled', true);
            }
        }

        // Add event listeners to input fields
        measureNumberSelect.on('change', updateButtonState);
        strategicMeasureTextarea.on('input', updateButtonState);

        // Handle form submission
        $('#' + modalId).on('submit', function(event) {
            event.preventDefault();

            // Disable the submit button
            const button = $(this).find('[type="submit"]');
            button.prop('disabled', true);

            // Submit the form
            this.submit();
        });
    });
});