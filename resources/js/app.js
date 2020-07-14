require('./bootstrap');

$('.conditional').conditionize();

$('.conditional-required').conditionize({
    onload: true,
    ifTrue: function(selection) {
        $(selection).attr('required', true);
        $(selection).parent().find('label').append('&nbsp;<span class="required">*</span>');
    },
    ifFalse: function(selection) {
        $(selection).attr('required', false);
        $(selection).parent().find('.required').remove();
    }
});

const ConfirmSwal = Swal.mixin({
    title: 'Are you sure?',
    icon: 'question',
    showCancelButton: true,
    reverseButtons: true,
    focusCancel: true
});

events.on('click', '.btn-delete', function (event) {
    event.preventDefault();

    const row = event.target.closest('tr');
    const url = row.dataset.deleteUrl;
    const section = row.dataset.section;

    ConfirmSwal.fire({
        text: `Do you want to delete this ${section}?`,
        confirmButtonText: `Delete ${section}`,
    }).then((result) => {
        console.log(result);
        
        if (result.value) {
            axios.delete(url).then((response) => {
                console.log(response);
            if (! document.getElementById('with_archived').checked) {
                row.style.background = '#ffebee';
                setTimeout(() => { fadeOut(row); }, 500);

                const indexTable = document.querySelector('.index-table');
                const itemsCount = indexTable.querySelectorAll('tbody > tr').length - 1;
                const itemsVerb = itemsCount === 1 ? 'menu' : 'menus';

                document.querySelector('.itemsCount').innerHTML = itemsCount;
                document.querySelector('.itemsVerb').innerHTML = itemsVerb;
            } else {
                const archivedIndicator = row.querySelector('.icon-sm');
                const deleteButton = row.querySelector('.btn-delete');
                const buttonGroup = row.querySelector('.btn-group');

                archivedIndicator.classList.remove('text-transparent');
                archivedIndicator.classList.add('text-red');

                deleteButton.remove();
                buttonGroup.innerHTML = buttonGroup.innerHTML + '<button type="button" class="btn btn-sm btn-primary btn-restore" title="Restore"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M432 80h-82.4l-34-56.7A48 48 0 0 0 274.4 0H173.6a48 48 0 0 0-41.2 23.3L98.4 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16l21.2 339a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM173.6 48h100.8l19.2 32H154.4zm173.3 416H101.11l-21-336h287.8zM235.61 181.05a15.88 15.88 0 0 0-23.22 0l-80.26 81.75c-8.82 9.3-2.58 25.2 9.9 25.2h50v96a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-96h50c12.48 0 18.72-15.9 9.9-25.2z"></path></svg></button>';
            }
            });
        }
    });
});

events.on('click', '.btn-restore', function (event) {
    event.preventDefault();

    const row = event.target.closest('tr');
    const url = row.dataset.restoreUrl;
    const section = row.dataset.section;

    ConfirmSwal.fire({
        text: `Do you want to restore this ${section}?`,
        confirmButtonText: `Restore ${section}`,
    }).then((result) => {
        if (result.value) {
            axios.post(url).then(() => {
                const archivedIndicator = row.querySelector('.icon-sm');
                const restoreButton = row.querySelector('.btn-restore');
                const buttonGroup = row.querySelector('.btn-group');

                archivedIndicator.classList.remove('text-red');
                archivedIndicator.classList.add('text-transparent');

                restoreButton.remove();
                buttonGroup.innerHTML = buttonGroup.innerHTML + '<button type="button" class="btn btn-sm btn-danger btn-delete" title="Delete"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M432 80h-82.4l-34-56.7A48 48 0 0 0 274.4 0H173.6a48 48 0 0 0-41.2 23.3L98.4 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16l21.2 339a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM173.6 48h100.8l19.2 32H154.4zm173.3 416H101.11l-21-336h287.8z"></path></svg></button>';
            });
        }
    });
});

const rangePickers = document.querySelectorAll('.range-picker');
for (const rangePicker of rangePickers) {
    const newPicker = new Litepicker({
        element: rangePicker,
        firstDay: 1,
        format: 'DD MMM YYYY',
        numberOfMonths: 2,
        numberOfColumns: 2,
        minDate: null,
        maxDate: null,
        minDays: null,
        maxDays: null,
        selectForward: false,
        selectBackward: false,
        splitView: false,
        inlineMode: false,
        singleMode: false,
        autoApply: true,
        showWeekNumbers: false,
        showTooltip: true,
        disableWeekends: false,
        mobileFriendly: true
    });
}

const datePickers = document.querySelectorAll('.date-picker');
for (const datePicker of datePickers) {
    const newPicker = new Litepicker({
        element: datePicker,
        firstDay: 1,
        format: 'DD MMM YYYY',
        minDate: null,
        maxDate: null,
        minDays: null,
        maxDays: null,
        selectForward: false,
        selectBackward: false,
        splitView: false,
        inlineMode: false,
        singleMode: true,
        autoApply: true,
        showWeekNumbers: false,
        showTooltip: true,
        disableWeekends: false,
        mobileFriendly: true
    });
}

function fadeOut(element) {
    (function fade() {
        if ((element.style.opacity -= .1) < 0) {
            element.style.display = 'none';
            element.remove();
        } else {
            requestAnimationFrame(fade);
        }
    })();
};

if (document.querySelector('td.empty-table')) {
    document.querySelector('td.empty-table').colSpan = document.querySelector('.index-table thead').rows[0].cells.length;
}

$('.filter-card').on('expanded.lte.cardwidget', function(event, element) {
    event.preventDefault();

    $(this).find('.filter-expanded-icon').removeClass('d-none').addClass('d-inline-block');
    $(this).find('.filter-collapsed-icon').removeClass('d-inline-block').addClass('d-none');
});

$('.filter-card').on('collapsed.lte.cardwidget', function() {
    $(this).find('.filter-expanded-icon').removeClass('d-inline-block').addClass('d-none');
    $(this).find('.filter-collapsed-icon').removeClass('d-none').addClass('d-inline-block');
});
