/**
 * Loads the list of provinces from the API into the select box if there is a
 * country picker and date picker on the same page.
 *
 * @param event
 */
async function loadProvincesIntoSelect(event) {
    // Make sure there is a province picker before loading provinces
    const provincePicker = window.$('.provincepicker');
    if (provincePicker.length) {
        // Get the sub-select box
        const provinceSelect = window.$('select', provincePicker);

        // Load the data from the API
        const { data } = await window.axios.get(`/api/countries/${event.target.value}`);

        // Handle logic around the results being empty
        const isResultsEmpty = !Object.keys(data).length;
        provinceSelect.prop('disabled', isResultsEmpty);
        if (isResultsEmpty) {
            provincePicker.selectpicker('refresh');
            return;
        }

        // Clear the options, add the provinces to the select input
        provinceSelect.empty();
        for (const value in data) {
            provinceSelect.append(new Option(data[value], value));
        }

        // Set the existing value if available
        const existingValue = window.$('input[name="_province"]');
        if (existingValue.length) {
            provinceSelect.val(existingValue.val());
        }

        // Refresh the select box to reflect the new options
        provincePicker.selectpicker('refresh');
    }
}

window.$('.countrypicker').on('changed.bs.select', loadProvincesIntoSelect);
window.$('.countrypicker').on('loaded.bs.select', loadProvincesIntoSelect);
