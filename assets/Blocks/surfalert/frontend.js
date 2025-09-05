(function(){
    var wrappers = document.getElementsByClassName("surfalert-block-wrapper");

    if(wrappers && wrappers.length){
        for (var i = 0; i < wrappers.length; i++) {
            if(typeof wrappers[i] != 'undefined' && typeof wrappers[i].dataset != 'undefined' && typeof wrappers[i].dataset.sa_id != 'undefined'){
                var sa_id = wrappers[i].dataset.sa_id;
                var link  = wrappers[i].getElementsByTagName("a");
                if(link && link.length && sa_id){
                    link[0].addEventListener("click", function(){
                        var url = surfalertBlockRest.root + 'surfalert/v1/analytics/?frontend=true';
                        fetch(url, {
                            method: 'POST',
                            credentials: 'omit',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                sa_id: sa_id
                            }),
                        });
                    });
                }
            }
        }
    }
})();