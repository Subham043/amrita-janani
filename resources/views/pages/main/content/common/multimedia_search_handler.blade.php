<script>
    function callSearchHandler(){
        var str= "";
        var arr = [];

        if(document.getElementById('search').value){
            arr.push("search="+document.getElementById('search').value)
        }

        if(document.getElementById('sort').value){
            arr.push("sort="+document.getElementById('sort').value)
        }

        var inputElems = document.getElementsByName("language");
        var languageArr = [];
        for (var i=0; i<inputElems.length; i++) {
            if (inputElems[i].type === "checkbox" && inputElems[i].checked === true){
                languageArr.push(inputElems[i].value);
            }
        }
        if(languageArr.length > 0){
            languageStr = languageArr.join(';');
            arr.push("language="+languageStr)
        }


        str = arr.join('&');
        console.log(str);
        window.location.replace('{{$search_url}}?'+str)
        return false;
    }
</script>