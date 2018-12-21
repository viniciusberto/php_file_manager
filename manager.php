<?php
if (isset($_POST['extrair'])) {
    extrairArquivo($_POST['extrair'], $_POST['local']);
} elseif (isset($_POST['local'])) {
    $local = $_POST['local'];
    if (is_dir($local)) {
        Show_files($local);
    }
} else {
    Show_files("./");
}

function extrairArquivo($arquivo, $destino)
{
    set_time_limit(0);
    $arquivo = getcwd() . '/' . $arquivo;
    $destino = getcwd() . '/' . $destino;

    $zip = new ZipArchive;
    $zip->open($arquivo);
    if ($zip->extractTo($destino) == TRUE) {
        echo 'Arquivo descompactado com sucesso.';
    } else {
        echo 'O Arquivo não pode ser descompactado.';
    }
    $zip->close();
    return 'Concluido com sucesso!';
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciador de Arquivos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
    <style>
        ul li {
            font-size: 13px;
            display: block;
            /*border: 1px solid black;*/
            text-align: center;
            max-height: 90px;
            max-width: 100px;
            margin: 5px;
            float: left;
            white-space: nowrap;
            overflow: hidden;
        }
        .arq{
            color: #0ab152!important;
        }

        ul li a {
            text-decoration: none !important;
        }

        ul li i {
            font-size: 45px;
        }

        ul li button {
            background: transparent;
            border: none;
        }
    </style>
</head>
<body>
<div class="container col-md-12">
    <?php
    function Show_files($local)
    {
        if (!$local) {
            return false;
        }
        if (!is_dir($local)) {
            echo '<button>' . 'Teste' . '</button>';
        } else {
            echo '<BR>';
            $dir = opendir($local);

            echo '<ul>';
            while ($file = readdir($dir)) {
                if ($file != "." && $file != ".." && $file != ".htaccess") {
                    if (is_dir($local . '/' . $file)) {
                        echo '<form method="POST" action="" >';
                        echo '<input type="hidden" name="local" value="' . $local . '/' . $file . '">';

                        echo '<li data-toggle="tooltip" data-placement="bottom" title="';
                        echo $file;
                        echo '"><button>';
                        echo '<i class="fas fa-folder"></i><br>';
                        echo $file;
                        echo '</button></li>';
                        echo '</form>';
                    }
                    unset($file);
                }
            }
            closedir($dir);


            $dir = opendir($local);
            while ($file = readdir($dir)) {
                if ($file != "." && $file != ".." && $file != ".htaccess") {
                    if (!is_dir($local . '/' . $file)) {
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        $classe = '';
                        switch ($ext) {
                            case 'php':
                                $classe = 'arq fab fa-php';
                                break;
                            case 'zip':
                                $classe = 'arq fas fa-file-archive';
                                break;
                            case 'db':
                                $classe = 'arq fas fa-database';
                                break;
                            case 'png':
                                $classe = 'arq fas fa-file-image';
                                break;
                            case 'ico':
                                $classe = 'arq fas fa-file-image';
                                break;
                            case 'js':
                                $classe = 'arq fab fa-js-square';
                                break;
                            case 'txt':
                                $classe = 'arq fas fa-file-alt';
                                break;
                            case 'config':
                                $classe = 'arq fas fa-cogs';
                                break;
                            case 'css':
                                $classe = 'arq fab fa-css3-alt';
                                break;
                            case 'html':
                                $classe = 'arq ffab fa-html5';
                                break;
                            default:
                                $classe = 'arq fas fa-file';
                                break;

                        }

                        echo '<li data-toggle="modal" data-target="#id-' . str_replace('.', '', $file) . '">';
//
                        echo '<a href="#">';
                        echo '<i class="';
                        echo $classe;
                        echo '"></i><br><p>';
                        echo $file;
                        echo '</p></a></li>';
                        ?>

                        <div class="modal fade" id="<?php echo 'id-' . str_replace('.', '', $file); ?>" tabindex="-1"
                             role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><?php echo $file ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        if ($ext == 'zip') {
                                            ?>
                                            <form method="POST" action="">
                                                <input type="hidden" name="local" value="<?php echo $local; ?>">
                                                <input type="hidden" name="extrair"
                                                       value="<?php echo $local . '/' . $file; ?>">
                                                <button class="btn btn-warning">Extrair</button>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                        <a class="btn btn-success"
                                           href="<?php echo $local . '/' . $file; ?>">Visualizar</a>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php

                    }
                    unset($file);
                }
            }
            echo '</ul>';
            closedir($dir);
            unset($dir);
        }
    }

    ?>
    <script>
        function menuPopup(event) {
            if (event.button == 2) {
                alert('teste');
                $(this).dropdown('toggle');
            }
        }
    </script>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
