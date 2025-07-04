document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            document.getElementById('loader').style.display = 'flex';
        });
});

document.querySelectorAll('.search_event').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('loader').style.display = 'flex';
        });
});

const xhrOpen = XMLHttpRequest.prototype.open;
XMLHttpRequest.prototype.open = function () {
    this.addEventListener("loadstart", function () {
        document.getElementById("loader").style.display = "flex";
    });
    this.addEventListener("loadend", function () {
        document.getElementById("loader").style.display = "none";
    });
    xhrOpen.apply(this, arguments);
};


// Show loader on select input change
    document.querySelectorAll('.ajax_select_filter').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('loader').style.display = 'flex';
        });
    });


    // Show loader on all link clicks
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('loader').style.display = 'flex';
        });
    });