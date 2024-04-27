function cadastrar(){
    let form = $("#form_registro")
    form.submit(function(e){
        e.preventDefault()
        let nome = $('#nome').val()
        let email = $('#email').val()
        let senha = $('#senha').val()
        let cpf = $('#cpf').val()
        $.ajax({
            type:'POST', 
            url: '../backend/processar_cadastro.php',
            data:{
                nome: nome,
                email: email,
                senha: senha,
                cpf: cpf
            },
            success: function(e){
                let response = JSON.parse(e)
                let message = ''
                
                if(response.email_existe){
                  message += response.email_existe
                }

                if(response.cpf_existe){
                    message += ' '. response.cpf_existe
                }

                if(response.email_invalido){
                    message += ' ' . response.email_invalido
                }

                window.alert(message)
            },
            error: function(e){
                
            }
        })
    })
}