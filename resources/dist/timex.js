window.addEventListener('monthLoaded', event => {
    const days = event.detail.fullDays;
    days.forEach(function (day){
        Sortable.create(document.getElementById(day['id']),{
            group: {
                name: "shared",
            },
            animation: 150,
            sort: false,
            setData: function (dataTransfer, dragEl) {
                dataTransfer.setData('id', dragEl.id);
            },
            onStart: function (evt){
            },
            onChoose: function (/**Event*/evt) {
            },
            onMove: function (evt){
                let element = document.getElementById(evt.to.id);
            },
            onEnd: function (evt) {
                const sameDate = evt.from === evt.to;
                if (sameDate) {
                    return;
                }
                const eventId = evt.item.id;
                const fromDate = evt.from.dataset.statusId;
                const toDateID = evt.to.dataset.statusId
                Livewire.emit('onEventChanged',eventId,toDateID)
            },
        })
    })
});

