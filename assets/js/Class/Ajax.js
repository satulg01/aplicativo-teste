const Ajax = {
    userToken:  localStorage.getItem("token") ?? "",
    userLogged:  0,
    set_token:  async (token) => {
        await localStorage.setItem("token", token.replace("\"", ""));
        Ajax.userToken = token.replace("\"", "");
    },
    send_request: async (
        url,
        dados,
        ok,
        err,
        progressId = "",
        method = "POST",
        ready = () => {}
    ) => {
        if(Array.isArray(dados)) {
            dados.push({name: "token", value: Ajax.userToken});
        } else {
            dados["token"] = Ajax.userToken;
        }

        await $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
    
                xhr.upload.addEventListener(
                    "progress",
                    function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            $(`#${progressId}`).attr("aria-valuenow", percentComplete);
                            $(`#${progressId}`).css("display", "flex");
                            $(`#${progressId}`).css("width", percentComplete + "%");
                        }
                    },
                    false
                );
    
                // Download progress
                xhr.addEventListener(
                    "progress",
                    function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
    
                            $(`#${progressId}`).attr("aria-valuenow", percentComplete);
                            $(`#${progressId}`).css("display", "flex");
                            $(`#${progressId}`).css("width", percentComplete + "%");
                        }
                    },
                    false
                );
    
                return xhr;
            },
            url: url,
            data: dados,
            type: method,
            done: (result) => {
                ready(result);
            },
            success: (result) => {
                $(`#${progressId}`).attr("aria-valuenow", "100");
                $(`#${progressId}`).css("width", "100%");
                console.log(dados)
                ok(result);
            },
            error: (error) => {
                err(error);
            },
        });
    }
}