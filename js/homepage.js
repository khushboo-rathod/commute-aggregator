function swapItems() {
    var from, to;
    from = document.getElementById('from').value;
    to = document.getElementById('to').value;
    document.getElementById('from').value = to;
    document.getElementById('to').value = from;
}