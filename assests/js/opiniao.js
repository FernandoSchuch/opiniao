$(document).ready( function() {
    
    $("#formEmail").submit(function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        var vUrl   = $('#formEmail').attr('action');
        var vEmail = $('#edEmail').val();
        document.getElementById("emailAtual").setAttribute("value", vEmail);
        if (!IsEmail(vEmail))
            alert('Email inválido');
        else {
            $.ajax({
                type : "post",
                url  : vUrl,
                data : {email: vEmail},
                success: function (retorno) {
                    $("#conteudo").empty().append(retorno);
                    window.scrollTo(0, 0);
                }
            });
        }
    });
    
    $(document).on('submit', '#formComecar', function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        var vUrl   = $('#formComecar').attr('action');        
        var vEmail = $('#emailAtual').val();
        $.ajax({
            type : "post",
            url  : vUrl,
            data : {email: vEmail},
            success: function (retorno) {
                //alert(retorno);
                $("#conteudo").empty().append(retorno);
                window.scrollTo(0, 0);
            }
        });
    });
    
    $(document).on('submit', '#formResposta', function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        setResposta(false);
    });
    
    $(document).on('click', '#btFinalizar', function (event){
        event.preventDefault(); // Evita que o action padrão seja disparado (Busca/getNodos)        
        if (document.querySelector('input[name="resposta"]:checked'))
            setResposta(true);
        $.ajax({
            type : "post",
            url  : $("#btFinalizar").attr('livesite'),
            success: function (retorno) {
                $("#conteudo").empty().append(retorno);
                window.scrollTo(0, 0);
            }
        });
    });
    
    function setResposta(finalizando){
        var vUrl   = $('#formResposta').attr('action');
        var vEmail = $('#emailAtual').val();
        if (!document.querySelector('input[name="resposta"]:checked'))
            alert("Por favor, selecione uma das classificações disponíveis.");
        else {
            alert(document.querySelector('input[name="resposta"]:checked').value);
            $.ajax({
                type : "post",
                url  : vUrl,
                data : {email: vEmail, 
                        review: $('#revId').val(),
                        resposta: document.querySelector('input[name="resposta"]:checked').value},
                success: function (retorno) {
                    if (!finalizando){
                        $.ajax({
                            type : "post",
                            url  : retorno,
                            data : {email: vEmail},
                            success: function (ret) {
                                $("#conteudo").empty().append(ret);
                                window.scrollTo(0, 0);
                            }
                        });
                    }
                }
            });
        }
    }
    
    function IsEmail(email){
        return email != ''; 
    }
});