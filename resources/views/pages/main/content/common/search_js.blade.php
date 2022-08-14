<script src="{{ asset('main/js/plugins/autocomplete.js') }}"></script>
<script>

autocomplete({
    input: document.getElementById('search'),
    minLength: 1,
    onSelect: function (item, inputfield) {
        inputfield.value = item.name
    },
    fetch: async function (text, callback) {
        var match = text.toLowerCase();
        var formData = new FormData();
        formData.append('phrase',match)
        const response = await axios.post('{{$search_url}}', formData)
        callback(response.data.data.filter(function(n) { return n.name.toLowerCase().indexOf(match) !== -1; }));
    },
    render: function(item, value) {
        var itemElement = document.createElement("div");
        // if (charsAllowed(value)) {
        //     var regex = new RegExp(value, 'gi');
        //     var inner = item.label.replace(regex, function(match) { return "<strong>" + match + "</strong>" });
        //     itemElement.innerHTML = inner;
        // } else {
        // }
        itemElement.textContent = item.name;
        return itemElement;
    },
    emptyMsg: "No items found",
    customize: function(input, inputRect, container, maxHeight) {
        if (maxHeight < 100) {
            container.style.top = "";
            container.style.bottom = (window.innerHeight - inputRect.bottom + input.offsetHeight) + "px";
            container.style.maxHeight = "140px";
        }
    }
})
</script>