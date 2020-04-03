$("#btnCadastrar").on('click', function () {
        var dados = {name: $("#name").val(), email: $("#email").val(), login: $("login"), password: $("password")};
        var p1=$('#password').val(), p2=$('#password2').val();
            if(p1==p2){
                $.ajax({
                    url: "/api/register",
                    type: "post",
                    data: dados,
                    error: function (request, status, error) {
                        alert(request + " - " + status + " - " + error);
                        console.log(request + " - " + status + " - " + error);
                    },
                    success: function (resp) {
                        alert("Usuário com sucesso:\nID: "+resp.data.rowid +"\nNome: "+resp.data.name);
                        //console.log(resp.data[0].pedido);//data exibe apenas uma posição
                        //window.location.reload();
                        window.location="{{ url('/home') }}";
                    }
                });
            }

    });