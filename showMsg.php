     
     <style>
        .alert {
        padding: 8px 35px 8px 14px;
        margin-bottom: 18px;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
        background-color: #fcf8e3;
        border: 1px solid #fbeed5;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        color: #c09853;
        }
        .alert-heading {
        color: inherit;
        }
        .alert .close {
        position: relative;
        top: -2px;
        right: -21px;
        line-height: 18px;
        }
        .alert-success {
        background-color: #dff0d8;
        border-color: #d6e9c6;
        color: #468847;
        }
        .alert-danger,
        .alert-error {
        background-color: #f2dede;
        border-color: #eed3d7;
        color: #b94a48;
        }
        .alert-info {
        background-color: #d9edf7;
        border-color: #bce8f1;
        color: #3a87ad;
        }

     </style>


<?php

    $msg = array(
        
        1    => array (1 => "Registado com sucesso!", 2=> "success"),
        2    => array (1 => "Erro no registo!", 2=> "error"),
        3    => array (1 => "Erro ao autenticar!", 2=> "error"),
        4    => array (1 => "Erro ao alterar dados, autenticação invalida!", 2=> "error"),
        5    => array (1 => "Dados alterados com sucesso!", 2=> "success"),
        6    => array (1 => "Erro ao eliminar a sua conta!", 2=> "error"),
        7    => array (1 => "Dados da sua empresa guardados!", 2=> "success"),
        8    => array (1 => "Erro ao criar empresa!", 2=> "error"),
        9    => array (1 => "Email de conta validado com sucesso!", 2=> "success"),
        10    => array (1 => "Erro validar email da conta!", 2=> "error"),
        11    => array (1 => "Enviamos um email para recuperar a sua conta", 2=> "success"),
        12    => array (1 => "Não encontramos nenhum utilizador com este email associado", 2=> "error"),
        13    => array (1 => "A sua conta encontra-se bloqueada!", 2=> "error"),
        14    => array (1 => "A sua conta encontra-se desativada!", 2=> "error"),
        15    => array (1 => "Foi enviado um email com a nova senha!", 2=> "success"),
        16    => array (1 => "Não foi possivel enviar a nova senha", 2=> "error"),
        17    => array (1 => "Armazem criado com sucesso!", 2=> "success"),
        18    => array (1 => "Erro ao criar um novo armazem", 2=> "error"),
        19    => array (1 => "Artigo criado com sucesso", 2=> "success"),
        20    => array (1 => "Erro ao criar artigo", 2=> "error"),
        21    => array (1 => "Password alterada com sucesso", 2=> "success"),
        22    => array (1 => "Password não foi alterada", 2=> "error"),
        23    => array (1 => "Dados da empresa alterados com sucesso", 2=> "success"),
        24    => array (1 => "Dados da empresa não foram alterados", 2=> "error"),
        25    => array (1 => "Imagem do produto alterada!", 2=> "success"),
        26    => array (1 => "Imagem do produto Eliminada", 2=> "success"),
        27    => array (1 => "Erro ao carregar a imagem", 2=> "error"),
        28    => array (1 => "O ficheiro não é uma imagem!", 2=> "error"),
        29    => array (1 => "O ficheiro já existe!", 2=> "error"),
        30    => array (1 => "O ficheiro é muito grande!", 2=> "error"),
        31    => array (1 => "Só são permitidos ficheiros do tipo JPG, JPEG, PNG & GIF!", 2=> "error"),
        32    => array (1 => "O ficheiro não foi carregado!", 2=> "error"),
        33    => array (1 => "Dados do produto alterados com sucesso", 2=> "success"),
        34    => array (1 => "Dados do produto não foram alterados", 2=> "error"),
        35    => array (1 => "Produto apagado com sucesso", 2=> "success"),
        36    => array (1 => "Produto não foi apagado!", 2=> "error"),
        37    => array (1 => "Stocks atualizados com sucesso", 2=> "success"),
        38    => array (1 => "Ocorreu um erro a atualizar o stock do artigo", 2=> "error"),
        39    => array (1 => "Remover produtos do armazem para poder eliminar!", 2=> "error"),
        40    => array (1 => "Armazem eliminado", 2=> "success"),
        41    => array (1 => "Armazem não eliminado!", 2=> "error"),
        42    => array (1 => "Remover produtos do armazem para poder eliminar!", 2=> "error"),
        43    => array (1 => "Produto removido com sucesso", 2=> "success"),
        44    => array (1 => "Produto não foi removido", 2=> "error"),
        45    => array (1 => "Veiculo foi removido", 2=> "success"),
        46    => array (1 => "Veiculo não foi removido", 2=> "error"),
        47    => array (1 => "Veiculo editado", 2=> "success"),
        48    => array (1 => "Veiculo não editado", 2=> "error"),


        200    => array (1 => "Alterar", 2=> "error"),
        200    => array (1 => "Alterar", 2=> "error"),
        200    => array (1 => "Alterar", 2=> "error"),
        200    => array (1 => "Alterar", 2=> "error"),
        200    => array (1 => "Alterar", 2=> "error"),


        
        404    => array (1 => "Pagina não encontrada", 2=> "error")
        

        


        
    );

    if (isset($_GET['status'])){
        echo "<div class='alert alert-".$msg[$_GET['status']][2]."'>".$msg[$_GET['status']][1]."</div>";
    }
?>