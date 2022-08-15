<script src="{{ asset('main/js/plugins/autocomplete.js') }}"></script>
<script>

var allowedChars = new RegExp(/^[a-zA-Z0-9\s\-\_\.]+$/)
function charsAllowed(value) {
    return allowedChars.test(value);
}

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
        if (charsAllowed(value)) {
            var regex = new RegExp(value, 'gi');
            var inner = item.name.replace(regex, function(match) { return "<span style='font-weight: bold !important'>" + match + "</span>" });
            itemElement.innerHTML = inner;
        } else {
            itemElement.textContent = item.name;
        }
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