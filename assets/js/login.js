function realizar_login(){
    let var_form = $("#form_login");
    var_form.submit((e)=>{
        e.preventDefault();
        let var_email = $("#email").val();
        let var_senha = $("#senha").val()
        $.ajax({
            type: "POST",
            url: "../backend/loginback.php",
            data: {
                email: var_email,
                senha: var_senha
            },
            success: function(response){
                response = JSON.parse(response);
                console.log(response);
                console.log(response.link);
                console.log(response.categoria);

                if(response.status === 1){
                    switch (response.categoria) {
                        case "Aluno":
                            //console.log("hddgdgdbdbbbc");
                            window.location.href=response.link;
                            break;
                        case "Professor":
                            window.location.href=response.link;
                            break;
                        case "Responsavel":
                            window.location.href=response.link;
                            break;
                        case "Administrador":
                            window.location.href=response.link;
                            break;
                    }
                } else if(response.status === -1){
                    alert("Email e/ou senha inválidos. Tente novamente.");
                }
            },
            error: function(erro){
                console.log(erro);
            }
        })
    });
}

