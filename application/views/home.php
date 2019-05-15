<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Pesquisa</title>
    <link rel="stylesheet" href="<?php echo base_url()?>assests/dist/themes/default/style.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assests/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assests/css/extra/estilos.css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>assests/images/favicon.ico" />
    <style>
        body {
            background-color: #ecebe8;
        }
    </style>
    
</head>
<body>
    <input type="hidden" id="emailAtual" value="" />
    <div id="principal" class="container main-div rounded">
        <div id="conteudo" style="padding-top: 10px">
            <h3>Bem vindo!</h3>
            <p>
               <br>
               Muito prazer em conhecê-lo. Me chamo Fernando Schuch e preciso da tua ajuda com meu Trabalho de Conclusão, no curso de Sistemas de Informação da Universidade Feevale.
               <br>
               Se você já pesquisou na Internet por opiniões de outras pessoas antes de comprar um produto, deve saber que existem muitas avaliações irrelevantes. Elas não representam a verdadeira experiência de um usuário com um produto, mas mesmo assim, podem influenciar na decisão de compra de outros consumidores. Por exemplo:
               <br>
               <div class="card">
                   <div class="card-header">
                       <p><b>Smartphone XYZ</b></p>
                   </div>
                   <div class="card-body">
                       <p> "Eu quero muito esse celular. Ele me parece muito bom e muito bonito!!!" </p>
                   </div>                
                   
               </div>
               <br>
               O meu objetivo é detectar automaticamente opiniões como essa, utilizando técnicas de Inteligência Artificial. Mas para isso, eu preciso que tu me ajude a classificar outras avaliações sobre mercadorias.<br>
               Não te peço mais que alguns segundos para participar, mas sinta-se à vontade para analisar quantas opiniões quiser.
               <br><br>
               Antes de começar, poderia me informar o teu e-mail?  
            </p>
            <form action="<?php echo base_url()?>index.php/Busca/getInstrucoes" id="formEmail" method="post">
                <div class="form-group">
                    <input type="text" name="edEmail" id="edEmail" class="form-control" style="width:300px; display: inline-block" placeholder="E-mail" />
                    <button type="submit" class="btn btn-success" style="vertical-align: top">Continuar</button>
                </div>
            </form>
        </div>
        <div><br><br><br><br><br>
             <p class="texto-centralizado">
                 Você pode entrar em contato comigo através do e-mail: <a href="mailto:f.schuch@hotmail.com">f.schuch@hotmail.com</a>
             </p>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url() ?>assests/js/jquery.min.js" ></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assests/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assests/js/opiniao.js" ></script>
</body>
</html>